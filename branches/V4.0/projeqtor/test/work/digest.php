<?php
/* ============================================================================
 * Digest connection
 * NOT USED YET.
 */
$realm = 'ProjeQtOr';

// users and passwords
// Must get users in Database !!!
$users = array('admin' => '21232f297a57a5a743894a0e4a801fc3', 
               'guest' => '084e0343a0486ff05530df6c705c8bb4');

if (empty($_SERVER['PHP_AUTH_DIGEST'])) {
    header('HTTP/1.1 401 Unauthorized');
    header('WWW-Authenticate: Digest realm="'.$realm.
           '",qop="auth",nonce="'.uniqid().'",opaque="'.md5($realm).'"');
    die('Connection cancelled');
}

// analyse PHP_AUTH_DIGEST
if (!($data = http_digest_parse($_SERVER['PHP_AUTH_DIGEST'])) ||
    !isset($users[$data['username']]))
    die('1-Invalid login');


// G�n�ration de r�ponse valide
$A1 = md5($data['username'] . ':' . $realm . ':' . $users[$data['username']]);
$A2 = md5($_SERVER['REQUEST_METHOD'].':'.$data['uri']);
$valid_response = md5($A1.':'.$data['nonce'].':'.$data['nc'].':'.$data['cnonce'].':'.$data['qop'].':'.$A2);

if ($data['response'] != $valid_response)
    die('2-Invalid login');

// OK, user is identified
echo 'Vous �tes identifi� en tant que : ' . $data['username'];


// Function to analyse 'PHP_AUTH_DIGEST' 
function http_digest_parse($txt)
{
    // Protection against missing data
    $needed_parts = array('nonce'=>1, 'nc'=>1, 'cnonce'=>1, 'qop'=>1, 'username'=>1, 'uri'=>1, 'response'=>1);
    $data = array();
	$matches=split(",",$txt);
    foreach ($matches as $m) {
    	var_dump( $m ); echo "<br/>";
        $sp=split("=",$m);
        $data[$sp[0]] = trim($sp[1],'"');
        unset($needed_parts[$sp[0]]);
    }
    return $needed_parts ? false : $data;
}
?>