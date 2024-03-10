<?php

namespace Goldfinch\Helpers\Extensions;

use SilverStripe\ORM\DataExtension;

class DBTextExtension extends DataExtension
{
    public function EOL($json = false)
    {
        $eolList = explode(PHP_EOL, $this->owner->getValue());

        if ($json) {

            foreach ($eolList as $k => $item) {
                $eolList[$k] = preg_replace('/\s+/', '', trim($item));
            }

            return json_encode($eolList);
        } else {

            $list = new ArrayList();

            foreach ($eolList as $k => $item) {
                $list->push(ArrayData::create([
                    'Line' => preg_replace('/\s+/', '', trim($item)),
                ]));
            }

            return $list;

        }
        return $json ?  : $list;
    }
}
