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
// => change the include directive in projector.php file to locate this file 
// For instance change, on windows based OS server, if you move parameter.php to "c:\myOwnParameters.txt",
// change  :
//     include_once "parameters.php";
// to :
//     include_once "c:\myOwnParameters.txt";
//
// ==================================================================================================

// Database parameters (connection information)
// BE SURE THIS DATA WAY NOT BE READABLE FROM WEB (see above important notice)
$paramDbType='mysql';                           // Database type {'mysql'}
$paramDbHost='localhost';                       // Database host (server name)
$paramDbUser='o101506_babynus';                 // Database user to connect
$paramDbPassword='Looping31!';                  // Database password for user
$paramDbName='o101506_projectorDEV';            // Database schema name    
$paramDbPrefix='dev_';                              // Database prefix for table names
$paramDbDisplayName='ProjectOr Tracking Database';                         // Name to be displayed

// === mail management
$paramMailSender='support@toolware.fr';         // eMail From addressee {a valid email}
$paramMailReplyTo='support@toolware.fr';        // eMail address to reply to {a valid email}
$paramAdminMail='support@toolware.fr';          // eMail of administrator {a valid email}

// === user management
$paramDefaultPassword='projector';              // default password {any string}
$paramPasswordMinLength=5;                      // min length for password {any integer}
$lockPassword=true;                            // disable password change functionality (if set to true, only admin can reset password)

// === debugging
$paramDebugMode='false';                        // Setup Dojo debugging mode {'true', 'false'}

// === i18n (internationalization)
$paramDefaultLocale='en';                       // default locale to be used on i18n (default in en) {'en', 'fr'}
$paramDefaultTimezone="Europe/Paris";           // default time zone. List can be found at http://us3.php.net/manual/en/timezones.php

// === display
$paramFadeLoadingMode='true';                   // Setup the way frames are refreshed : with fading or not {'true', 'false'}
$paramRowPerPage='50';                          // Number of row per page on main Grid view {any integer}
$paramIconSize='22';                            // Icon size on menu tree {'16' for small, '22' for medium, '32' for big}

// === attachement
$paramAttachementDirectory='/home/o101506/www/_private/demoDev/files/';          // Directory to store Attachements. Set to empty string to disable attachement
$paramAttachementMaxSize=2097152;           // Max file size for attachement = 1024 * 1024 * Mo
$paramPathSeparator='/';                        // Path separatior, depending on system

// === log management
$logFile='/home/o101506/www/_private/demoDev/logs/projector_${date}.log';      // Log file name. May contain ${date} to get 1 file a day
$logLevel=3;                                    // Log level {'3' for debug, '2' for general trace, '1' for error trace, '0' for none}
// New parameters V1.2.0
$paramMailSmtpServer = 'localhost';
$paramMailSmtpPort = '25';
$paramMailSendmailPath = '';
$paramMailTitle = '[Project\'Or RIA] ${item} #${id} moved to status ${status}';
$paramMailMessage = 'The status of ${item} #${id} [${name}] has changed to ${status}';
$paramMailShowDetail = 'true';
// New parameters V1.3.0
$defaultTheme = 'blue';
// New parameters V1.4.0
$paramReportTempDirectory = '../files/report/';
// New parameters V1.5.0
$currency = '€';
$currencyPosition = 'after';
$paramMemoryLimitForPDF = '512';
