<?php

// JMasterFramework Copyright Joomla51.com
// Author Joomla51
// Single User Commercial Licence. For use on one domain only.

$modules_1314_width = $this->params->get('modules_1314_width');
$modules_1920_width  = $this->params->get('modules_1920_width ');

//COUNT MODULES IN MODULES_123 - DECIDE WIDTH - COLLAPSE IF NECESSARY 
$modules_123_counted = 0;
if ($this->countModules('user1')) $modules_123_counted++;
if ($this->countModules('user2')) $modules_123_counted++;
if ($this->countModules('user3')) $modules_123_counted++;
if ( $modules_123_counted == 3 ) {
	$modules_123_width = '33.3%';}
elseif ( $modules_123_counted == 2 ) {
	$modules_123_width = '49.9%';
} else if ($modules_123_counted == 1) {
	$modules_123_width = '100%';
}


//COUNT MODULES IN MODULES_456 - DECIDE WIDTH - COLLAPSE IF NECESSARY 
$modules_456_counted = 0;
if ($this->countModules('user4')) $modules_456_counted++;
if ($this->countModules('user5')) $modules_456_counted++;
if ($this->countModules('user6')) $modules_456_counted++;
if ( $modules_456_counted == 3 ) {
	$modules_456_width = '33.3%';}
elseif ( $modules_456_counted == 2 ) {
	$modules_456_width = '49.9%';
} else if ($modules_456_counted == 1) {
	$modules_456_width = '100%';
}


//COUNT MODULES IN MODULES_789101112 - DECIDE WIDTH - COLLAPSE IF NECESSARY 
$modules_789_counted = 0;
if ($this->countModules('user7')) $modules_789_counted++;
if ($this->countModules('user8')) $modules_789_counted++;
if ($this->countModules('user9')) $modules_789_counted++;
if ($this->countModules('user10')) $modules_789_counted++;
if ($this->countModules('user11')) $modules_789_counted++;
if ($this->countModules('user12')) $modules_789_counted++;
if ( $modules_789_counted == 6 ) {
	$modules_789_width = '16.6%';}
else if ( $modules_789_counted == 5 ) {
	$modules_789_width = '20%';
} else if ($modules_789_counted == 4) {
	$modules_789_width = '25%';
} else if ($modules_789_counted == 3) {
	$modules_789_width = '33.3%';
} else if ($modules_789_counted == 2) {
	$modules_789_width = '50%';
} else if ($modules_789_counted == 1) {
	$modules_789_width = '100%';
}


//COUNT MODULES IN MODULES_1314 - DECIDE WIDTH - COLLAPSE IF NECESSARY 
$modules_1314_counted = 0;
if ($this->countModules('user13')) $modules_1314_width++;
if ($this->countModules('user14')) $modules_1314_width++;
if ($this->countModules('user15')) $modules_1314_width++;
if ($this->countModules('user16')) $modules_1314_width++;
if ($this->countModules('user17')) $modules_1314_width++;
if ($this->countModules('user18')) $modules_1314_width++;
if ( $modules_1314_width == 6 ) {
	$modules_1314_width = '16.6%';}
else if ( $modules_1314_width == 5 ) {
	$modules_1314_width = '20%';
} else if ($modules_1314_width == 4) {
	$modules_1314_width = '25%';
} else if ($modules_1314_width == 3) {
	$modules_1314_width = '33.3%';
} else if ($modules_1314_width == 2) {
	$modules_1314_width = '50%';
} else if ($modules_1314_width == 1) {
	$modules_1314_width = '100%';
}


//COUNT MODULES IN MODULES_1920 - DECIDE WIDTH - COLLAPSE IF NECESSARY 
$modules_1920_counted = 0;
if ($this->countModules('user19')) $modules_1920_width++;
if ($this->countModules('user20')) $modules_1920_width++;
if ($this->countModules('user21')) $modules_1920_width++;
if ($this->countModules('user22')) $modules_1920_width++;
if ($this->countModules('user23')) $modules_1920_width++;
if ($this->countModules('user24')) $modules_1920_width++;
if ( $modules_1920_width == 6 ) {
	$modules_1920_width = '16.6%';}
else if ( $modules_1920_width == 5 ) {
	$modules_1920_width = '20%';
} else if ($modules_1920_width == 4) {
	$modules_1920_width = '25%';
} else if ($modules_1920_width == 3) {
	$modules_1920_width = '33.3%';
} else if ($modules_1920_width == 2) {
	$modules_1920_width = '50%';
} else if ($modules_1920_width == 1) {
	$modules_1920_width = '100%';
}

//COUNT MODULES IN MODULES_2526 - DECIDE WIDTH - COLLAPSE IF NECESSARY 
$modules_2526_width = 0;
if ($this->countModules('user25')) $modules_2526_width++;
if ($this->countModules('user26')) $modules_2526_width++;
if ($this->countModules('user27')) $modules_2526_width++;
if ($this->countModules('user28')) $modules_2526_width++;
if ($this->countModules('user29')) $modules_2526_width++;
if ($this->countModules('user30')) $modules_2526_width++;
if ( $modules_2526_width == 6 ) {
	$modules_2526_width = '16.6%';}
else if ( $modules_2526_width == 5 ) {
	$modules_2526_width = '20%';
} else if ($modules_2526_width == 4) {
	$modules_2526_width = '25%';
} else if ($modules_2526_width == 3) {
	$modules_2526_width = '33.3%';
} else if ($modules_2526_width == 2) {
	$modules_2526_width = '50%';
} else if ($modules_2526_width == 1) {
	$modules_2526_width = '100%';
}


?>

 