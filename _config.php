<?php

use SilverStripe\Control\Director;
use SilverStripe\Core\Environment;
use SilverStripe\ORM\DB;
use SilverStripe\View\Parsers\ShortcodeParser;

$shortcode = ss_config('Goldfinch\Shortcode\Shortcode');

if ($shortcode && isset($shortcode['allow_shortcodes']['br'])) {
    $ignoreDefaultBR = true;
}

if (! isset($ignoreDefaultBR)) {

    ShortcodeParser::get('default')->register('br', function (
        $arguments,
        $address,
        $parser,
        $shortcode,
    ) {
        return '<br>';
    });
}

ShortcodeParser::get('default')->register('sp', function (
    $arguments,
    $content,
    $parser,
    $shortcode,
) {
    return '<span>'.$content.'</span>';
});

if (Environment::hasEnv('APP_TIMEZONE')) {
    date_default_timezone_set(Environment::getEnv('APP_TIMEZONE'));
}

// to make cli work
if (Director::isDev() && Environment::hasEnv('SS_DATABASE_SOCKET')) {
    ini_set('mysqli.default_socket', Environment::getEnv('SS_DATABASE_SOCKET'));
}

// fixing errors in mysql 5.7+
if (Environment::getEnv('SS_DATABASE_CLASS') == 'MySQLDatabase' && class_exists(DB::class)) {
    DB::query(
        "SET SESSION sql_mode='REAL_AS_FLOAT,PIPES_AS_CONCAT,ANSI_QUOTES,IGNORE_SPACE';",
    );
}
