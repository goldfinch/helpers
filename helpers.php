<?php

use SilverStripe\Core\Environment;
use SilverStripe\Core\Config\Config;
use Silverstripe\SiteConfig\SiteConfig;
use SilverStripe\Control\Director;

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
    function ss_config(string $class, string $property = null)
    {
        return Config::inst()->get($class, $property);
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
