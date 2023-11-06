<?php

namespace Goldfinch\Helpers\Extensions;

use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;

class DataObjectSluggable extends DataExtension
{
    private static $db = [
        'URLSegment' => 'Int',
    ];

    private static $field_labels = [
        'URLSegment' => 'URL',
    ];

    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName([
            'URLSegment',
        ]);
    }

    public function onBeforeWrite()
    {
        if ($this->owner->Title)
        {
            $this->URLSegment = $this->owner->generateURLSegment($this->owner->Title);

            // Ensure that this object has a non-conflicting URLSegment value.
            // dd($this->validURLSegment());
            $count = 2;
            while (!$this->owner->validURLSegment()) {
                $this->owner->URLSegment = preg_replace('/-[0-9]+$/', '', $this->owner->URLSegment ?? '') . '-' . $count;
                $count++;
            }
        }
    }

    public function generateURLSegment($title)
    {
        $filter = URLSegmentFilter::create();
        $filteredTitle = $filter->filter($title);
        // dd($filteredTitle);
        // Fallback to generic page name if path is empty (= no valid, convertable characters)
        if (!$filteredTitle || $filteredTitle == '-' || $filteredTitle == '-1') {
            $filteredTitle = "object-$this->ID";
        }

        // Hook for extensions
        $this->extend('updateURLSegment', $filteredTitle, $title);

        return $filteredTitle;
    }

    public function validURLSegment()
    {
        $classname = class_name($this->owner);

        $source = $classname::get()->filter([
          'URLSegment' => $this->URLSegment,
        ]);

        if ($this->owner->ID) {
            $source = $source->exclude('ID', $this->owner->ID);
        }

        return !$source->exists();
    }
}
