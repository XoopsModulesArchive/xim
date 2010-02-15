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

?>