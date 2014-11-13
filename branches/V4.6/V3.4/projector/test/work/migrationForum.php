<?php
require "../tool/projector.php";
header ('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" 
  "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>   
<STYLE type="text/css">
  body {
    font-family: verdana, arial;
    font-size : 6pt;
    
  }
  table {border-collapse: collapse; border: 1px solid grey;}
  tr  {border: 1px solid grey;}
  td  {border: 1px solid grey;}
  th  {border: 1px solid grey; background-color: #DDDDDD;}
  .red {color: red}
  .green {color: green}
  .update {color: green; font-weight: bold}
  .insert {color: green}
  .banned {color: red; font-weight: bold}
  .duplicate {color: red}
</STYLE>
</head>

<body>
<?php
require './migrationForumBbBan.php';
require './migrationForumBbPost.php';
require './migrationForumBbTopic.php';
require './migrationForumBbUser.php';
require './migrationForumJoMessage.php';
require './migrationForumJoUser.php';
require './migrationForumJoUserGroup.php';

set_time_limit(300);

$mode='update';
//$mode='test';
echo '<H1>Mode = <b>' . strtoupper($mode) . '</b></H1>';

$bbUser=new BbUser();
$josUser=new JoUser();
$listBbUser=$bbUser->getSqlElementsFromCriteria(array(), false);

$bbidToJoid=array();
$inUsernames=array();
$inEmails=array();

// =====================================================================================================
// USERS 
// =====================================================================================================

echo '<table style="border:1px solid grey">';
echo'<tr><th colspan="4">Forum</th><th rowspan="2"></th><th colspan="9">Joomla</th></tr>';
echo'<tr><th>Id</th><th>user</th><th>mail</th><th>name</th><th>operation</th><th>Id</th><th>Name</th><th>User</th><th>Mail</th><th>Type</th><th>Registered</th><th>Last&nbsp;Visit</th><th>Result</th></tr>';
$total=0;
$existing=0;
$update=0;
$insert=0;
foreach ($listBbUser as $bbUser) {
	$total+=1;
	$operation='insert';
	$check='';
	if (array_key_exists($bbUser->username, $inUsernames)) {
		$check.=($check)?'<br/>':'';
		$check.='double username with ' . $inUsernames[$bbUser->username];
	} else {
		$inUsernames[$bbUser->username]=$bbUser->id;
	}
  if (array_key_exists($bbUser->email, $inEmails)) {
  	$check.=($check)?'<br/>':'';
    $check.='double emal with ' . $inEmails[$bbUser->email];
  } else {
    $inEmails[$bbUser->email]=$bbUser->id;
  }
  $where="name='" . $bbUser->realname . "' or username='" . $bbUser->username . "' or email='" . $bbUser->email . "'";
  $ckeckJoUser=$josUser->getSqlElementsFromCriteria(null, false, $where);
  $operation='insert';
  $id=null;
  if (count($ckeckJoUser)==1) {
  	$usr=$ckeckJoUser[0];
  	$existing++;
  	$check.=($check)?'<br/>':'';
    $check.=' <span class="' . ((strtolower($usr->username)==strtolower($bbUser->username))?'green':'red') . '">' . $usr->username . "</span>"
        . ' | <span class="' . ((strtolower($usr->email)==strtolower($bbUser->email))?'green':'red') . '">' . $usr->email 
        . ' | <span class="' . ((strtolower($usr->name)==strtolower($bbUser->realname) or !$bbUser->realname)?'green':'red') . '">' . $usr->name;
    if (strtolower($usr->email)==strtolower($bbUser->email)) {
    	 $id=$usr->id;
    	 $operation='update';
    } else if (strtolower($usr->username)==strtolower($bbUser->username) and strtolower($usr->name)==strtolower($bbUser->username)) {
    	 $id=$usr->id;
       $operation='update';
    } else {
    	$operation='duplicate';
    } 
  }
  $ban=new BbBan();
  $bans=$ban->getSqlElementsFromCriteria(array('username'=>$bbUser->username));
  if (count($bans)>0) {
  	$operation='banned';
  	$check.=($check)?'<br/>':'';
    $check.='<span class="red">BANNED</span>';
  }
  $new = new JoUser($id);
  $new->username=$bbUser->username;
  if ($operation=='duplicate') {
  	$split=explode('@',$bbUser->email);
  	$new->username=$split[0];
  	$new->id=null;
  }
  if (! $new->name) { 
    $new->name=($bbUser->realname)?$bbUser->realname:$new->username;
  }
  $new->email=$bbUser->email;
  //$new->password;
  //$new->usertype=5;
  //$new->block;
  //$new->sendEmail;
  $new->registerDate=date('Y-m-d H:i',$bbUser->registered);
  $new->lastvisitDate=date('Y-m-d H:i',$bbUser->last_visit);
  //$new->activation;
  $new->params='{}';
  $result="";
  if ($operation!='banned') {
  	if ($new->id) {$update++;} else {$insert++;}
  	if ($mode=='update') $result.=$new->save();
  }
  if ($operation=='insert' or $operation=='duplicate') {
  	//$grp=new JoUserGroup();
  	//$grp->user_id=$new->id;
  	//$grp->group_id="2";
  	//$grp->save();
  	$query="insert into o101506_jo161.jos_user_usergroup_map (user_id,group_id) VALUES (" . $new->id . ',2);';
  	if ($mode=='update') Sql::query($query); 
  	
  }
  if ($operation!='banned') {
  	$query="insert into o101506_jo161.jos_kunena_users (userid) VALUES (" . $new->id . ');';
  	 if ($mode=='update') Sql::query($query); 
  }
  $bbidToJoid[$bbUser->id]=$new->id;
	echo '<tr><td>' . $bbUser->id . '</td><td>' . $bbUser->username . '</td><td>' .  $bbUser->email 
	   . '</td><td>' .  $bbUser->realname . '</td><td>' .  $check 
	   . '</td><td class="'. $operation .'">' . $operation 
	   . '</td><td>' .  $new->id 
	   . '</td><td>' .  $new->name
	   . '</td><td>' .  $new->username
	   . '</td><td>' .  $new->email 
	   . '</td><td>' .  $new->usertype 
	   . '</td><td>' .  $new->registerDate 
	   . '</td><td>' .  $new->lastvisitDate 
	    . '</td><td>' .  $result
	   . '</td></tr>';
} 
echo '</table>';
echo '<b>';
echo '<br/>Total = ' . $total;
echo '<br/>Created = ' . $insert;
echo '<br/>Updated = ' . $update;
echo '<br/>Existing = ' . $existing;
echo '</b><br/><br/>';

// =====================================================================================================
// MESSAGES 
// =====================================================================================================

echo '<table style="border:1px solid grey">';
echo '<tr><th>Id</th><th>Subject</th><th>Posts</th></tr>';
$topic=new BbTopic();
$listBbTopics=$topic->getSqlElementsFromCriteria(null, false, null, 'id asc');
$nbTopics=0;
$nbPosts=0;
foreach ($listBbTopics as $topic) {
	$topId=0;
	$post=new BbPost();
	$listPost=$post->getSqlElementsFromCriteria(array('topic_id'=>$topic->id),false, null, 'posted asc');
	$cptPost=0;
	foreach ($listPost as $post) {
		$cptPost++;
		$nbPosts++;
		$mes=new JoMessage();
		$mes->parent=$topId;
		$mes->thread=$topId;
		$mes->catid=$topic->forum_id;
		$mes->name=$post->poster;		
		$mes->userid=$bbidToJoid[$post->poster_id];
		$mes->email=$post->poster_email;
		$mes->subject=(($cptPost==1)?'':'RE : ') . $topic->subject;
		$mes->time=$post->posted;
		$mes->ip=$post->poster_ip;
		$mes->locked=$topic->closed;
		$mes->hits=($cptPost==1)?$topic->num_views:0;
		$mes->modified_by=$post->edited_by;
		$mes->modified_time=$post->edited;
		$mes->ordering=0;
		$mes->moved=0;
		if ($mode=='update') $mes->save();
		if ($cptPost==1) {
			$nbTopics++;
			$topId=$mes->id;
			$mes->thread=$mes->id;
			if ($mode=='update') $mes->save();
		}
		$query="INSERT INTO o101506_jo161.jos_kunena_messages_text (mesid, message) VALUES ";
		$query.="(" . $mes->id . ",'" . addslashes($post->message) . "')";
		if ($mode=='update') Sql::query($query); 
	}
	echo '<tr><td>'.$topId.'</td><td>'.$topic->subject.'</td><td>'.$cptPost.'</td></tr>';
}
echo '</table>';
echo '<b>';
echo "<br/>Topics = " . $nbTopics;
echo "<br/>Posts = " . $nbPosts;
echo '</b>';
?>
</body>
</html>