<?php

require_once __DIR__ . '/../vendor/autoload.php';

$container = new \Slim\Container();
$container['config'] = require_once __DIR__ . '/../app/settings.php';

require_once __DIR__ . '/../app/dependencies.php';

$app = new \Slim\App($container);

// Register middleware
$app->add(new \Slim\HttpCache\Cache('public', $container['config']['cache_lifetime']));

$app->get('/', function($request, $response) {

    $domain = $this->environment['HTTP_HOST'];

    try {
        $this->sites->load();
        $target = $this->sites->lookup($domain);
    } catch (\Exception $e) {
        $target = (object) array(
            'redirect' => $this->config['sites']['default_url'],
        );
    }

    if (empty($target->status)) {
        $target->status = $this->config['sites']['default_status'];
    }
    $response = $response->withStatus($target->status)
            ->withAddedHeader('Location', $target->redirect);

    return $response;
});

$app->put('/update', function($request, $response) {

    /*
    if ('HTTPS' != $request->getUri()->getScheme()) {
        return $response->withStatus(400);
    }
     */

    $key = $this->config['shared_key'];
    $json = $request->getParsedBody();
    if ($json->key != $key) {
        return $response->withStatus(403);
    }

    $this->sites->update($json->sites);

    $response = $response->withStatus(200)->withAddedHeader('Content-type', 'application/json');
    $response->write(json_encode(array('status' => 'ok')));
});

$app->run();

