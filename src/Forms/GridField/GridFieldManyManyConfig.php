<?php

namespace Goldfinch\Helpers\Forms\GridField;

use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Forms\GridField\GridFieldDetailForm;
use SilverStripe\Forms\GridField\GridFieldEditButton;
use SilverStripe\Forms\GridField\GridField_ActionMenu;
use SilverStripe\Forms\GridField\GridFieldDataColumns;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldFilterHeader;
use SilverStripe\Forms\GridField\GridFieldToolbarHeader;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\GridField\GridFieldSortableHeader;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\GridField\GridFieldPaginator;

class GridFieldManyManyConfig extends GridFieldConfig
{
    public function __construct($itemsPerPage = null, $sortField = 'SortOrder')
    {
        parent::__construct($itemsPerPage);

        $this->addComponents(
            // GridFieldFilterHeader::create(),
            GridFieldAddNewButton::create(),
            GridFieldAddExistingAutocompleter::create(),
            GridFieldToolbarHeader::create(),
            GridFieldSortableHeader::create(),
            GridFieldDataColumns::create(),
            GridFieldDetailForm::create(),
            GridFieldDeleteAction::create(),
            GridFieldEditButton::create(),
            GridField_ActionMenu::create(),
            GridFieldOrderableRows::create($sortField),
            GridFieldPaginator::create(),
        );

        $dataColumns = $this->getComponentByType(GridFieldDataColumns::class);

        $dataColumns->setDisplayFields([
            'Title' => 'Title',
            // 'Link'=> 'URL',
            'LastEdited' => 'Changed',
        ]);

        // $this->addComponent($dataColumns);

        $this->extend('updateConfig');
    }
}
