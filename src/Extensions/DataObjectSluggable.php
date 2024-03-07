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

    private static $urlsegment_source = 'Title';

    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName(['URLSegment']);
    }

    public function onBeforeWrite()
    {
        parent::onBeforeWrite();

        $urlsegment_source = $this->owner->config()->get('urlsegment_source');

        if (!$this->owner->URLSegment || $this->owner->isChanged($urlsegment_source)) {
            $this->owner->URLSegment = $this->generateURLSegment($this->owner->$urlsegment_source);
        }

        $count = 2;
        while ($this->validURLSegment()) {
            $this->owner->URLSegment =
                preg_replace('/-[0-9]+$/', '', $this->owner->URLSegment ?? '') .
                '-' .
                $count;
            $count++;
        }
    }

    public function generateURLSegment($title)
    {
        $filter = URLSegmentFilter::create();
        $filteredTitle = $filter->filter($title);

        // Fallback to generic page name if path is empty (= no valid, convertable characters)
        if (
            !$filteredTitle ||
            $filteredTitle == '-' ||
            $filteredTitle == '-1'
        ) {
            $filteredTitle = "page-" . $this->owner->ID;
        }

        // Hook for extensions
        $this->owner->extend('updateURLSegment', $filteredTitle, $title);

        return $filteredTitle;
    }

    public function validURLSegment()
    {
        return $this->owner::get()->filter('URLSegment', $this->owner->URLSegment)->exclude('ID', $this->owner->ID)->exists();
    }
}
