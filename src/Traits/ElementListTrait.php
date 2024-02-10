<?php

namespace Goldfinch\Helpers\Traits;

trait ElementListTrait
{
    public function getSummary(): string
    {
        return $this->getDescription();
    }

    public function getType(): string
    {
        $default = $this->i18n_singular_name() ?: 'Block';

        return _t(__CLASS__ . '.BlockType', $default);
    }
}
