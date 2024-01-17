<?php

use SilverStripe\ORM\ArrayList;
use SilverStripe\View\SSViewer;
use SilverStripe\View\ArrayData;
use SilverStripe\Control\Director;
use SilverStripe\Core\Environment;
use SilverStripe\Core\Config\Config;
use SilverStripe\ORM\FieldType\DBText;
use Silverstripe\SiteConfig\SiteConfig;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\View\Parsers\ShortcodeParser;

if (!function_exists('get_composer_json')) {
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

if (!function_exists('ss_template_json_parser')) {
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

if (!function_exists('str_to_html')) {
    /**
     * Convert string to html
     *
     * @param  string  $string
     * @param  boolean  $force (false: only strings that has html will be converted)
     * @return DBHTMLText
     */
    function str_to_html($string, $force = true)
    {
        if (!is_string($string)) {
            return $string;
        }

        if ($force) {
            $html = DBHTMLText::create();
            $html->setValue($string);
        } elseif ($string != strip_tags($string)) {
            $html = DBHTMLText::create();
            $html->setValue($string);
        } else {
            $html = $string;
        }

        $html = ShortcodeParser::get_active()->parse($html);

        return $html;
    }
}

if (!function_exists('ss_viewable_parser')) {
    /**
     * Parse array to viewable data that can be used in Silverstripe template
     *
     * @param  array  $array
     * @return ArrayData/ArrayList
     */
    function ss_viewable_parser($array)
    {
        array_walk(
            $array,
            $walker = function (&$value, $key) use (&$walker) {
                if (is_array($value)) {
                    array_walk($value, $walker);

                    if (array_is_list($value)) {
                        foreach ($value as $k => $v) {
                            $dbtext = DBText::create();
                            $dbtext->setValue(str_to_html($v, false));
                            $value[$k] = $dbtext;
                        }

                        $value = new ArrayList($value);
                    }
                } else {
                    $value = str_to_html($value, false);
                }
            },
        );

        foreach ($array as $k => $v) {
            $array[$k] = str_to_html($v, false);
        }

        if (array_is_list($array)) {
            $array = new ArrayList($array);
        } else {
            $array = new ArrayData($array);
        }

        return $array;
    }
}

if (!function_exists('ss_env')) {
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

if (!function_exists('ss_theme')) {
    /**
     * Get current theme
     */
    function ss_theme()
    {
        // $theme = SSViewer::get_themes();
        $theme = ss_config(SSViewer::class)['themes'];
        return isset($theme[1]) ? $theme[1] : null;
    }
}

if (!function_exists('ss_theme_template_file_exists')) {
    /**
     * Check if template exists
     *
     * eg ($template: 'Partials/Forms/Contact')
     *
     * @param  string  $template
     * @return mixed
     */
    function ss_theme_template_file_exists($template)
    {
        $fullpath =
            THEMES_PATH . '/' . ss_theme() . '/templates/' . $template . '.ss';

        return file_exists($fullpath);
    }
}

if (!function_exists('ss_config')) {
    /**
     * Gets the config property of a class
     *
     * @param  string  $class
     * @param  string  $property
     * @return mixed
     */
    function ss_config(
        string $class,
        string $property = null,
        $subproperty = null,
    ) {
        $cfg = Config::inst()->get($class, $property);

        if ($cfg && $subproperty) {
            if (isset($cfg[$subproperty])) {
                return $cfg[$subproperty];
            } else {
                return null;
            }
        }

        return $cfg;
    }
}

if (!function_exists('ss_siteconfig')) {
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

if (!function_exists('ss_isLive')) {
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

if (!function_exists('app_encrypt')) {
    /**
     * Gets short class name
     *
     * @param string $class
     * @param int $keypart
     * @return string
     */
    function app_encrypt($class, $keypart = 10)
    {
        $key = Environment::getEnv('APP_KEY');
        return sha1($class . substr($key, $keypart));
    }
}

if (!function_exists('get_class_name')) {
    /**
     * Gets short class name
     *
     * @param string
     * @return string
     */
    function get_class_name($class)
    {
        return last(explode('\\', $class));
    }
}

if (!function_exists('ss_isDev')) {
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

if (!function_exists('is_sha1')) {
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

if (!function_exists('google_maps_preview')) {
    /**
     * Get Google Maps preview image
     *
     * eg:
     * latitude: -45.0130461
     * longitude: 168.7430014
     * zoom: 19
     * scale: 2 (1/2)
     * size: 260x180
     * key: AIzaSyBbJ6....
     *
     * @return string
     */
    function google_maps_preview(
        $latitude,
        $longitude,
        $zoom,
        $dimensions,
        $scale = 0,
        $key = null,
    ) {
        if (!$key && Environment::hasEnv('APP_GOOGLE_MAPS_KEY')) {
            $key = Environment::getEnv('APP_GOOGLE_MAPS_KEY');
        }

        return 'https://maps.googleapis.com/maps/api/staticmap?center=' .
            $latitude .
            ',' .
            $longitude .
            '&zoom=' .
            $zoom .
            '&scale=' .
            $scale .
            '&size=' .
            $dimensions .
            '&key=' .
            $key;
    }
}
