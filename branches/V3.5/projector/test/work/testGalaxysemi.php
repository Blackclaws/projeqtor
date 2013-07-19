<?php 
$batchMode=true;
require_once "../tool/projeqtor.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" 
  "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
</head>

<body class="blue" >
<pre>

<?php 

/*$checkUrl='https://na14.salesforce.com/services/data/';

$response=file_get_contents($checkUrl);

$array=json_decode($response);
//var_dump($array);
echo "<table border='1'><tr><th>label</th><th>url</th><th>version</th></tr>";

foreach ($array as $item) {
	echo "<tr><td>" . $item->label . "</td><td>" . $item->url . "</td><td>" . $item->version . "</td></tr>";
}
echo "</table>";

*/

$customerId="3MVG9rFJvQRVOvk4deWHmpHEQwTO8hCTmbZtAh6J8yVd_Y_HNxs.fr2Kbisi3Nue5O3DgDUQNj7WLe7jOuKoY";
$customerSecret="2474235356373892685";

//$authUrl="https://na14.salesforce.com/services/data/";
//$authUrl="http://localhost/projectorriaV2.1/test/testRestWS.php";

//Get Code :
$authUrl="https://na14.salesforce.com/services/oauth2/authorize";
$params=array('response_type'=>'code',
              'client_id'=>$customerId,
              'redirect_uri'=>'https://projectorria.toolware.fr/test/test/testRestWS.php');
$result = restRequestCurl($authUrl,'POST',$params);
echo "=>'" . $result . "'";
echo '<br/><br/>';
// Create context for a POST Request
$params=array('client_id'=>$customerId,
              'client_secret'=>$customerSecret,
              'redirect_uri'=>'https://projectorria.toolware.fr/test/test/testRestWS.php',
              'grant_type'=>'authorization_code',
              'code'=>'aPrx4GbVBrSIkg48_8YfVUPboSjcPn_f5aEH6IftcVAy7DEhVcApoGCEkQ8lHSs3JHo_Ac5B1Q%3D%3D==');
$authUrl="https://na14.salesforce.com/services/oauth2/token";
$result = restRequestCurl($authUrl,'POST',$params);
echo "'" . $result . "'";

?>

</pre>

</body>
</html>
<?php 

function restRequestCurl($url,$method,$paramArray) {
  $postdata = http_build_query($paramArray);
  $session = curl_init($url); 
  // Tell curl to use HTTP POST
  curl_setopt ($session, CURLOPT_POST, true); 
  // Tell curl that this is the body of the POST
  curl_setopt ($session, CURLOPT_POSTFIELDS, $paramArray); 
  // Tell curl not to return headers, but do return the response
  curl_setopt($session, CURLOPT_HEADER, false); 
  curl_setopt($session, CURLOPT_RETURNTRANSFER, true);    
  $response = curl_exec($session); 
echo $url . '<br/>';
echo $method . '<br/>';
var_dump($paramArray); 
echo '<br/>';
  curl_close($session); 
  return $response;
}




function restRequest($url,$method,$paramArray) {
	$postdata = http_build_query($paramArray);
	var_dump($postdata);
  $opts = array('http' =>
    array(
        'method'  => $method,
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => $postdata
    )
  );
  $context  = stream_context_create($opts);
  return file_get_contents($url,false,$context);
}


function sendToHost($host,$method,$path,$data,$useragent=0)
{
    if (is_array($data)) {
    	$newData="?";
    	foreach ($data as $id=>$val) {
    		$newData.=$id."=".$val."&";
    	}
    	$data=$newData;
    }
	  // Supply a default method of GET if the one passed was empty
    if (empty($method)) {
        $method = 'GET';
    }
    $method = strtoupper($method);
    $fp = fsockopen($host, 80);
    if ($method == 'GET') {
        $path .= '?' . $data;
    }
    fputs($fp, "$method $path HTTP/1.1\r\n");
    fputs($fp, "Host: $host\r\n");
    fputs($fp,"Content-type: application/x-www-form-urlencoded\r\n");
    fputs($fp, "Content-length: " . strlen($data) . "\r\n");
 
    if ($useragent) {
        fputs($fp, "User-Agent: MSIE\r\n");
    }
    fputs($fp, "Connection: close\r\n\r\n");
    if ($method == 'POST') {
        fputs($fp, $data);
    }
    $buf="";
    $nb=10;
    while (!feof($fp) and $nb) {
        $buf .= fgets($fp,128);
        $nb--;
    }
    fclose($fp);
    return $buf;
}