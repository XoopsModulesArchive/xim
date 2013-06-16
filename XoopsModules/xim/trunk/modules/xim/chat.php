<?php
/**
* You may not change or alter any portion of this comment or credits
* of supporting developers from this source code or any supporting source code
* which is considered copyrighted (c) material of the original comment or credit authors.
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*
* XIM - Xoops Instant Messenger
*
* A one-on-one messenger written for xoops. Inspired by Anant Garg's -(anantgarg.com | inscripts.com)-
* 2009 tutorial on jquery messenger & by the original facebook messenger and a few more. This module has
* been adapted, written, re-written and extended heavily by Andrax & Culex.
*
* @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
* @license         http://www.fsf.org/copyleft/gpl.html GNU public license
* @package         modules
* @subpackage      xim
* @since           2.4.0
* @author          Andrax - homepage.: http://guxbrasil.org & email.: lcbc@ig.com.br
* @author          Culex  - homepage.: http://culex.dk		& email.: culex@culex.dk
*
* Great part of this code is credited Anant Garg
* and therefore partly copyrighted under GNU without any limitations by him.
*
* Copyright (c) 2009 Anant Garg (anantgarg.com | inscripts.com)
*
* This script may be used for non-commercial purposes only. For any
* commercial purposes, please contact the author at 
* anant.garg@inscripts.com
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
* EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
* OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
* NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
* HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
* WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
* FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
* OTHER DEALINGS IN THE SOFTWARE.
**/

include 'header.php';
require_once XOOPS_ROOT_PATH."/modules/xim/include/functions.php";
global $xoopsLogger;
$xoopsLogger->activated = false;

if ($_GET['action'] == "chatheartbeat") { xim_chatHeartbeat(); } 
if ($_GET['action'] == "sendchat") { xim_sendChat(); } 
if ($_GET['action'] == "closechat") { xim_closeChat(); } 
if ($_GET['action'] == "startchatsession") { xim_startChatSession(); } 
if ($_GET['action'] == "avatar") { xim_getAvatar(); } 

if (!isset($_SESSION['xim_chatHistory'])) {
    $_SESSION['xim_chatHistory'] = array();	
}

if (!isset($_SESSION['xim_openChatBoxes'])) {
    $_SESSION['xim_openChatBoxes'] = array();	
}

// Function to be used in setInterval. This function do all the essential
function xim_chatHeartbeat() {
    global $xoopsDB, $xoopsUser,$soundUrl;
	$sql = "select * from ".$xoopsDB->prefix('xim_chat')." where (".$xoopsDB->prefix(xim_chat).".to = '".mysql_real_escape_string($_SESSION['xoopsUserId'])."' AND recd = 0) order by id ASC";
    $query = $xoopsDB->query($sql);
    $items = '';
    $chatBoxes = array();
	$config=array();
    while ($chat = mysql_fetch_array($query)) {
        
        if (!isset($_SESSION['xim_openChatBoxes'][$chat['from']]) && isset($_SESSION['xim_chatHistory'][$chat['from']])) {
            $items = $_SESSION['xim_chatHistory'][$chat['from']];
        }
        
        $chat['message'] = xim_sanitize($chat['message']);	
	$user = new xoopsUser($chat['from']);
	// changed to show link to user info for user "from"
	if ($chat['sys'] != '-1') {
	$uname = "<a href='".XOOPS_URL."/userinfo.php?uid=".$chat['from']."' title='".$user->uname()."'>".$user->uname()."</a>";
	}	else {
		$uname = _XIM_SYSTEMNAME;
		}
	
	if ($chat['sys'] == '-1') {
		$avatarURL = XOOPS_URL."/modules/xim/images/system.png";
	}	else {
	$avatar =$user->user_avatar();
	if ($avatar!='blank.gif') {
	    $avatarURL = XOOPS_URL."/uploads/".$avatar;
	} else {
	    $avatarURL = XOOPS_URL."/modules/xim/images/default_avatar.png";
	}
		}
		
	$config = im_Getconfig($xoopsUser->uname());
	$status = $config['status'];
	
		if ($config['sound'] == '0')  {$soundUrl = XOOPS_URL.'/modules/xim/media/0.mp3';}
		if ($config['sound'] == '1')  {$soundUrl = XOOPS_URL.'/modules/xim/media/1.mp3';}
		if ($config['sound'] == '2')  {$soundUrl = XOOPS_URL.'/modules/xim/media/2.mp3';}
		if ($config['sound'] == '3')  {$soundUrl = XOOPS_URL.'/modules/xim/media/3.mp3';}
		if ($config['sound'] == '4')  {$soundUrl = XOOPS_URL.'/modules/xim/media/4.mp3';}
		if ($config['sound'] == '5')  {$soundUrl = XOOPS_URL.'/modules/xim/media/5.mp3';}
		if ($config['sound'] == '6')  {$soundUrl = XOOPS_URL.'/modules/xim/media/6.mp3';}
		if ($config['sound'] == '7')  {$soundUrl = XOOPS_URL.'/modules/xim/media/7.mp3';}
		if ($config['sound'] == '8')  {$soundUrl = XOOPS_URL.'/modules/xim/media/8.mp3';}
		if ($config['sound'] == '9')  {$soundUrl = XOOPS_URL.'/modules/xim/media/9.mp3';}
		if ($config['sound'] == '10') {$soundUrl = XOOPS_URL.'/modules/xim/media/10.mp3';}
        if ($config['sound'] == '')   {$soundUrl = XOOPS_URL.'/modules/xim/media/0.mp3';}

		// check status to mute un-mute sound
		if ($config['status'] == '0') {$soundUrl = XOOPS_URL.'/modules/xim/media/0.mp3';}
		if ($config['status'] == '1') {$soundUrl = XOOPS_URL.'/modules/xim/media/0.mp3';}
		if ($config['status'] == '3') {$soundUrl = XOOPS_URL.'/modules/xim/media/0.mp3';}
        if ($config['status'] == '') {$soundUrl = XOOPS_URL.'/modules/xim/media/0.mp3';}

        $items .= <<<EOD
{"s":"0","n":"{$uname}","a":"$avatarURL","f":"{$chat['from']}","m":"{$chat['message']}","p":"$status","q":"$soundUrl"},
EOD;
        if (!isset($_SESSION['xim_chatHistory'][$chat['from']])) {
            $_SESSION['xim_chatHistory'][$chat['from']] = '';
        }
        
        $_SESSION['xim_chatHistory'][$chat['from']] .= <<<EOD
{"s":"0","n":"{$uname}","a":"$avatarURL","f":"{$chat['from']}","m":"{$chat['message']}"},
EOD;
        
        unset($_SESSION['xim_tsChatBoxes'][$chat['from']]);
        $_SESSION['xim_openChatBoxes'][$chat['from']] = $chat['sent'];
    }
    
    if (!empty($_SESSION['xim_openChatBoxes'])) {
        foreach ($_SESSION['xim_openChatBoxes'] as $chatbox => $time) {
            if (!isset($_SESSION['xim_tsChatBoxes'][$chatbox])) {
                $now = time()-strtotime($time);
                $time = date('g:iA M dS', strtotime($time));
                
                $message = _XIM_SENTATTIME." $time";
                if ($now > 180) {
                    $items .= <<<EOD
{"s":"2","f":"$chatbox","m":"{$message}"},
EOD;
                    
                    if (!isset($_SESSION['xim_chatHistory'][$chatbox])) {
                        $_SESSION['xim_chatHistory'][$chatbox] = '';
                    }
                    
                    $_SESSION['xim_chatHistory'][$chatbox] .= <<<EOD
{"s":"2","f":"$chatbox","m":"{$message}"},
EOD;
                    $_SESSION['xim_tsChatBoxes'][$chatbox] = 1;
                }
            }
        }
    }
    
    $sql = "update ".$xoopsDB->prefix(xim_chat)."  set recd = 1 where ".$xoopsDB->prefix(xim_chat).".to = '".mysql_real_escape_string($_SESSION['xoopsUserId'])."' and recd = 0";
    $query = $xoopsDB->queryF($sql);
    
    if ($items != '') {
        $items = substr($items, 0, -1);
    }
    header('Content-type: application/json');
    echo "{\"items\":[$items]}";
    exit(0);
}

function xim_chatBoxSession($chatbox) { 
    $items = '';   
    if (isset($_SESSION['xim_chatHistory'][$chatbox])) {
        $items = $_SESSION['xim_chatHistory'][$chatbox];
    }    
    return $items;
}

function xim_startChatSession() {
    global $xoopsUser;
	$items = '';
    if (!empty($_SESSION['xim_openChatBoxes'])) {
        foreach ($_SESSION['xim_openChatBoxes'] as $chatbox => $void) {
            $items .= xim_chatBoxSession($chatbox);
        }
    }    
    if ($items != '') {
        $items = substr($items, 0, -1);
    }
	if ($xoopsUser) {
	$config = im_Getconfig($xoopsUser->uname());
		if ($config['sound'] == '0') {$soundUrl = XOOPS_URL.'/modules/xim/media/0.mp3';}
		if ($config['sound'] == '1') {$soundUrl = XOOPS_URL.'/modules/xim/media/1.mp3';}
		if ($config['sound'] == '2') {$soundUrl = XOOPS_URL.'/modules/xim/media/2.mp3';}
		if ($config['sound'] == '3') {$soundUrl = XOOPS_URL.'/modules/xim/media/3.mp3';}
		if ($config['sound'] == '4') {$soundUrl = XOOPS_URL.'/modules/xim/media/4.mp3';}
		if ($config['sound'] == '5') {$soundUrl = XOOPS_URL.'/modules/xim/media/5.mp3';}
		if ($config['sound'] == '6') {$soundUrl = XOOPS_URL.'/modules/xim/media/6.mp3';}
		if ($config['sound'] == '7') {$soundUrl = XOOPS_URL.'/modules/xim/media/7.mp3';}
		if ($config['sound'] == '8') {$soundUrl = XOOPS_URL.'/modules/xim/media/8.mp3';}
		if ($config['sound'] == '9') {$soundUrl = XOOPS_URL.'/modules/xim/media/9.mp3';}
		if ($config['sound'] == '10') {$soundUrl = XOOPS_URL.'/modules/xim/media/10.mp3';}
	
    $user=$xoopsUser->uname(); 
	$avatar =$xoopsUser->getVar('user_avatar');
	}
	if ($avatar!='blank.gif') {
	    $avatarURL = XOOPS_URL."/uploads/".$avatar;
	} else {
	    $avatarURL = XOOPS_URL."/modules/xim/images/default_avatar.png";
	}

    $message = <<<EOD
{"username":"$user","avatar":"$avatarURL", "q":"$soundUrl", "items":[
$items]} 
EOD;
    header('Content-type: application/json');
    print($message);  
    
    exit(0);
}

function xim_sendChat() {
    global $xoopsDB, $xoopsUser;
	$from = $_SESSION['xoopsUserId'];
    $to = $_POST['to'];
	xoops_xim_checkStatus ($to, $from);
    $message = $_POST['message'];
    $user = new xoopsUser($from);
    $uname = $user->uname();
	$avatar =$user->user_avatar();
	if ($avatar!='blank.gif') {
	    $avatarURL = XOOPS_URL."/uploads/".$avatar;
	} else {
	    $avatarURL = XOOPS_URL."/modules/xim/images/default_avatar.png";
	}
    $_SESSION['xim_openChatBoxes'][$_POST['to']] = date('Y-m-d H:i:s', time());
	
	$config = im_Getconfig($user);
	$soundUrl = XOOPS_URL.'/modules/xim/media/0.mp3';
	$status = $config['status'];
    
    $messagesan = xim_sanitize($message);
    header('Content-type: application/json');
    echo '{"message":"'.$messagesan.'"}'; 
    if (!isset($_SESSION['xim_chatHistory'][$_POST['to']])) {
        $_SESSION['xim_chatHistory'][$_POST['to']] = '';
    }
    
    $_SESSION['xim_chatHistory'][$_POST['to']] .= <<<EOD
{"s":"1","n":"{$uname}","a":"$avatarURL","f":"{$to}","m":"{$messagesan}","q":"$soundUrl","p":"$status"},
EOD;
    
    unset($_SESSION['xim_tsChatBoxes'][$_POST['to']]);
    
    $sql = "insert into ".$xoopsDB->prefix(xim_chat)." (".$xoopsDB->prefix(xim_chat).".from,".$xoopsDB->prefix(xim_chat).".to,message,sent) values ('".mysql_real_escape_string($from)."', '".mysql_real_escape_string($to)."','".mysql_real_escape_string($message)."',NOW())";
    $query = $xoopsDB->queryF($sql);
    exit(0);
}

function xim_closeChat() {
    unset($_SESSION['xim_openChatBoxes'][$_POST['chatbox']]);
    echo "1";
    exit(0);
}

function xoops_xim_checkStatus ($to, $from) {
	global $xoopsDB, $xoopsUser;
	$user_to = new xoopsUser($to);
	$user_from = new xoopsUser($from);
	
	$recieverName = $user_to->uname();
	$senderName = $user_from->uname();
	
	$sql = "SELECT * FROM ".$xoopsDB->prefix('xim_pers_conf')." WHERE username = '".$recieverName."'";
	$result = $xoopsDB->query($sql);
	 while ($myrow=$xoopsDB->fetchArray($result)) {
		$id = $myrow['id'];
		$username = $myrow['username'];
		$status = $myrow['status'];
		$sound = $myrow['sound'];
	 }
	 
	 if ($status == '0') {
		// User is away
		$sysmessage = _XIM_SYSTEM_AWAY;
		 $sql = "insert into ".$xoopsDB->prefix(xim_chat)." (".$xoopsDB->prefix(xim_chat).".from,".$xoopsDB->prefix(xim_chat).".to,message,sent) values ('".mysql_real_escape_string($to)."', '".mysql_real_escape_string($from)."','".mysql_real_escape_string($sysmessage)."',NOW())";
		 $query = $xoopsDB->queryF($sql);
	 }
	 if ($status == '1') {
		// User is busy
		$sysmessage = _XIM_SYSTEM_BUSY;
		 $sql = "insert into ".$xoopsDB->prefix(xim_chat)." (".$xoopsDB->prefix(xim_chat).".from,".$xoopsDB->prefix(xim_chat).".to,message,sent) values ('".mysql_real_escape_string($to)."', '".mysql_real_escape_string($from)."','".mysql_real_escape_string($sysmessage)."',NOW())";
		 $query = $xoopsDB->queryF($sql);
	 }
	 if ($status == '3') {
		// User is offline
		$sysmessage = _XIM_SYSTEM_OFFLINE;
		 $sql = "insert into ".$xoopsDB->prefix(xim_chat)." (".$xoopsDB->prefix(xim_chat).".from,".$xoopsDB->prefix(xim_chat).".to,message,sent) values ('".mysql_real_escape_string($to)."', '".mysql_real_escape_string($from)."','".mysql_real_escape_string($sysmessage)."',NOW())";
		 $query = $xoopsDB->queryF($sql);
	 }
}

function xim_getAvatar(){
	$user = new xoopsUser($_GET['uid']);
	$avatar =$user->user_avatar();
	if ($avatar!='blank.gif') {
	    $avatarURL = XOOPS_URL."/uploads/".$avatar;
	} else {
	    $avatarURL = XOOPS_URL."/modules/xim/images/default_avatar.png";
	}
	header('Content-type: application/json');
    echo "{\"a\":\"{$avatarURL}\"}";
    exit(0);
}
?>
