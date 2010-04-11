<?php
// $Id: b_instantmessenger.php,v 1.oo (alpha 1) 08/02/2010 20:00:00 culex $
// Inspired and referenced by Anant Garg (anantgar.com (c) 2009
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                  Copyright (c) 2000-2010 XOOPS.org                        //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
/*

* Main block function. Created from the online system block
* Adds an "who is online" block with a link to chat with registered user.
*/
function b_instantmessenger() {
    include XOOPS_ROOT_PATH.'/class/xoopsformloader.php';
	require_once XOOPS_ROOT_PATH.'/modules/xim/include/functions.php';
	global $xoopsUser, $xoopsModule,$xoopsTpl;
	$xoopsLogger->activated = false;
	$online_handler =& xoops_gethandler('online');
    mt_srand((double)microtime()*1000000);
    // set gc probabillity to 10% for now..
    if (mt_rand(1, 100) < 11) {
        $online_handler->gc(300);
    }
    if (is_object($xoopsUser)) {
        $uid = $xoopsUser->getVar('uid');
        $uname = $xoopsUser->getVar('uname');
		$_SESSION['username'] = $uname;
		xim_setPersonalConfig (); // Function to create/check personal config (culex)
    } else {
        $uid = 0;
        $uname = '';
    }

    $block = array();
    $style = 0;
    $module_handler =& xoops_gethandler('module');
    $module = $module_handler->getByDirname('xim');
    $config_handler =& xoops_gethandler('config');
    if ($module) {
	$moduleConfig =& $config_handler->getConfigsByCat(0, $module->getVar('mid'));
    	if(isset($moduleConfig['chatstyle'])) {
    		$style = $moduleConfig['chatstyle'];
    	}
    }
	
/*    if($style == 0) {
	$block['image'] =XOOPS_URL.'/modules/xim/images/messenger-blue16.png';
    } else {
	$block['image'] =XOOPS_URL."/modules/xim/images/online.png";
    } */


    if (is_object($xoopsModule)) {
        $online_handler->write($uid, $uname, time(), $xoopsModule->getVar('mid'), $_SERVER['REMOTE_ADDR']);
    } else {
        $online_handler->write($uid, $uname, time(), 0, $_SERVER['REMOTE_ADDR']);
    }
    $onlines = $online_handler->getAll();

    if (false != $onlines) {
        $total = count($onlines);
        for ($i = 0; $i < $total; $i++) {
            if (($onlines[$i]['online_uid'] > 0) && ($onlines[$i]['online_uid']!=$uid)) {
		    	 $config = im_Getconfig($onlines[$i]['online_uname']);
				 $status = $config['status'];
				if($style == 0) {
					 if ($status == '0') {$image = XOOPS_URL."/modules/xim/images/Absent-blue16.png";}
					 if ($status == '1') {$image = XOOPS_URL."/modules/xim/images/busy-blue16.png";}
					 if ($status == '2') {$image = XOOPS_URL."/modules/xim/images/messenger-blue16.png";}
				} else {
					 if ($status == '0') {$image = XOOPS_URL."/modules/xim/images/na.png";}
					 if ($status == '1') {$image = XOOPS_URL."/modules/xim/images/busy.png";}
					 if ($status == '2') {$image = XOOPS_URL."/modules/xim/images/online.png";}
				  }
				 $block['amigos'][] = array('id'=> $onlines[$i]['online_uid'], 'nome' => $onlines[$i]['online_uname'], 'status' => $image);	
				// print_r($block);
	   
	// Config form for personal config.
	// $cf assigned to $block['config'], controlled by /js/configdiv.js & js/configscript.js
	// Using ajax to call /include/update_config.php wich serialize $_POST to sql.
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
		</select>
		<br /><br />
		<div style='text-align:center;'>
			<input type='submit' value='"._MB_XIM_UPDATE."' name='submit' class='update_button'/>
		</div>
	 </form>
	</span>
	<div id='flash'></div>";  
	   
	  $block['config'] = $cf;
	 }
	 }
        return $block;
    } else {
        return false;
    }
}

?>