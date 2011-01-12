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
**/

/*
* Main block function. Created from the online system block
* Adds an "who is online" block with a link to chat with registered user.
*/
function b_instantmessenger() {
    include XOOPS_ROOT_PATH.'/class/xoopsformloader.php';
    require_once XOOPS_ROOT_PATH.'/modules/xim/include/functions.php';
	global $xoopsUser, $xoopsModule,$xoopsTpl,$xoopsConfig;
	$xoopsLogger->activated = false;
	$online_handler =& xoops_gethandler('online');
    mt_srand((double)microtime()*1000000);
	$block = array();
    // set gc probabillity to 10% for now..
    if (mt_rand(1, 100) < 11) {
        $online_handler->gc(300);
    }
    if (is_object($xoopsUser)) {
        $uid = $xoopsUser->getVar('uid');
        $uname = $xoopsUser->getVar('uname');
		$_SESSION['username'] = $uname;
		$block['set'] = 0;
		xim_setPersonalConfig (); // Function to create/check personal config (culex)
    } else {
        $uid = 0;
        $uname = '';
    }

	$lang = $xoopsConfig['language'];
	if (!defined('_MB_XIM_ONLYYOU')) { 
		  
	// chek if language defines from jquery call is properly defined. If not include them
		if ( file_exists(XOOPS_ROOT_PATH.'/modules/xim/language/'.$lang.'/blocks.php') ) {
			include(XOOPS_ROOT_PATH.'/modules/xim/language/'.$lang.'/blocks.php');
		}	else {
				include(XOOPS_ROOT_PATH.'/modules/xim/language/english/blocks.php');
			}
	}

    if (is_object($xoopsModule)) {
        $online_handler->write($uid, $uname, time(), $xoopsModule->getVar('mid'), $_SERVER['REMOTE_ADDR']);
    } else {
        $online_handler->write($uid, $uname, time(), 0, $_SERVER['REMOTE_ADDR']);
    }
    $onlines = $online_handler->getAll();

        $total = count($onlines);
		$block['onlyyou'] = _MB_XIM_ONLYYOU;
		
		// Set status to assign to block in order to make last configs selected in status form
		$mystatus = im_Getconfig($uname);
		$block['my_status'] = $mystatus['status'];
		$block['my_sound'] = $mystatus['sound'];
        for ($i = 0; $i < $total; $i++) {
            if (($onlines[$i]['online_uid'] > 0) && ($onlines[$i]['online_uid']!=$uid)) {
				 $block['set'] ++;
				 $config = im_Getconfig($onlines[$i]['online_uname']);
				 $status = $config['status'];
				 $sound = $config['sound'];
				if ($status != '3') { 
					 if ($status == '0') {$image = XOOPS_URL."/modules/xim/images/Absent-blue16.png";}
					 if ($status == '1') {$image = XOOPS_URL."/modules/xim/images/busy-blue16.png";}
					 if ($status == '2') {$image = XOOPS_URL."/modules/xim/images/messenger-blue16.png";}
					$block['amigos'][] = array('id'=> $onlines[$i]['online_uid'], 'nome' => $onlines[$i]['online_uname'], 'status' => $image);					
				}
	// Config form for personal config.
	// $cf assigned to $block['config'], controlled by /js/configdiv.js & js/configscript.js
	// Using ajax to call /include/update_config.php wich serialize $_POST to sql.
			}
		}
		$cf = "<form method='post' id='config' action=''>"._MB_XIM_USESOUND."
		<select name='sound'>
			<option value='0'>"._MB_XIM_NOSOUND."</option>
			<option value='1'>"._MB_XIM_SOUND1."</option>
			<option value='2'>"._MB_XIM_SOUND2."</option>
			<option value='3'>"._MB_XIM_SOUND3."</option>
			<option value='4'>"._MB_XIM_SOUND4."</option>
			<option value='5'>"._MB_XIM_SOUND5."</option>
			<option value='6'>"._MB_XIM_SOUND6."</option>
			<option value='7'>"._MB_XIM_SOUND7."</option>
			<option value='8'>"._MB_XIM_SOUND8."</option>
			<option value='9'>"._MB_XIM_SOUND9."</option>
			<option value='10'>"._MB_XIM_SOUND10."</option>
		</select>
		<br /><br />
		 "._MB_XIM_STATUS."
		<select name='status'>
			<option value='0'>"._MB_XIM_HIDDEN."</option>
			<option value='1'>"._MB_XIM_BUSY."</option>
			<option value='2'>"._MB_XIM_ONLINE."</option>
			<option value='3'>"._MB_XIM_OFFLINE."</option>
		</select>
		<br /><br />
		<div style='text-align:center;'>
			<input type='submit' value='"._MB_XIM_UPDATE."' name='submit' class='update_button' title='"._MB_XIM_UPDATE."'/>
		</div>
	 </form>
	</span>
	<div id='flash'></div>";  
	  $block['config'] = $cf;
	 
        return $block;
}

?>