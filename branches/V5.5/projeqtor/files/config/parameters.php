<?php
// =======================================================================================
// PARAMETERS
// =======================================================================================

// ========== Database configuration =====================================================
// --- MySql Degfault
  $paramDbType='mysql'; $paramDbPort='3306'; $paramDbUser='root'; $paramDbPassword='mysql';
  $paramDbName='projeqtor_v55';$paramDbPrefix='';
// --- PostgreSql Default
//$paramDbType='pgsql'; $paramDbPort='5432'; $paramDbUser='projeqtor_maaf'; $paramDbPassword='projeqtor';
//$paramDbName='projeqtor';$paramDbPrefix=''; 
$paramDbHost='127.0.0.1';         // With MySql on Windows, better use "127.0.0.1" rather than "localhost"
$enforceUTF8 = '0';               // Positionned by default for new installs since V4.4.0

// ========== Log file configuration =====================================================
$logFile='../files/logs/projeqtor_${date}.log';
$logLevel='3';

// ========== Contextual configuration ===================================================
//$lockPassword="false";           // Forbid password change (used in Demo to forbit password change)
//$hosted=true;                    // Is a hosted mode ? => should hide some configuration (directories, ...)
$flashReport=true;                 // Specific evolution Parameter

// ========== Debugging configuration ====================================================
$debugQuery=false;                 // Debug all queries : trace Query and running time for each query
$debugJsonQuery=false;             // Trace only JsonQuery queries  (retrieving lists)
$debugPerf=true;                   // Add some timestamps and execution time at all debug lines
$debugReport=true;                 // Displays report file name on report header
$i18nNocache=true; 
$memoryLimitForPDF = '512';
$debugIEcompatibility=false;
//$showAutoPlan=true;
$paramSupportEmail="support@projeqtor.org";
$pdfPlanningBeta='true';
//======= END