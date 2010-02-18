<?php
/*

Copyright (c) 2009 Anant Garg (anantgarg.com | inscripts.com)

This script may be used for non-commercial purposes only. For any
commercial purposes, please contact the author at 
anant.garg@inscripts.com

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.

*/
/*********************************************************************
    Xoops Module Author: Andrax                                                         
    URL: http://guxbrasil.org
    E-Mail: lcbc@ig.com.br
**********************************************************************/

include 'header.php';
global $xoopsLogger;
$xoopsLogger->activated = false;


if ($_GET['action'] == "chatheartbeat") { chatHeartbeat(); } 
if ($_GET['action'] == "sendchat") { sendChat(); } 
if ($_GET['action'] == "closechat") { closeChat(); } 
if ($_GET['action'] == "startchatsession") { startChatSession(); } 

if (!isset($_SESSION['chatHistory'])) {
    $_SESSION['chatHistory'] = array();	
}

if (!isset($_SESSION['openChatBoxes'])) {
    $_SESSION['openChatBoxes'] = array();	
}

function chatHeartbeat() {
    
    global $xoopsDB, $xoopsUser;
    $sql = "select * from ".$xoopsDB->prefix('xim_chat')." where (".$xoopsDB->prefix(xim_chat).".to = '".mysql_real_escape_string($_SESSION['xoopsUserId'])."' AND recd = 0) order by id ASC";
    $query = $xoopsDB->query($sql);
    $items = '';
    
    $chatBoxes = array();

    while ($chat = mysql_fetch_array($query)) {
        
        if (!isset($_SESSION['openChatBoxes'][$chat['from']]) && isset($_SESSION['chatHistory'][$chat['from']])) {
            $items = $_SESSION['chatHistory'][$chat['from']];
        }
        
        $chat['message'] = sanitize($chat['message']);
	$user = new XoopsUser($chat['from']);
	// changed to show link to user info for user "from"
	$uname = "<a href='".XOOPS_URL."/userinfo.php?uid=".$chat['from']."'>".$user->uname()."</a>";
	$avatar =$user->user_avatar();
	if ($avatar!='blank.gif') {
	    $avatarURL = XOOPS_URL."/uploads/".$avatar;
	} else {
	    $avatarURL = XOOPS_URL."/modules/xim/images/default_avatar.png";
	}
        $items .= <<<EOD
{"s":"0","n":"{$uname}","a":"$avatarURL","f":"{$chat['from']}","m":"{$chat['message']}"},

EOD;
        
        if (!isset($_SESSION['chatHistory'][$chat['from']])) {
            $_SESSION['chatHistory'][$chat['from']] = '';
        }
        
        $_SESSION['chatHistory'][$chat['from']] .= <<<EOD
{"s":"0","n":"{$uname}","a":"$avatarURL","f":"{$chat['from']}","m":"{$chat['message']}"},

EOD;
        
        unset($_SESSION['tsChatBoxes'][$chat['from']]);
        $_SESSION['openChatBoxes'][$chat['from']] = $chat['sent'];
    }
    
    if (!empty($_SESSION['openChatBoxes'])) {
        foreach ($_SESSION['openChatBoxes'] as $chatbox => $time) {
            if (!isset($_SESSION['tsChatBoxes'][$chatbox])) {
                $now = time()-strtotime($time);
                $time = date('g:iA M dS', strtotime($time));
                
                $message = "Sent at $time";
                if ($now > 180) {
                    $items .= <<<EOD
{"s":"2","f":"$chatbox","m":"{$message}"},

EOD;
                    
                    if (!isset($_SESSION['chatHistory'][$chatbox])) {
                        $_SESSION['chatHistory'][$chatbox] = '';
                    }
                    
                    $_SESSION['chatHistory'][$chatbox] .= <<<EOD
{"s":"2","f":"$chatbox","m":"{$message}"},

EOD;
                    $_SESSION['tsChatBoxes'][$chatbox] = 1;
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
    echo "{'items':[
$items]}";
    exit(0);
}

function chatBoxSession($chatbox) {
    
    $items = '';
    
    if (isset($_SESSION['chatHistory'][$chatbox])) {
        $items = $_SESSION['chatHistory'][$chatbox];
    }
    
    return $items;
}

function startChatSession() {
    global $xoopsUser;
    $items = '';
    if (!empty($_SESSION['openChatBoxes'])) {
        foreach ($_SESSION['openChatBoxes'] as $chatbox => $void) {
            $items .= chatBoxSession($chatbox);
        }
    }
    
    
    if ($items != '') {
        $items = substr($items, 0, -1);
    }

    $user=$xoopsUser->uname(); 
	$avatar =$xoopsUser->getVar('user_avatar');
	if ($avatar!='blank.gif') {
	    $avatarURL = XOOPS_URL."/uploads/".$avatar;
	} else {
	    $avatarURL = XOOPS_URL."/modules/xim/images/default_avatar.png";
	}
    $message = <<<EOD
{"username":"$user","avatar":"$avatarURL","items":[
$items]} 
EOD;
    header('Content-type: application/json');
    print($message);  
    
    exit(0);
}

function sendChat() {
    global $xoopsDB, $xoopsUser;
    $from = $_SESSION['xoopsUserId'];
    $to = $_POST['to'];
    $message = $_POST['message'];
    $user = new XoopsUser($from);
    $uname = $user->uname();
	$avatar =$user->user_avatar();
	if ($avatar!='blank.gif') {
	    $avatarURL = XOOPS_URL."/uploads/".$avatar;
	} else {
	    $avatarURL = XOOPS_URL."/modules/xim/images/default_avatar.png";
	}
    $_SESSION['openChatBoxes'][$_POST['to']] = date('Y-m-d H:i:s', time());
    
    $messagesan = sanitize($message);
    header('Content-type: application/json');
    echo '{"message":"'.$messagesan.'"}'; 
    if (!isset($_SESSION['chatHistory'][$_POST['to']])) {
        $_SESSION['chatHistory'][$_POST['to']] = '';
    }
    
    $_SESSION['chatHistory'][$_POST['to']] .= <<<EOD
{"s":"1","n":"{$uname}","a":"$avatarURL","f":"{$to}","m":"{$messagesan}"},

EOD;
    
    unset($_SESSION['tsChatBoxes'][$_POST['to']]);
    
    $sql = "insert into ".$xoopsDB->prefix(xim_chat)." (".$xoopsDB->prefix(xim_chat).".from,".$xoopsDB->prefix(xim_chat).".to,message,sent) values ('".mysql_real_escape_string($from)."', '".mysql_real_escape_string($to)."','".mysql_real_escape_string($message)."',NOW())";
    $query = $xoopsDB->query($sql);
    //echo "1";
    exit(0);
}

function closeChat() {
    
    unset($_SESSION['openChatBoxes'][$_POST['chatbox']]);
    
    echo "1";
    exit(0);
}

function sanitize($text) {
    $text = htmlspecialchars($text, ENT_QUOTES);
    $myts = MyTextSanitizer::getInstance();
    $text = $myts->displayTarea($text,1,1,1,1);
    $text = str_replace("\n\r","\n",$text);
    $text = str_replace("\r\n","\n",$text);
    $text = str_replace("\n","<br>",$text);
    $text = str_replace("\"","'",$text);

    return $text;
}
?>
