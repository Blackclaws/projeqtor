<?php 
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2016 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
 * Contributors : -
 *
 * This file is part of ProjeQtOr.
 * 
 * ProjeQtOr is free software: you can redistribute it and/or modify it under 
 * the terms of the GNU Affero General Public License as published by the Free 
 * Software Foundation, either version 3 of the License, or (at your option) 
 * any later version.
 * 
 * ProjeQtOr is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS 
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for 
 * more details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * ProjeQtOr. If not, see <http://www.gnu.org/licenses/>.
 *
 * You can get complete code of ProjeQtOr, other resource, help and information
 * about contributors at http://www.projeqtor.org 
 *     
 *** DO NOT REMOVE THIS NOTICE ************************************************/

/* ============================================================================
 * This abstract class is design to handle and control $_REQUEST values
 */  
require_once('_securityCheck.php');
abstract class RequestHandler {

  public static function getValue($code,$required=false,$default=null) {
    if (isset($_REQUEST[$code])) {
      return $_REQUEST[$code];
    } else {
      if ($required) {
        throwError("parameter '$code' not found in Request");
        exit;
      } else {
        return $default;
      }  
    }
  }
  
  public static function getClass($code,$required=false,$default=null) {
    $val=self::getValue($code,$required,$default);
    if ($val==$default) return $val;
    return Security::checkValidClass($val);
  }
  
  public static function getId($code,$required=false,$default=null) {
    $val=self::getValue($code,$required,$default);
    if ($val==$default) return $val;
    return Security::checkValidId($val);
  }
  
  public static function getNumeric($code,$required=false,$default=null) {
    $val=self::getValue($code,$required,$default);
    if ($val==$default) return $val;
    return Security::checkValidNumeric($val);
  }
  
  public static function getAlphanumeric($code,$required=false,$default=null) {
    $val=self::getValue($code,$required,$default);
    if ($val==$default) return $val;
    return Security::checkValidAlphanumeric($val);
  }
  
  public static function getDatetime($code,$required=false,$default=null) {
    $val=self::getValue($code,$required,$default);
    if ($val==$default) return $val;
    return Security::checkValidDateTime($val);
  }
  
  public static function getYear($code,$required=false,$default=null) {
    $val=self::getValue($code,$required,$default);
    if ($val==$default) return $val;
    return Security::checkValidYear($val);
  }
  
  public static function getMonth($code,$required=false,$default=null) {
    $val=self::getValue($code,$required,$default);
    if ($val==$default) return $val;
    return Security::checkValidMonth($val);
  }
  public static function getExpected($code,$expectedList) {
    $val=self::getValue($code,true,null);
    if (in_array($val, $expectedList)) {
      return $val;
    } else {
      throwError("parameter $code='$val' has an unexpected value");
      exit;
    }
  }
  
}
?>