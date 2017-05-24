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

include 'header.php';
$xoopsLogger->activated = false;
include_once (XOOPS_ROOT_PATH.'/class/template.php');
global $xoopsUser;
    if (!is_object($xoopsUser)) {
        return false;
    }
	$tpl = new XoopsTpl();
	$panel = array();
    if ($xoopsUser->isAdmin()) {
	$panel['is_admin']=1;
    } else {
	$panel['is_admin']=0;
    }

	$panel['lang_friends'] = _XIM_FRIENDS;
	$panel['lang_friends_online'] = _XIM_FRIENDS_ONLINE;
	$panel['config_sound']= _XIM_USESOUND;
	$panel['sound_options'] = array(_XIM_NOSOUND, _XIM_SOUND1, _XIM_SOUND2, _XIM_SOUND3, _XIM_SOUND4, _XIM_SOUND5, _XIM_SOUND6, _XIM_SOUND7, _XIM_SOUND8, _XIM_SOUND9, _XIM_SOUND10);
	$panel['config_status'] = _XIM_STATUS;
	$panel['status_options'] = array(_XIM_HIDDEN, _XIM_BUSY, _XIM_ONLINE,_XIM_OFFLINE);	 		
	$panel['config_save']= _XIM_UPDATE;

if ($_GET['style']==0) {
	$panel['home'] = _XIM_BAR_HOME;
	$panel['profile'] = _XIM_BAR_VIEW_PROFILE;
	$panel['editprofile'] = _XIM_BAR_EDIT_PROFILE;
	$panel['notifications'] = _XIM_BAR_NOTIFICATIONS;
	$panel['admin'] = _XIM_BAR_ADMIN; 
	$criteria = new CriteriaCompo(new Criteria('read_msg', 0));
	$criteria->add(new Criteria('to_userid', $xoopsUser->getVar('uid')));
    
	$pm_handler =& xoops_gethandler('privmessage');
    
	$xoopsPreload = XoopsPreload::getInstance();
	$xoopsPreload->triggerEvent('system.panels.system_panels.usershow', array(&$pm_handler));

	$panel['new_messages'] = $pm_handler->getCount($criteria);
	$panel['inbox'] = _XIM_BAR_MESSAGES;

	$tpl->assign('panel', $panel);
	$tpl->display(XOOPS_ROOT_PATH .'/modules/xim/templates/xim_full_footerbar.html');
} else {
	$tpl->assign('panel', $panel);
	$tpl->display(XOOPS_ROOT_PATH .'/modules/xim/templates/xim_tiny_footerbar.html');
}

?>

