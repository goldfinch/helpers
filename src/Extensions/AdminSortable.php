<?php

namespace Goldfinch\Helpers\Extensions;

use SilverStripe\Core\Extension;
use UndefinedOffset\SortableGridField\Forms\GridFieldSortableRows;

class AdminSortable extends Extension
{
    public function updateGridFieldConfig(&$config)
    {
        $config->addComponent(GridFieldSortableRows::create('SortOrder'));
    }
}
