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

/**
 * Purge some files
 * @param string $dir directory
 * @param string $pattern pattern for file selection
 */
function purgeFiles($dir, $pattern) {
	if (! is_dir($dir)) {
		traceLog ("purgeFiles('$dir', '$pattern') - directory '$dir' does not exist");
		return;
	}
	$handle = opendir($dir);
	if (! is_resource($handle)) {
		traceLog ("purgeFiles('$dir', '$pattern') - Unable to open directory '$dir' ");
		return;
	}
	while (($file = readdir($handle)) !== false) {
		if ($file == '.' || $file == '..') {
			continue;
		}
		$filepath = $dir == '.' ? $file : $dir . '/' . $file;
		if (is_link($filepath)) {
			continue;
		}
		if (is_file($filepath)) {
			if (!$pattern or substr($file,0,strlen($pattern))==$pattern) {
				unlink($filepath);
			}
		} else if (is_dir($filepath)) {
			purgeFiles($filepath, $pattern);
		}
	}
	closedir($handle);
}

/**
 * Create of thumb image of given size, with same name suffixed with "_thumb$size"
 * @param unknown_type $image
 * @param unknown_type $size
 */
function createThumb($imageFile,$size) {
	if (!$size) $size=32;
	if (!$imageFile) {
		return false;
	}
	$ext=strtolower(pathinfo($imageFile, PATHINFO_EXTENSION));
	$imgFmt="";
	switch ($ext) {
		case 'jpg': case 'jpeg':
			$imgFmt='jpeg'; break;   
		case 'gif': 
			$imgFmt='gif'; $blending = true; break;
		case 'png':
			$imgFmt='png'; $blending = false; break;		
	}
	$imagecreate = "imagecreatefrom$imgFmt"; 
	$imagesave = "image$imgFmt";
	
	$img=$imagecreate($imageFile);
	$x = imagesx($img);
	$y = imagesy($img);
	if($x>$size or $y>$size) {
		if($x>$y)	{
			$nx = $size;
			$ny = floor($y/($x/$size));
		}	else {
			$nx = floor($x/($y/$size));
			$ny = $size;
		}
	} else {
		$nx=$x;
		$ny=$y;
	}
	$nimg = imagecreatetruecolor($nx,$ny);
	// preserve transparency for PNG and GIF images 
  if ($imgFmt == 'png' or $imgFmt == 'gif'){ 
    $background = imagecolorallocate($nimg, 0, 0, 0); 
    imagecolortransparent($nimg, $background); 
    imagealphablending($nimg, $blending); 
    imagesavealpha($nimg, true); 
  } 
	imagecopyresampled($nimg,$img,0,0,0,0,$nx,$ny,$x,$y);
	$imagesave($nimg,getThumbFileName($imageFile,$size));
	return true;
}

function getThumbFileName($imageFile,$size) {
	$ext=strtolower(pathinfo($imageFile, PATHINFO_EXTENSION));
	return substr($imageFile,0,strlen($imageFile)-(strlen($ext)+1)).'_thumb'.$size.'.'.$ext;
}

function getImageThumb($imageFile,$size) {
	$thumb=getThumbFileName($imageFile,$size);
	if (! file_exists($thumb)) {
		if (! createThumb($imageFile,$size)) {
			errorLog("Cannot create image thumb of size $size for $imageFile");
			return "";
		}
	}
	return $thumb;
}

function isThumbable($fileName) {
  $ext=strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
  if ($ext=='jpg' or $ext=='jpeg' or $ext=='gif' or $ext=='png') {
    return true;	    
  } else {
  	return false;
  }
}