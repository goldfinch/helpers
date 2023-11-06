<?php

namespace Goldfinch\Helpers\Extensions;

use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;
use SilverStripe\View\Parsers\URLSegmentFilter;

class DataObjectSluggable extends DataExtension
{
    private static $db = [
        'URLSegment' => 'Varchar',
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
            if (property_exists($this->owner, 'urlsegment_source'))
            {
                $urlSourceName = $this->owner->urlsegment_source;
                $urlSource = $this->owner->$urlSourceName;
            }
            else
            {
                $urlSource = $this->owner->Title;
            }

            $this->owner->URLSegment = $this->owner->generateURLSegment($urlSource);

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

        $this->owner->extend('updateURLSegment', $filteredTitle, $title);

        return $filteredTitle;
    }

    public function validURLSegment()
    {
        $classname = get_class($this->owner);

        $source = $classname::get()->filter([
          'URLSegment' => $this->owner->URLSegment,
        ]);

        if ($this->owner->ID) {
            $source = $source->exclude('ID', $this->owner->ID);
        }

        return !$source->exists();
    }
}
