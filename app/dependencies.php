<?php

use \App\Models\Sites;

$container->register(new \Slim\HttpCache\CacheProvider);

$container['sites'] = function ($c) {
    $settings = $c['config']['sites'];
    $sites = new Sites($settings['src'], false);
    return $sites;
};
