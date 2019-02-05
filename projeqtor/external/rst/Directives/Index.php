<?php

namespace Gregwar\RST\Directives;

use Gregwar\RST\Directive;
use Gregwar\RST\Parser;
use Gregwar\RST\Nodes\DummyNode;

class Index extends Directive
{
    public function getName()
    {
        return 'index';
    }

    public function processNode(Parser $parser, $variable, $data, array $options)
    {
        return new DummyNode(array('data' => $data, 'options' => $options));
    }
}
