<?php

namespace Gregwar\RST\HTML\Directives;

use Gregwar\RST\Parser;
use Gregwar\RST\SubDirective;
use Gregwar\RST\Nodes\WrapperNode;

/**
 * Wraps a sub document in a div with a given class
 */
class Wrap extends SubDirective
{
    protected $class;
    protected $uniqid;

    public function __construct($class, $uniqid=false)
    {
        $this->class = $class;
        $this->uniqid = $uniqid;
    }

    public function getName()
    {
        return $this->class;
    }

    public function processSub(Parser $parser, $document, $variable, $data, array $options)
    {
        $class = $this->class;
        if ($class=='tabularcolumns' or $class=='only') {
          return;
        }
        if ($this->uniqid) {
            $id = ' id="'.uniqid($this->class).'"';
        } else {
            $id = '';
        }
        $title="";
        $wrapAs=($class=='rubric')?'p':'div';
        if ($class=='noteblock') {
          $wrapAs='div';
          $class=' admonition note blockquote';
          $title='<p class="first admonition-title">Note</p>';
          if ($data) $title.='<p>'.$data.'</p>';
        } else if ($class=='note') {
          $class='admonition note';
          $title='<p class="first admonition-title">Note</p>';
          if ($data) $title.='<p>'.$data.'</p>';
        } else if ($class=='warning' or $class=='attention' or $class=='important') {
          $title='<p class="first admonition-title">'.ucfirst($class).'</p>';
          $class='admonition '.$class;
          if ($data) $title.='<p>'.$data.'</p>';
        } else if ($class=='hint') {
            //$class='admonition note';
            $title='<p class="first admonition-title">Hint</p>';
            if ($data) $title.='<p>'.$data.'</p>';
        } else if ($class=='contents') {
          $class='admonition note';
          $title=(($data)?'<p class="first admonition-title">'.$data.'</p>':'').'<ul><li><a>(unresolved)</a></li></ul>';
        } else if ($class=='describe') { 
          $title='<code class="descname">'.$data.'</code>';
          $wrapAs='dd';
        } else if ($class=='list-table') {
          $title='<div style="width:100%;text-align:center">'.$data.'</div>';
        } else if ($data) {
          $title='<p class="first admonition-title">'.$data.'</p>';
        }
        
        return new WrapperNode($document, '<'.$wrapAs.' class="'.$class.'"'.$id.'>'.$title, '</'.$wrapAs.'>');
    }
}
