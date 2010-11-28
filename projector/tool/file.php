<?php
/** ===========================================================================
 * 
 */
function writeFile($msg,$file) {
  if (function_exists('error_log')) {
    return error_log( $msg,3, $file);
  } else {
    $handle=fopen($file,"a");
    if (! $handle) return false;
    if (! fwrite($handle,$msg)) return false;
    if (! fclose($handle))  return false;
    return true;
  } 
}

/** 
 * Delete a file
 * @param $file
 * @throws Exception
 */
function kill($file) {
  if (file_exists($file)) {
    unlink($file);
  }
}

function purgeFiles($dir, $pattern) {
  $handle = opendir($dir); 
  while (($file = readdir($handle)) !== false) {
    if ($file == '.' || $file == '..') { 
      continue; 
    } 
    $filepath = $dir == '.' ? $file : $dir . '/' . $file; 
    if (is_link($filepath)) {
      continue;
    } 
    if (is_file($filepath)) { 
      if (substr($file,0,strlen($pattern))==$pattern) {
        unlink($filepath);
      }
    } else if (is_dir($filepath)) { 
      purgeFiles($filepath, $pattern);
    } 
  } 
  closedir($handle); 
}

