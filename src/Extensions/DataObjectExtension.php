<?php

namespace App\Extensions;

use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Core\Config\Config;
use SilverStripe\ORM\ValidationResult;

class DataObjectExtension extends DataExtension
{
    private static $required_fields = [];

    private static $field_descriptions = [];

    public function validate(ValidationResult $result)
    {
        // $result = parent::validate();

        $required_fields = $this->owner->config()->get('required_fields');

        foreach ($required_fields as $key => $name)
        {
            $field = $this->owner->dbObject($name);

            if (empty($field->getValue()))
            {
                $result->addError(
                    _t(
                        __CLASS__ . '.REQUIRED_FIELD',
                        '{field} is required',
                        ['field' => $name]
                    )
                );
            }
        }

        return $result;
    }

    public function updateCMSFields(FieldList $fields)
    {
        $field_descriptions = $this->owner->config()->get('field_descriptions');

        foreach($field_descriptions as $field => $description)
        {
            $field = $fields->dataFieldByName($field);

            if ($field)
            {
                $currentDescription = $field->getDescription();
                $field->setDescription($currentDescription ? ('<div>' . $description . '</div>' . $currentDescription) : $description);
            }
        }
    }
}
