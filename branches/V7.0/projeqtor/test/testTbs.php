<?php
// Include the PHPWord.php, all other classes were loaded by an autoloader
require_once '../external/tbs/tbs_class.php';
require_once '../external/tbs/plugins/tbs_plugin_opentbs.php';

// prevent from a PHP configuration problem when using mktime() and date() 
if (version_compare(PHP_VERSION,'5.1.0')>=0) { 
    if (ini_get('date.timezone')=='') { 
        date_default_timezone_set('UTC'); 
    } 
} 

// Initialize the TBS instance 
$TBS = new clsTinyButStrong; // new instance of TBS 
$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN); // load the OpenTBS plugin 

// ------------------------------ 
// Prepare some data for the demo 
// ------------------------------ 

// Retrieve the user name to display 
$yourname = "Pascal";
// A recordset for merging tables 
$data = array(); 
$data[] = array('year'=> '2017', 'month'=>'08'  , 'resourceId'=>'1001' , 'resourceName'=>'AAAAA', 'projectCode'=>'X1', 'projectName'=>'Project X1',  'work'=>0.5); 
$data[] = array('year'=> '2017', 'month'=>'08'  , 'resourceId'=>'1001' , 'resourceName'=>'AAAAA', 'projectCode'=>'X2', 'projectName'=>'Project X2',  'work'=>0.4);
$data[] = array('year'=> '2017', 'month'=>'08'  , 'resourceId'=>'1001' , 'resourceName'=>'AAAAA', 'projectCode'=>'X3', 'projectName'=>'Project X3',  'work'=>0.6);
$data[] = array('year'=> '', 'month'=>''  , 'resourceId'=>'1001' , 'resourceName'=>'Total AAAAA', 'projectCode'=>'', 'projectName'=>'',  'work'=>1.5);
$data[] = array('year'=> '2017', 'month'=>'08'  , 'resourceId'=>'2002' , 'resourceName'=>'BBBBB', 'projectCode'=>'X1', 'projectName'=>'Project X1',  'work'=>0.5);
$data[] = array('year'=> '2017', 'month'=>'08'  , 'resourceId'=>'2002' , 'resourceName'=>'BBBBB', 'projectCode'=>'X2', 'projectName'=>'Project X2',  'work'=>0.4);
$data[] = array('year'=> '2017', 'month'=>'08'  , 'resourceId'=>'2002' , 'resourceName'=>'BBBBB', 'projectCode'=>'X3', 'projectName'=>'Project X3',  'work'=>0.6);
$data[] = array('year'=> '', 'month'=>''  , 'resourceId'=>'2002' , 'resourceName'=>'Total BBBBB', 'projectCode'=>'', 'projectName'=>'',  'work'=>1.5);
$data[] = array('year'=> 'Total général', 'month'=>''  , 'resourceId'=>'' , 'resourceName'=>'', 'projectCode'=>'', 'projectName'=>'',  'work'=>3.0);


// ----------------- 
// Load the template 
// ----------------- 

$template = 'D:\RapportMensuel.xlsx'; 
$TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); // Also merge some [onload] automatic fields (depends of the type of document). 

// ---------------------- 
// Debug mode of the demo 
// ---------------------- 
$debug=""; // possible values = "current", "info", "show"
if (isset($debug) && ($debug=='current')) $TBS->Plugin(OPENTBS_DEBUG_XML_CURRENT, true); // Display the intented XML of the current sub-file, and exit. 
if (isset($debug) && ($debug=='info'))    $TBS->Plugin(OPENTBS_DEBUG_INFO, true); // Display information about the document, and exit. 
if (isset($debug) && ($debug=='show'))    $TBS->Plugin(OPENTBS_DEBUG_XML_SHOW); // Tells TBS to display information when the document is merged. No exit. 

// -------------------------------------------- 
// Merging and other operations on the template 
// -------------------------------------------- 

// Merge data in the body of the document 
$TBS->PlugIn(OPENTBS_SELECT_SHEET, 1);
$TBS->MergeBlock('line', $data); 
$TBS->PlugIn(OPENTBS_SELECT_SHEET, 2);
$TBS->MergeBlock('line', $data);

// Change chart series 


// ----------------- 
// Output the result 
// ----------------- 

// Define the name of the output file 
$save_as = (isset($_POST['save_as']) && (trim($_POST['save_as'])!=='') && ($_SERVER['SERVER_NAME']=='localhost')) ? trim($_POST['save_as']) : 'x'; 
$output_file_name = str_replace('.', '_'.date('YmdHis').'.', $template); 
if ($save_as==='') { 
    // Output the result as a downloadable file (only streaming, no data saved in the server) 
    $TBS->Show(OPENTBS_DOWNLOAD, $output_file_name); // Also merges all [onshow] automatic fields. 
    // Be sure that no more output is done, otherwise the download file is corrupted with extra data. 
    exit(); 
} else { 
echo "save as $output_file_name<br/>";
    // Output the result as a file on the server. 
    $TBS->Show(OPENTBS_FILE, $output_file_name); // Also merges all [onshow] automatic fields. 
    // The script can continue. 
    exit("File [$output_file_name] has been created."); 
} 