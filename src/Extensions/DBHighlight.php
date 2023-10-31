<?php

namespace Goldfinch\Helpers\Extensions;

use Swis\TextSnippet;
use SilverStripe\ORM\DataExtension;
use SilverStripe\ORM\FieldType\DBHTMLText;

class DBHighlight extends DataExtension
{
    public function Highlight($q, $min = 30, $max = 100)
    {
        $snippet = new TextSnippet();
        $snippet->setHighlightTemplate('<strong>%word%</strong>');
        $snippet->setMinWords($min);
        $snippet->setMaxWords($max);

        $html = DBHTMLText::create();
        $html->setValue($snippet->createSnippet($q, $this->owner->RAW()));

        return $html;
    }
}
