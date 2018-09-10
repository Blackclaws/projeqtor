<?php

namespace Gregwar\RST\HTML;

use Gregwar\RST\Kernel as Base;

class Kernel extends Base
{
    public function getName()
    {
        return 'HTML';
    }

    public function getDirectives()
    {
        $directives = parent::getDirectives();

        $directives = array_merge($directives, array(
            new Directives\Image,
            new Directives\Figure,
            new Directives\Meta,
            new Directives\Stylesheet,
            new Directives\Title,
            new Directives\Url,
            new Directives\Div,
            new Directives\Compound,
            new Directives\Compoundblock,
            new Directives\Wrap('note'),
            new Directives\Wrap('noteblock'),
            new Directives\Wrap('warning'),
            new Directives\Wrap('attention'),
            new Directives\Wrap('important'),
            new Directives\Wrap('admonition'),
            new Directives\Wrap('only'),
            new Directives\Wrap('hint'),
            new Directives\Wrap('topic'),
            new Directives\Wrap('rubric'),
            new Directives\Wrap('sidebar'),
            new Directives\Wrap("glossary"),
            new Directives\Wrap("contents"),
            new Directives\Wrap("describe"),
            new Directives\Wrap("list-table"),
            new Directives\Wrap("tabularcolumns"),
        ));

        return $directives;
    }

    public function getFileExtension()
    {
        return 'html';
    }
}
