<?php

namespace Goldfinch\Helpers\Providers;

use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;
use SilverStripe\Control\Controller;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\View\TemplateGlobalProvider;
use Goldfinch\Imaginarium\Views\ImagePlaceholder;

class HelpersTemplateProvider implements TemplateGlobalProvider
{
    /**
     * @return array|void
     */
    public static function get_template_global_variables(): array
    {
        return [
            'env',
            'dd',
            'paramGet',
            'paramRequest',
            'strParser',
            'strSplit',
            'strPhone',
            'findObject',
            'findObjects',
            'hrefPhone',
            'hrefEmail',
            'ss_replace',
            'fakeList',
            'fakeImage',
        ];
    }

    public static function fakeList($count)
    {
        $list = ArrayList::create();

        for ($i = 0; $i < $count; $i++) {
            $list->push(ArrayData::create());
        }

        return $list;
    }

    public static function fakeImage(...$args)
    {
        return ImagePlaceholder::create(...$args);
    }

    /**
     * Helps to find & replace within a string that passed as an argument in the function in .ss
     *
     * eg: $Vite.image($ss_replace('../../assets/img/{$find1}/solid/{$find2}.svg', $find1, $replace1, $find2, $replace2))
     *
     * @return string
     *
     * $filter array eg: findObject(App\Page, '{"NestedPseudo": 0, "NestedRedirectPageID": 0}')
     */
    public static function ss_replace($str, ...$args)
    {
        $flyStr = null;
        $search = null;
        $replace = null;

        foreach ($args as $arg) {
            if ($search === null) {
                $search = $arg;
            } else {
                $replace = $arg;
            }

            if ($search && $replace) {
                $str = str_replace($search, $replace, $str);

                $flyStr = null;
                $search = null;
                $replace = null;
            }
        }

        return $str;
    }

    /**
     * @return string
     *
     * $filter array eg: findObject(App\Page, '{"NestedPseudo": 0, "NestedRedirectPageID": 0}')
     */
    public static function findObject($class, $filter = [])
    {
        return self::findObjects($class, $filter)->first();
    }

    /**
     * @return string
     *
     * $filter array eg: findObject(App\Page, '{"NestedPseudo": 0, "NestedRedirectPageID": 0}')
     */
    public static function findObjects($class, $filter = [])
    {
        $filter = $filter ? json_decode($filter, true) : [];

        return $class::get()->filter($filter);
    }

    /**
     * @return string
     */
    public static function env($var)
    {
        return ss_env($var);
    }

    /**
     * @return string
     */
    public static function paramGet($param)
    {
        return isset($_GET[$param]) && !empty($_GET[$param])
            ? $_GET[$param]
            : false;
    }

    /**
     * @return string
     */
    public static function paramRequest($param)
    {
        if (Controller::has_curr()) {
            $ctrl = Controller::curr();

            if ($ctrl) {
                $request = $ctrl->getRequest();

                if ($request) {
                    return $request->param($param);
                }
            }
        }

        return false;
    }

    public static function dd(mixed ...$vars)
    {
        return dd($vars);
    }

    /**
     * @return DBHTMLText
     */
    public static function strParser($title, $tag = 'span', $attrs = null)
    {
        $title = preg_replace(
            '/##/',
            '<' . $tag . ($attrs ? ' ' . $attrs : '') . '>',
            $title,
            1,
        );
        $title = preg_replace('/##/', '</' . $tag . '>', $title, 2);

        $title = preg_replace(
            '/\[/',
            '<' . $tag . ($attrs ? ' ' . $attrs : '') . '>',
            $title,
            1,
        );
        $title = preg_replace('/\]/', '</' . $tag . '>', $title);

        $title = preg_replace(
            '/\(\(/',
            '<' . $tag . ($attrs ? ' ' . $attrs : '') . '>',
            $title,
        );
        $title = preg_replace('/\)\)/', '</' . $tag . '>', $title);

        $title = preg_replace('/\^|\|/', '<br>', $title);

        $output = DBHTMLText::create();
        $output->setValue($title);

        return $output;
    }

    /**
     * @return DBHTMLText
     */
    public static function strSplit($str)
    {
        $list = new ArrayList();

        $parts = explode(PHP_EOL, $str);

        foreach ($parts as $part) {
            $output = DBHTMLText::create();
            $list->push(new ArrayData(['Text' => $output->setValue($part)]));
        }

        return $list;
    }

    /**
     * @return String
     */
    public static function strPhone($phone, $plus = true)
    {
        $phone = explode(' (', $phone);
        $phone = $phone[0];

        $phone = preg_replace('/\D/', '', $phone);

        if (substr($phone, 0, 4) == '0800') {
            $plus = false;
        } elseif (substr($phone, 0, 3) == '640') {
            $phone = '64' . substr($phone, 3);
        } elseif (substr($phone, 0, 1) == '0') {
            $phone = '64' . substr($phone, 1);
        }

        return $plus ? '+' . $phone : $phone;
    }

    public static function hrefPhone($str)
    {
        return 'tel:' . self::strPhone($str);
    }

    public static function hrefEmail($str)
    {
        return 'mailto:' . $str;
    }
}
