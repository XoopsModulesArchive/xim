<?php
/*********************************************************************
    Author: Andrax                                                         
    URL: http://guxbrasil.ning.com
    E-Mail: lcbc@ig.com.br
**********************************************************************/

function getAmigos() {
    global $xoopsDB, $xoopsUser;
    $sql = 'SELECT amigosList FROM '.$xoopsDB->prefix('xim_amigos');
    $sql .= ' WHERE (uid='.$xoopsUser->getVar('uid').')';
    $result = $xoopsDB->query($sql);

    if (!$result) {
        return '';
    }
//var_dump($_SESSION);
    $result = mysql_fetch_assoc($result);
return $result;
}

function adicionaAmigo($id) {
    global $xoopsDB,  $xoopsUser;
    $sql = 'SELECT amigosList FROM '.$xoopsDB->prefix('xim_amigos');
    $sql .= ' WHERE (uid='.$xoopsUser->getVar('uid').')';
    $result = $xoopsDB->query($sql);

    if (!$result) {
	$amigos= $id;
	$sql = 'INSERT '.$xoopsDB->prefix('xim_amigos');
	$sql .= ' VALUES ('.$xoopsUser->getVar('uid').','.$amigos.')';

    } else{
	$amigos= mysql_fetch_assoc($result).'|'.$id; 
	$sql = 'UPDATE '.$xoopsDB->prefix('xim_amigos');
	$sql .= ' SET amigosList ='.$amigos;
	$sql .= ' WHERE (uid='.$xoopsUser->getVar('uid').')';
    }
	$result = $xoopsDB->query($sql);
  //echo $result;

}

function removeAmigo($id) {

echo 'removendo usuário de' . $id;
//     global $xoopsDB, $xoopsUser;
//     $sql = 'SELECT amigosList FROM '.$xoopsDB->prefix('xim_amigos');
//     $sql .= ' WHERE (uid='.$xoopsUser->getVar('uid').')';
//     $result = $xoopsDB->query($sql);
// 
//     if (!$result) {
//         return '';
//     }
// //var_dump($_SESSION);
//     $result = mysql_fetch_assoc($result);
// return $result;
}

/*
** $culex	.: culex@culex.dk
** $username.: The username used in the chat
** $value	.: Eigher status or sound to be returned
*/
function im_Getconfig ($username) {
 global $xoopsUser, $xoopsDB;
 $persc = array();
 $sql = "SELECT * FROM ".$xoopsDB->prefix('xim_pers_conf')." WHERE username='".$username."'";
  $result = $xoopsDB->query($sql);
	while ($sqlfetch = $xoopsDB->fetchArray($result)) {
	 $persc['sound'] = $sqlfetch['sound'];
	 $persc['status'] = $sqlfetch['status'];
	}
return $persc;
}

function xim_setPersonalConfig () {
	global $xoopsDB, $xoopsTpl, $xoopsModule,$xoopsUser;
	 $username = $xoopsUser->getVar('uname');
	 // make mysql look up for configs already set
		$checkconfig = "SELECT * FROM ".$xoopsDB->prefix('xim_pers_conf')." WHERE username='".$username."'";
		 $result = $xoopsDB->query($checkconfig);
		  if ($xoopsDB->getRowsNum($result) < 1) {
		   // If none set, insert defaults
		    $default = "INSERT INTO ".$xoopsDB->prefix('xim_pers_conf')." (id, username, sound, status) VALUES ('', '$username', '1', 'online')";
			 $result = $xoopsDB->queryF($default);
		  } 
		   else {
		   // If set and update do an mysql update
		   }
}

?>