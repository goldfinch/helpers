<?php

namespace Goldfinch\Helpers\Extensions;

use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;

class DataObjectSortable extends DataExtension
{
    private static $db = [
        'SortOrder' => 'Int',
    ];

    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName([
            'Sort',
            'SortOrder',
        ]);
    }
}
