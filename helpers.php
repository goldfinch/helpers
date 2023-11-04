<?php

use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;
use SilverStripe\Control\Director;
use SilverStripe\Core\Environment;
use SilverStripe\Core\Config\Config;
use Silverstripe\SiteConfig\SiteConfig;

if (! function_exists('get_composer_json')) {
    /**
     * Gets composer.json data
     *
     * @return mixed
     */
    function get_composer_json()
    {
        $path = BASE_PATH . '/composer.json';
        $result = null;

        if (file_exists($path ?? '')) {
            $content = file_get_contents($path ?? '');
            $result = json_decode($content ?? '', true);
            if (json_last_error()) {
                $errorMessage = json_last_error_msg();
                throw new \Exception("$path: $errorMessage");
            }
        }

        return $result;
    }
}

if (! function_exists('ss_template_json_parser')) {
    /**
     * Parse json string from .ss to array
     *
     * @param  string  $string
     * @return mixed
     */
    function ss_template_json_parser($string)
    {
        return json_decode(html_entity_decode($string), true);
    }
}

if (! function_exists('ss_viewable_parser')) {
    /**
     * Parse array to viewable data that can be used in Silverstripe template
     *
     * @param  array  $array
     * @return ArrayData/ArrayList
     */
    function ss_viewable_parser($array)
    {
        array_walk($array, $walker = function (&$value, $key) use (&$walker) {

            if (is_array($value))
            {
                array_walk($value, $walker);

                if (array_is_list($value))
                {
                    $value = new ArrayList($value);
                }
            }
        });

        if (array_is_list($array))
        {
            $array = new ArrayList($array);
        }
        else
        {
            $array = new ArrayData($array);
        }

        return  $array;
    }
}

if (! function_exists('ss_env')) {
    /**
     * Gets the value of an environment variable.
     *
     * @param  string  $key
     * @return mixed
     */
    function ss_env($key)
    {
        return Environment::getEnv($key);
    }
}

if (! function_exists('ss_config')) {
    /**
     * Gets the config property of a class
     *
     * @param  string  $class
     * @param  string  $property
     * @return mixed
     */
    function ss_config(string $class, string $property = null, $subproperty = null)
    {
        $cfg = Config::inst()->get($class, $property);

        if ($cfg && $subproperty)
        {
            if (isset($cfg[$subproperty]))
            {
                return $cfg[$subproperty];
            }
            else
            {
                return null;
            }
        }

        return $cfg;
    }
}

if (! function_exists('ss_siteconfig')) {
    /**
     * Gets the SiteConfig with properties
     *
     * @return mixed
     */
    function ss_siteconfig()
    {
        return SiteConfig::current_site_config();
    }
}

if (! function_exists('ss_isLive')) {
    /**
     * Gets the site environment
     *
     * @return boolean
     */
    function ss_isLive()
    {
        return Director::isLive();
    }
}

if (! function_exists('ss_isDev')) {
    /**
     * Gets the site environment
     *
     * @return boolean
     */
    function ss_isDev()
    {
        return Director::isDev();
    }
}

if (! function_exists('is_sha1')) {
    /**
     * Check if string sha1 format
     *
     * @return boolean
     */
    function is_sha1($str)
    {
        return (bool) preg_match('/^[0-9a-f]{40}$/i', $str);
    }
}
