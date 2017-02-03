<?php
// =======================================================================================
// PARAMETERS
// =======================================================================================
$paramReorg=true;
// ========== Database configuration =====================================================
// --- MySql Degfault
$paramDbType='mysql'; $paramDbPort='3306'; $paramDbUser='root'; $paramDbPassword='mysql';
$paramDbName='projeqtor_v61';$paramDbPrefix='';
// --- PostgreSql Default
//$paramDbType='pgsql'; $paramDbPort='5432'; $paramDbUser='projeqtor_maaf'; $paramDbPassword='projeqtor';
//$paramDbName='projeqtor';$paramDbPrefix=''; 
$paramDbHost='127.0.0.1';         // With MySql on Windows, better use "127.0.0.1" rather than "localhost"

// ========== Log file configuration =====================================================
$logFile='../files/logs/projeqtor_${date}.log';
$logLevel='3';                    // "1"=Errors, "2"=Trace, "3"=Debug, "4"=Script

// ========== Contextual configuration ===================================================
//$lockPassword="false";           // Forbid password change (used in Demo to forbit password change)
//$hosted=true;                    // Is a hosted mode ? => should hide some configuration (directories, ...)
//$flashReport=true;               // Specific evolution Parameter
$enforceUTF8 = '1';                // Positionned by default for new installs since V4.4.0
$paramSupportEmail="support@projeqtor.org"; // Email displayed as support mail
$pdfNamePrefix="ProjeQtOr - ";

// ========== Debugging configuration ====================================================
$debugQuery=false;                 // Debug all queries : trace Query and running time for each query
$debugJsonQuery=false;             // Trace only JsonQuery queries  (retrieving lists)
$debugPerf=true;                   // Add some timestamps and execution time at all debug lines
$debugReport=true;                 // Displays report file name on report header
$i18nNocache=true;                 // Will not cache i18n table, so that new values are automatically displayed without needing disconnection
$debugIEcompatibility=false;       // If set to true, will allow compatibility mode (mode IE9 on IE11), otherwise, edge mode is forced
$pdfPlanningBeta='true';           // Force new PDF Export planning with all browsers (by default it only works on Chrome)
$scaytAutoStartup='YES';
//======= END