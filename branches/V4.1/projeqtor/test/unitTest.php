<?php
include_once '../tool/projeqtor.php';
foreach (array('validatedCost', 'validatedWork', 'realCost', 'realWork', 'project') as $val) {
  echo $val.' => '.SqlElement::isVisibleField($val).'<br/>';
}