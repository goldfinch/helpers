<?php

namespace Goldfinch\Helpers\Extensions;

use SilverStripe\Core\Extension;

class DefaultAdminServiceExtension extends Extension
{
    public function beforeFindOrCreateDefaultAdmin()
    {
        // ..
    }

    public function afterFindOrCreateDefaultAdmin($admin)
    {
        // ..
    }

    public function beforeFindOrCreateAdmin($email, $name)
    {
        // ..
    }

    public function afterFindOrCreateAdmin($admin)
    {
        // ..
    }
}
