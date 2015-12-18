<?php
/*** COPYRIGHT NOTICE *********************************************************
 *
* Copyright 2009-2015 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
* Contributors : -
*
* This file is part of ProjeQtOr.
*
* ProjeQtOr is free software: you can redistribute it and/or modify it under
* the terms of the GNU General Public License as published by the Free
* Software Foundation, either version 3 of the License, or (at your option)
* any later version.
*
* ProjeQtOr is distributed in the hope that it will be useful, but WITHOUT ANY
* WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
* FOR A PARTICULAR PURPOSE.  See the GNU General Public License for
* more details.
*
* You should have received a copy of the GNU General Public License along with
* ProjeQtOr. If not, see <http://www.gnu.org/licenses/>.
*
* You can get complete code of ProjeQtOr, other resource, help and information
* about contributors at http://www.projeqtor.org
*
*** DO NOT REMOVE THIS NOTICE ************************************************/
require_once('_securityCheck.php');
class Security
{
  private static $continueOnError=false; // TODO (SECURITY) : give possibility to continue
  // Must be disabled after each test to be forced before required test
  
  function __construct($name = NULL) {
    traceHack("Static Class Security must not be instanciated");
  }
  /* Security fonctions to check validity of input values
   *  =========
  *  ATTENTION : these functions concider that not allowed values are Hack attemps, disconnecting user and exiting script
  *  =========
  *  checkValidClass($className) : $className is a valid string corresponding to a valid class extending SqlElement
  *  checkValidId($id) : $id is a valid number or possibly '*' or empty string '' (may mean all in some cases)
  *  checkValidBoolean($boolean) : $boolean is a boolean, automatically replace similar values to 1 or 0, only allowed values
  *  checkValidDateTime($dateTime) : TODO !!! $date is either a date or a time or a datetime
  *  checkValidNumeric($numeric) : $nuleric is a numeric value
  *  checkValidAlphanumeric($string) : $string is alphnumeric only containing a-z, A-Z, 0-9
  *  checkValidFilename($file) : $file is a valid file, avoiding cross directory hacks
  *  checkValidMimeType($mimeType) : $mimeType is a valid mime type corresponding to RFC1341
  *  checkValidYear($year) : $year is a valid year (4 digits)
  *  checkValidMonth($month) : $month is a valid month (1 or 2 digits, value between 1 and 12)
  *  checkValidWeek($week) : $week is a valid week (1 or 2 digits, value between 1 and 53)
  *  checkValidPeriod($period) : $period as a valid period (numeric)
  *  checkValidPeriodScale($periodScale) : $periodScale is a valid period scale (year, quarter, month, week, day)
  *  
  */
  public static function checkValidClass($className) {
    if ($className=='') return ''; // Allow empty string
    // not checking file existence using realpath() due to inconsistent behavior in different versions.
    if (!file_exists('../model/'.$className.'.php') || 
    $className != basename(realpath('../model/'.$className.'.php'), '.php')) {
      traceHack("Invalid class name '$className'");
    }
    if (! is_subclass_of ( $className, 'SqlElement')) {
      //if (! is_a($className, 'SqlElement', true )) { // This function can accept $className, as string, only for PHP > 5.3.9
      traceHack("Class '$className' does not extend SqlElement");
    }
    return $className;
  }
  public static function checkValidId($id) {
    if (! is_numeric($id) and $id!='*' and trim($id)!='') {
      traceHack("Id '$id' is not numeric");
    }
    return $id;
  }
  public static function checkValidBoolean($boolean) {
    if (!$boolean or $boolean===false) $boolean=0;
    if ($boolean==-1 or $boolean===true) $boolean=1;
    if ($boolean!=0 and $boolean!=1) {
      traceHack("the value '$boolean' is not a boolean");
    }
    return $boolean;
  }
  public static function checkValidDateTime($dateTime) {
    /*if (preg_match('/^\d{4}-\d{2}-\d{2}$/', trim($endDate)) != true)
     {
    traceHack("Invalid object id in billLineEndDate = $endDate");
    exit;
    }*/
    // TODO check that $dateTime is a valid dateTime
    /*$f = DateTime::createFromFormat($format, $date);
     $valid = DateTime::getLastErrors();
    return ($valid['warning_count']==0 and $valid['error_count']==0);*/
    return $dateTime;
  }
  public static function checkValidNumeric($numeric) {
    if ($numeric===null or $numeric==='' or trim($numeric)==='') return; //allow null or empty value
    if (! is_numeric($numeric)) {
      traceHack("Value '$numeric' is not numeric");
    }
    return $numeric;
  }
  public static function checkValidAlphanumeric($string) {
    if (preg_match('/[^0-9a-zA-Z]/', $string) == true) {
      traceHack("invalid alpanumeric string value - $string");
    }
    return $string;
  }
  public static function checkValidYear($year) {
    if (preg_match('/^[0-9]{4}$/', $year) != 1) { // only allow 4 digit number as year. Note: may want to limit to range of valid year dates.
      $year='';
    }
    return $year;
  }
  public static function checkValidMonth($month) {
    // only allow from 1 to 2 digits as number as month. Must be between 1 and 12.
    if (is_numeric($month)) {
      $month = $month+0; // convert it to numeric variable
      if (is_int($month)) { // make sure its not a float
        if ($month < 1 or $month > 12) {// make sure it is not out of range
          $month='';
        }
      } else {
        $month='';
      }
    } else {
      $month='';
    }
    // here it is either an empty string or a number between 1-12
    $month=$month.''; // make sure it ends up as a string
    return $month;
  }
  public static function checkValidWeek($week) {
    // only allow from 1 to 2 digits as number as week. Must be between 1 and 52.
    if (is_numeric($week)) {
      $week = $week+0; // convert it to numeric variable
      if (is_int($week)) { // make sure its not a float
        if ($week < 1 or $week > 53) {// make sure it is not out of range
          $week='';
        }
      } else {
        $week='';
      }
    } else {
      $week='';
    }
    // here it is either an empty string or a number between 1-53
    $week=$week.''; // make sure it ends up as a string
    return $week;
  }
  public static function checkValidPeriod($period) {
    $period = preg_replace('/[^0-9]/', '', $period);
    return $period;
  }
  public static function checkValidPeriodScale($scale) {
    $scale=preg_replace('/[^a-z]/', '', $scale); // only allow a-z.
    if ($scale!='week' and $scale!='month' and$scale!='day' and $scale!='quarter' and $scale!='year') {
      traceHack("period scale '$scale' is not an expected period scale");
      $scale=""; // Not reached as traceHack will exit script
    }
    return $scale;
  }
  public static function checkValidFileName($fileName) {
    //$fileName=preg_replace('/[^a-zA-Z0-9_-]/', '', $fileName); // only allow [a-z, A-Z, 0-9, _, -] in file name 
    // PBE : disabled : much too restrictive (accentuated characters can be used, need to allow . for extension a.ext or a.b.c.ext)
    //^[^/?*:;{}\\]*\.?[^/?*:;{}\\]+$ // => allows host and .htaccess as file name
    if (basename($fileName)!=$fileName) {
      traceHack("filename $fileName containts path elements that are not accepted");
      $fileName=""; // Not reached as traceHack will exit script
    }
    if (! preg_match('#^[^/?*:;{}\\<>|"]*\.?[^/?*:;{}\\<>|"]+$#', $fileName)) {
      traceHack("filename $fileName containts invalid characters \ / : * ? \" ; { } < >");
      $fileName=preg_replace('/[^a-zA-Z0-9_-\.]/', '', $fileName); // Not reached as traceHack will exit script
    }
    if ( preg_match('#[\x00\x08\x0B\x0C\x0E-\x1F]#',$fileName)) {
      traceHack("filename $fileName containts non printable characters");
      $fileName=""; // Not reached as traceHack will exit script
    }
    return $fileName;
  }
  public static function checkValidMimeType($mimeType) {
    $pattern = '/^a(pplication|udio)|image|m(essage|ultipart)|text|video|[xX]-([!-\x27*+\-0-9AZ^-~])+\/([!-\x27*+\-0-9AZ^-~])+(;([!-\x27*+\-0-9AZ^-~])+=(([!-\x27*+\-0-9AZ^-~])+|\"(([\x00-\x0c\x0e-\x21\x23-\x5b\x5d-\x7f]|((\r\n)?[ \t])+)|\\[\x00-\x7f])*\"))*$/'; // Content-Type according to rfc1341
    $mimeType=preg_match($pattern, $mimeType)?$mimeType:'text/html';
    return $mimeType;
  } 
}
 