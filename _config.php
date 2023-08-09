<?php

use SilverStripe\View\Parsers\ShortcodeParser;

ShortcodeParser::get('default')->register('br', function($arguments, $address, $parser, $shortcode) {
    return '<br>';
});

ShortcodeParser::get('default')->register('sp', function($arguments, $content, $parser, $shortcode) {
    return '<span>' . $content . '</span>';
});
