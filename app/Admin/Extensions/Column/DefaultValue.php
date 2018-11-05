<?php

namespace App\Admin\Extensions\Column;

use Encore\Admin\Grid\Displayers\AbstractDisplayer;

class DefaultValue extends AbstractDisplayer
{
    public function display($value = '无')
    {
        if (blank($this->value)) {
            $this->value = $value;
        }

        return $this->value;
    }
}
