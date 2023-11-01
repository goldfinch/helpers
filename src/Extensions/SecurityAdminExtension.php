<?php

namespace Goldfinch\Helpers\Extensions;

use SilverStripe\ORM\DataList;
use SilverStripe\Security\Member;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Security\Security;
// use SilverStripe\Forms\GridField\GridFieldPrintButton;
// use SilverStripe\Forms\GridField\GridFieldExportButton;
// use SilverStripe\Forms\GridField\GridFieldImportButton;

class SecurityAdminExtension extends DataExtension
{
    public function updateList(DataList &$list)
    {
        if ($list->dataClass === Member::class)
        {
            if (Security::getCurrentUser()->Email !== ss_env('SS_DEFAULT_ADMIN_USERNAME'))
            {
                $list = $list->filter('email:not', ss_env('SS_DEFAULT_ADMIN_USERNAME'));
            }
        }
    }

    // public function updateGridFieldConfig($config)
    // {
    //     $config->removeComponentsByType(GridFieldExportButton::class);
    //     $config->removeComponentsByType(GridFieldPrintButton::class);
    //     $config->removeComponentsByType(GridFieldImportButton::class);
    // }
}
