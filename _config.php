<?php

use SilverStripe\View\Parsers\ShortcodeParser;

ShortcodeParser::get('default')->register('br', function($arguments, $address, $parser, $shortcode) {
    return '<br>';
});
