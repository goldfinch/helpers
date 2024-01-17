<?php

namespace Goldfinch\Helpers\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\Forms\GridField\GridFieldPaginator;
use Symbiote\GridFieldExtensions\GridFieldConfigurablePaginator;

class AdminPaginator extends Extension
{
    public function updateGridFieldConfig(&$config)
    {
        $config
            ->removeComponentsByType(GridFieldPaginator::class)
            ->addComponent(
                GridFieldConfigurablePaginator::create(50, [
                    10,
                    50,
                    100,
                    200,
                    300,
                ]),
            );
    }
}
