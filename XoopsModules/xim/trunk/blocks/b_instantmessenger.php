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
    global $xoopsUser, $xoopsModule;
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

    if($style == 0) {
	$block['image'] =XOOPS_URL.'/modules/xim/images/messenger-blue16.png';
    } else {
	$block['image']=XOOPS_URL.'/modules/xim/images/online.png';
    }


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
		     $block['amigos'][] = array('id'=> $onlines[$i]['online_uid'], 'nome' => $onlines[$i]['online_uname']);
	    }
        }
       //$block['online_names'] = $members;
        return $block;
    } else {
        return false;
    }
}
?>