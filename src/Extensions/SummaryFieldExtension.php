<?php

namespace Goldfinch\Helpers\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\ORM\FieldType\DBHTMLText;

class SummaryFieldExtension extends Extension
{
    private static $summary_fields = [
        'GridItemSummary' => 'Summary',
    ];

    public function GridItemSummary()
    {
        $html = DBHTMLText::create();

        $str = '';

        $str .= '<div style="display: flex; flex-wrap: wrap; min-height: 100px; align-items: center; align-content: center;">';
        foreach ($this->owner->GridItemSummaryList() as $label => $value) {
            if ($label == 'Image') {
                $str = '<div style="width: 100px; float: left; margin-right: 20px; border-radius: 10px; overflow: hidden">' . $value . '</div>' . $str;
                continue;
            }

            if ($label[0] == '-') {
                $label = '';
            } else {
                $label = '<span style="color: #666; font-weight: 600">'.$label.':</span> ';
            }

            $str .= '<div style="margin-bottom: 10px; width: 100%">'.$label.'<span>'.$value.'</span></div>';
        }
        $str .= '</div>';

        return $html->setValue($str);
    }

    public function GridItemSummaryList()
    {
        $list = [
            '-Title' => '<span style="display: block; font-size: 14px; font-weight: 600; min-width: 350px">' . $this->owner->Title . '</span>',
        ];

        if (method_exists($this->owner, 'updateGridItemSummaryList')) {
            $this->owner->updateGridItemSummaryList($list);
        }

        return $list;
    }
}
