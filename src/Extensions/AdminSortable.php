<?php

namespace Goldfinch\Helpers\Extensions;

use SilverStripe\Core\Extension;
use Goldfinch\Helpers\Extensions\DataObjectSortable;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
// use UndefinedOffset\SortableGridField\Forms\GridFieldSortableRows;

class AdminSortable extends Extension
{
    public function updateGridFieldConfig(&$config)
    {
        if (
            in_array('SortOrder', ss_config($this->owner->modelClass, 'db')) ||
            in_array(DataObjectSortable::class, ss_config($this->owner->modelClass, 'extensions'))
        )
        {
            $config->addComponent(GridFieldOrderableRows::create('SortOrder')->setRepublishLiveRecords(true));

            // $config->addComponent($sortable = GridFieldSortableRows::create('SortOrder'));
            // $sortable->setUpdateVersionedStage('Live');
            // $sortable->setUpdateVersionedStage('Versions');
        }
    }
}
