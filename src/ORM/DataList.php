<?php

namespace Goldfinch\Helpers\ORM;

use SilverStripe\ORM\DataList as SSDataList;

class DataList extends SSDataList
{
    public function toJson(...$fields)
    {
        $results = [];

        foreach ($this as $item) {
            $fieldsToPass = [];

            foreach ($fields as $field) {
                if (strpos($field, ':') === false) {
                    $fieldsToPass[$field] = $item->$field;
                } else {
                    $ex = explode(':', $field);
                    $relationship = $ex[0];
                    $relFields = explode(',', $ex[1]);
                    $st = singleton($this->dataClass);
                    $relationshipType = $st->getRelationType($relationship);

                    if (
                        $relationshipType &&
                        ($relationshipType == 'has_one' || $relationshipType == 'belongs_to')
                    ) {
                        $fieldsToPass[$relationship] = [];

                        $relationItem = $item->$relationship();

                        foreach ($relFields as $rfField) {
                            $fieldsToPass[$relationship][$rfField] = $relationItem->$rfField;
                        }
                    } elseif (
                        $relationshipType == 'many_many' ||
                        $relationshipType == 'has_many' ||
                        $relationshipType == 'belongs_many_many'
                    ) {
                        $fieldsToPass[$relationship] = [];

                        foreach ($item->$relationship() as $relationItem) {

                            foreach ($relFields as $rfField) {
                                $fieldsToPass[$relationship][$relationItem->ID][$rfField] = $relationItem->$rfField;
                            }
                        }
                    }
                }
            }

            if (!empty($fieldsToPass)) {
                $results[] = $fieldsToPass;
            }
        }

        return json_encode($results);
    }
}
