<?php
// ==================================================================================================
// This file includes all specific parameters for ProjectOr application
//
// -------------------
//  I M P O R T A N T
// -------------------
//
// As this file contains connection information to Database, you may want to add a security level
// => just move this file to a non-web-accessed directory on the server
// => create in current directory (tool) a new file : parametersLocation.php including one line :
//      $parametersLocation="way to your parameter file"; 
//      For instance, on windows based OS server, if you move parameter.php to "c:\myOwnParameters.txt" :
//         $parametersLocation="c:\myOwnParameters.txt"; 
//This way :
//  - your parameters (including database information) are securely stored in a non reachable directory
//  - as parametersLocation.php is never delivered in ProjectOr packages, 
//    your parameters will never be erased, even if you install new versions of ProjectOr
//   
// ==================================================================================================

// Database parameters (connection information)
// BE SURE THIS DATA WAY NOT BE READABLE FROM WEB (see above important notice)
$paramDbType='mysql';                           // Database type {'mysql'}
$paramDbHost='localhost';                       // Database host (server name)
$paramDbUser='root';                            // Database user to connect
$paramDbPassword='mysql';                       // Database password for user
$paramDbName='projector';                       // Database schema name
$paramDbDisplayName='ProjectOr Developement Database';                         // Name to be displayed    
$paramDbPrefix='z_';                              // Database prefix for table names

// === mail management
$paramMailSender='support@toolware.fr';   // eMail From addressee {a valid email}
$paramMailReplyTo='support@toolware.fr';  // eMail address to reply to {a valid email}
$paramAdminMail='support@toolware.fr';    // eMail of administrator {a valid email}

// === user management
$paramDefaultPassword='projector';              // default password {any string}
$paramPasswordMinLength=5;                      // min length for password {any integer}
$lockPassword=false;                          // disable password change functionality (if set to true, only admin can reset password)

// === debugging
$paramDebugMode='true';                        // Setup Dojo debugging mode {'true', 'false'}

// === i18n (internationalization)
$paramDefaultLocale='en';                       // default locale to be used on i18n (default is en) {'en', 'fr'}
$paramDefaultTimezone="Europe/Paris";           // default time zone. List can be found at http://us3.php.net/manual/en/timezones.php

// === display
$paramFadeLoadingMode='false';                   // Setup the way frames are refreshed : with fading or not {'true', 'false'}
$paramRowPerPage='50';                          // Number of row per page on main Grid view {any integer}
$paramIconSize='22';                            // Icon size on menu tree {'16' for small, '22' for medium, '32' for big}

// === attachement
$paramAttachementDirectory='..\\..\\TEMP';          // Directory to store Attachements. Set to empty string to disable attachement
$paramAttachementMaxSize=1024*1024*2;           // Max file size for attachement = 1024 * 1024 * Mo
$paramPathSeparator='\\';                        // Path separator, depending on system

// === log management
$logFile='..\\..\\TEMP\\projector_${date}.log';      // Log file name. May contain ${date} to get 1 file a day
$logLevel=3;                                   // Log level {'4' for script tracing, '3' for debug, '2' for general trace, '1' for error trace, '0' for none}

?>