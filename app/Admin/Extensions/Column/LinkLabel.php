<?php

namespace App\Admin\Extensions\Column;

use Encore\Admin\Grid\Displayers\AbstractDisplayer;
use Illuminate\Contracts\Support\Arrayable;

class LinkLabel extends AbstractDisplayer
{
    public function display($title_field = 'title', $url_replace_field = 'id', $url_replace = '{{__replace__}}', $style = 'success')
    {

        if ($this->value instanceof Arrayable) {
            $this->value = $this->value->toArray();
        }

        return collect((array) $this->value)->map(function ($item) use ($style, $title_field, $url_replace_field, $url_replace) {
            $href = str_replace('{{__replace__}}', $item[$url_replace_field] ?? '', $url_replace);
            $title = $item[$title_field] ?? '';
            return "<a href='{$href}'><span class='btn btn-{$style} btn-xs'>{$title}</span></a>";
        })->implode('&nbsp;');
    }
}
