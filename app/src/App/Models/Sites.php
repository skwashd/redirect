<?php
/**
 * Sites model.
 */

namespace App\Models;

use \App\Exceptions\DataNotLoadedException;
use \App\Exceptions\DomainNotFoundException;
use \App\Exceptions\FileNotFoundException;
use \App\Exceptions\FileReadException;
use \App\Exceptions\InvalidJsonException;

/**
 * Class for retreiving sites data.
 */
class Sites
{
    /**
     * Tracks if the JSON data has been loadeed.
     */
    protected $loaded = false;

    /**
     * The loaded sites data.
     */
    protected $sites = array();

    /**
     * Constructor
     *
     * @param string $filename
     *  The full path and filename of the sites JSON file.
     */
    public function __construct($filename, $load = true)
    {
        $this->filename = $filename;
        if ($load) {
            $this->load();
        }
    }

    /**
     * Loads and processed the sites data JSON file.
     *
     * @param string $filename
     *  The full path and filename of the sites JSON file.
     * @throws \App\Exceptions\FileNotFoundException if file doesn't exist.
     * @throws \App\Exceptions\FileReadException if unable to read the file.
     * @throws \App\Exceptions\InvalidJsonException if JSON is not well formed.
     */
    public function load($filename = null)
    {
        if (null !== $filename) {
            $this->filename = $filename;
        }

        // Adopt the UNIX approach to finding files. It must be a readable file.
        if (!is_file($this->filename) || !is_readable($this->filename)) {
            throw new FileNotFoundException($this->filename);
        }

        $json = file_get_contents($this->filename);
        if (false === $json) {
            throw new FileReadException($this->filename);
        }

        $sites = json_decode($json);
        if (null == $sites) {
            throw new InvalidJsonException($this->filename);
        }

        $this->loaded = true;
        $this->sites = $sites;
    }

    /**
     * Looks up a site.
     *
     * @param string $domain
     *  The domain to lookup.
     *
     * @return string
     *  The related domain object.
     *
     * @throws \App\Exceptions\DomainNotFound
     */
    public function lookup($domain)
    {
        if (!$this->loaded) {
            throw new DataNotLoadedException(null);
        }

        if (false !== strpos($domain, ':')) {
            $domain = explode($domain, ':')[0];
        }

        if ('www.' === substr($domain, 0, 4)) {
            $domain = substr($domain, 4);
        }

        if (empty($this->sites->{$domain})) {
            throw new DomainNotFoundException($domain);
        }

        return (object) $this->sites->{$domain};
    }

    /**
     * Updates the sites file
     *
     * @param array $data
     *   The sites data to store.
     *
     * @throws FileWriteException if unable to write to the file.
     */
    public function update($data)
    {
        $json = json_encode($data);
        $result = file_put_contents($this->filename, $json);
        if (false === $result) {
            throw new FileWriteException($this->filename);
        }
    }
}
