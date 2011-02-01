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

include_once("../../mainfile.php");

$xoopsOption['template_main'] = 'xim_index.html';
include_once("class/buddy.php");
include_once(XOOPS_ROOT_PATH."/header.php");
global $xoopsUser, $xoTheme;;

//$member_handler =& xoops_gethandler('member', 'system');
/*
$xoTheme->addStylesheet(XOOPS_URL.'/modules/xim/css/xim.css');
$myts =& MyTextSanitizer::getInstance();

$start = (!empty($_REQUEST['start'])) ? intval($_REQUEST['start']) : 0;
$user_limit = $xoopsModuleConfig['users_pager'];
if (isset($_REQUEST['user_limit'])) {
	$user_limit = $_REQUEST['user_limit'];
	$requete_pagenav .= '&amp;user_limit='.$_REQUEST['user_limit'];
	$requete_search .= 'limit : '.$user_limit.'<br />';
	} else {
		$requete_pagenav .= '&amp;user_limit='. $user_limit;//. $xoopsModuleConfig['users_pager'];
		$requete_search .= 'limit : '.$user_limit.'<br />';
}

$form = '<form action="index.php" method="post">'._XIM_USER_SEARCH.' : <input type="text" name="user_uname" value="'.$user_uname.'" size="15"> 
				<select name="user_limit">
					<option value="10" '.($user_limit == 10? 'selected="selected"' : '').'>10</option>
					<option value="50" '.($user_limit == 50 ? 'selected="selected"' : '').'>50</option>
 					<option value="100" '.($user_limit == 100 ? 'selected="selected"' : '').'>100</option>
				</select>
				<input type="hidden" name="user_uname_match" value="XOOPS_MATCH_START" />
				<input type="submit" value="'._XIM_SEARCH.'" name="speed_search">&nbsp;</form>';



$xoopsTpl->assign('form_sort', $form);
$xoopsTpl->assign('form_select_groups', $form_select_groups);
if (isset($_REQUEST['user_uname'])){

$criteria = new CriteriaCompo();
$criteria->add(new Criteria('uname', '%'.$myts->addSlashes(trim($_REQUEST['user_uname'])).'%', 'LIKE'));

$member_handler =& xoops_gethandler('member');
$users_count = $member_handler->getUserCountByGroupLink($groups, $criteria);

if ( $start < $users_count ) {
    //echo sprintf(_AM_SYSTEM_USERS_USERSFOUND, $users_count)."<br />";
    //$criteria->setSort($sort);
    //$criteria->setOrder($order);
    $criteria->setLimit($user_limit);
    $criteria->setStart($start);
    $users_arr = $member_handler->getUsersByGroupLink($groups, $criteria, true);
    $ucount = 0;
}

$xoopsTpl->assign( 'users_count', $users_count );
$xoopsTpl->assign( 'users_display', true );
$xoopsTpl->assign( 'php_selft', $_SERVER['PHP_SELF'] );

$user_uname = (!isset($_REQUEST['user_uname'])) ? '' : $_REQUEST['user_uname'];


//echo $requete_search;
if ( $users_count > 0 ) {
    //echo $requete_search;
    foreach (array_keys($users_arr) as $i) {	
        $users['uid'] = $users_arr[$i]->getVar("uid");
        $users['name'] = $users_arr[$i]->getVar("name");
        $users['uname'] = $users_arr[$i]->getVar("uname");
        $users['url'] = $users_arr[$i]->getVar("url");
        $users['user_avatar'] = ($users_arr[$i]->getVar("user_avatar") == 'blank.gif') ? XOOPS_URL.'/modules/xim/images/default_avatar.png' : XOOPS_URL.'/uploads/'.$users_arr[$i]->getVar("user_avatar");
        $users['reg_date']  = formatTimestamp($users_arr[$i]->getVar("user_regdate"),"m");
        if ($users_arr[$i]->getVar("last_login") > 0 ) {
            $users['last_login'] = formatTimestamp($users_arr[$i]->getVar("last_login"),"m");
        } else {
            $users['last_login'] = _AM_SYSTEM_USERS_NOT_CONNECT;
        }					
        $xoopsTpl->append_by_ref( 'users', $users );
        $xoopsTpl->append_by_ref( 'users_popup', $users );
        unset( $users );
    }
} else {
    $xoopsTpl->assign( 'users_no_found', true );
}

$requete_pagenav .= '&amp;user_uname='.$_REQUEST["user_uname"];


if ($users_count > $user_limit) {
    include_once XOOPS_ROOT_PATH.'/class/pagenav.php';
    $nav = new XoopsPageNav($users_count, $user_limit, $start, 'start', $requete_pagenav);
    $xoopsTpl->assign( 'nav', $nav->renderNav() );
}

}*/
include(XOOPS_ROOT_PATH."/footer.php");
?>
