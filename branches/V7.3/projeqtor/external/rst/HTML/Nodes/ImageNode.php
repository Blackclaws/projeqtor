<?php

namespace Gregwar\RST\HTML\Nodes;

use Gregwar\RST\Nodes\ImageNode as Base;

class ImageNode extends Base
{
    public function render()
    {
        $attributes = '';
        foreach ($this->options as $key => $value) {
          if ($key=='scale') {
            $attributes .= ' style="zoom:'.(intval($value)/100).'"';
          } else {
            $attributes .= ' '.$key . '="'.htmlspecialchars($value).'"';
          }
        }

        return '<img src="'.$this->url.'" '.$attributes.' />';
    }
}
