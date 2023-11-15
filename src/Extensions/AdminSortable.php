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
            $versioned = true;

            $model = new $this->owner->modelClass();

            if (!method_exists($model, 'isLiveVersion'))
            {
                try {
                    $model->isLiveVersion();
                } catch (\BadMethodCallException $e) {
                    $versioned = false;
                }
            }

            // dd($this->owner->isLiveVersion());

            $config->addComponent(GridFieldOrderableRows::create('SortOrder')->setRepublishLiveRecords($versioned));

            // $config->addComponent($sortable = GridFieldSortableRows::create('SortOrder'));
            // $sortable->setUpdateVersionedStage('Live');
            // $sortable->setUpdateVersionedStage('Versions');
        }
    }
}
