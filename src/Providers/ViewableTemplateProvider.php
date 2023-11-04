<?php

namespace Goldfinch\Helpers\Providers;

class ViewableTemplateProvider implements TemplateGlobalProvider
{
    public static function get_template_global_variables(): array
    {
        return [
            'ViewJson',
            'ViewArray',
        ];
    }

    public static function ViewJson($string)
    {
        $array = ss_template_json_parser($string);

        return ss_viewable_parser($array);
    }

    public static function ViewArray($array)
    {
        return ss_viewable_parser($array);
    }
}
