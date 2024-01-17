<?php

namespace Goldfinch\Helpers\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\Forms\GridField\GridFieldPrintButton;
use SilverStripe\Forms\GridField\GridFieldExportButton;
use SilverStripe\Forms\GridField\GridFieldImportButton;

class AdminPlain extends Extension
{
    public function updateGridFieldConfig(&$config)
    {
        $config
            ->removeComponentsByType(GridFieldExportButton::class)
            ->removeComponentsByType(GridFieldPrintButton::class)
            ->removeComponentsByType(GridFieldImportButton::class);
    }
}
