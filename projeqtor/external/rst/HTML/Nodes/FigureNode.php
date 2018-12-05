<?php

namespace Gregwar\RST\HTML\Nodes;

use Gregwar\RST\Nodes\FigureNode as Base;

class FigureNode extends Base
{
    public function render()
    {
        $html = '<div class="figure align-center">';
        $html .= $this->image->render();
        if ($this->document) {
            $caption = trim($this->document->render());
            if ($caption) {
                $html .= '<span class="caption-text">'.$caption.'</span>';
            }
        }
        $html .= '</div>';

        return $html;
    }
}
