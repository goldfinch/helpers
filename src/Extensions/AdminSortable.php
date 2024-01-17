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
            isset(ss_config($this->owner->modelClass, 'db')['SortOrder']) ||
            in_array('SortOrder', ss_config($this->owner->modelClass, 'db')) ||
            isset(ss_config($this->owner->modelClass, 'db')['SortExtra']) ||
            in_array('SortExtra', ss_config($this->owner->modelClass, 'db')) ||
            in_array(
                DataObjectSortable::class,
                ss_config($this->owner->modelClass, 'extensions'),
            )
        ) {
            $versioned = true;

            $model = new $this->owner->modelClass();

            if (!method_exists($model, 'isLiveVersion')) {
                try {
                    $model->isLiveVersion();
                } catch (\BadMethodCallException $e) {
                    $versioned = false;
                }
            }

            // dd($this->owner->isLiveVersion());

            if (
                isset(ss_config($this->owner->modelClass, 'db')['SortExtra']) ||
                in_array('SortExtra', ss_config($this->owner->modelClass, 'db'))
            ) {
                $sortField = 'SortExtra';
            } elseif (
                isset(ss_config($this->owner->modelClass, 'db')['SortOrder']) ||
                in_array('SortOrder', ss_config($this->owner->modelClass, 'db'))
            ) {
                $sortField = 'SortOrder';
            }

            $config->addComponent(
                GridFieldOrderableRows::create(
                    $sortField,
                )->setRepublishLiveRecords($versioned),
            );

            // $config->addComponent($sortable = GridFieldSortableRows::create($sortField));
            // $sortable->setUpdateVersionedStage('Live');
            // $sortable->setUpdateVersionedStage('Versions');
        }
    }
}
