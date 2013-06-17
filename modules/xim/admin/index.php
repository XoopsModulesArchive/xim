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

require_once 'admin_header.php'; 
require_once '../../../include/cp_header.php';

require_once XOOPS_ROOT_PATH . '/class/template.php';
if (!isset($xoopsTpl)) {$xoopsTpl = new XoopsTpl();}
$xoopsTpl->caching=0;
require_once XOOPS_ROOT_PATH . '/modules/xim/class/adminclass.php';
xoops_cp_header();
if (isset($_POST['xim_admin_message'])) {$_POST['xim_admin_message'] = '';}
$admin = new ximAdmin();

// --------------- First tab in admin ---------------

// Find oldest message and apply to template
$dateoffirstmessage = $admin->oldestMsg();
// Get days number
$totaldays = $admin->CountDays();
// get average messages per day
$avgperday = $admin->AvgMsgDay ($totaldays);
// XIM version number
$installversion = $admin->ModuleInstallVersion ();
// XIM install date
$installdate = $admin->ModuleInstallDate ();

//check current version of XIM, return desc,link,version if new available
$installCheck = $admin->doCheckUpdate ();

// Count members using XIM
$sumallusers = $admin->TotalUsers ();
// Find list of most active users (total)
$admin->mostactiveusers_allround();
// Find list of most active users (24 hours)
$admin->mostactiveusers_today();

// --------------- second tab in admin ---------------

// Get last admin message from db
$lam = $admin->lastAdminMessage ();
	$lam_msg = $lam[0];
	$lam_date = $lam[1];

// How many has read the last Admin message
$lam_count  = $admin->HowManyMessageReads ();

// --------------- Third tab in admin ---------------

// How many posts in total
$totalposts = $admin->countAllLogs ();

// How many posts older than 1 week )
$olderoneweek = $admin -> CountOlderThanOneWeek ();

// Show dropdown for logs / messages administration
$admindropdown = $admin->DoDropDown();

// ---------------- end of tabs ---------------- //

// template assignments
	// tab titles
	$xoopsTpl->assign('lang_statistics', _AM_XIM_STATISTICS_TITLE); 
	$xoopsTpl->assign('lang_moduleinfo', _AM_XIM_MODULEINFO); 
	$xoopsTpl->assign('lang_adminmessagesend', _AM_XIM_ADMINMESSAGESEND); 
	$xoopsTpl->assign('lang_logsmaintnance', _AM_XIM_LOGSMAINTNANCE); 
	
	$xoopsTpl->assign('lang_userstats', _AM_XIM_USERSTATS); 
	$xoopsTpl->assign('lang_adminmessage', _AM_XIM_ADMINMESSAGE);
	$xoopsTpl->assign('lang_installversion', _AM_XIM_MODULEINSTALL); 
	$xoopsTpl->assign('lang_installversion_status', _AM_XIM_UPDATE_STATUS); 
	$xoopsTpl->assign('lang_installdate', _AM_XIM_INSTALLDATE); 
	$xoopsTpl->assign('lang_dateoffirstmessage', _AM_XIM_DATEOFFIRSTMESSAGE); 
	$xoopsTpl->assign('lang_totalusers', _AM_XIM_TOTALUSERS); 
	$xoopsTpl->assign('lang_averagemsgperday', _AM_XIM_AVERAGEMSGPERDAY); 
	$xoopsTpl->assign('lang_topchatters',_AM_XIM_TOPCHATTERS);
	$xoopsTpl->assign('lang_topchatterstoday',_AM_XIM_TOPCHATTERS_TODAY);
	$xoopsTpl->assign('lang_messages',_AM_XIM_MESSAGES);
	$xoopsTpl->assign('lang_msgsend',_AM_XIM_SUBMIT);
	$xoopsTpl->assign('lang_lam_title',_AM_XIM_LASTADMINMESSAGE_TITLE);
	$xoopsTpl->assign('lang_lam_msg',_AM_XIM_LASTADMINMESSAGE_MSG);
	$xoopsTpl->assign('lang_lam_date',_AM_XIM_LASTADMINMESSAGE_DATE);
	$xoopsTpl->assign('lang_lam_was_read',_AM_XIM_LASTADMINMESSAGE_WASREAD);
	$xoopsTpl->assign('lang_lam_users',_AM_XIM_LASTADMINMESSAGE_USERS);
	$xoopsTpl->assign('lang_logs_title',_AM_XIM_LOGS_TITLE);
	$xoopsTpl->assign('lang_db_has',_AM_XIM_DBHAS);
	$xoopsTpl->assign('lang_db_posts',_AM_XIM_DBHASPOSTS);
	$xoopsTpl->assign('lang_db_old',_AM_XIM_DBHASOLDPOSTS);
	$xoopsTpl->assign('lang_help',_AM_XIM_HELP);
	$xoopsTpl->assign('lang_prefs',_MI_SYSTEM_ADMENU6);
	$xoopsTpl->assign('lang_prefslink',"<a href='../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod="
		.$xoopsModule ->getVar('mid')."'>"._MI_SYSTEM_ADMENU6."</a>");

	
	// Post to all message
	$xoopsTpl->assign('lang_adminposttoallmessage',_AM_XIM_POSTTOALL_TITLE);
	$xoopsTpl->assign('lang_adminposttoallmessagedesc',_AM_XIM_POSTTOALL_DESC);
	$xoopsTpl->assign('lang_posttoallcount',_AM_XIM_POSTTOALL_COUNT);
	$xoopsTpl->assign('lang_posttoallsubmit',_AM_XIM_POSTTOALL_SUBMIT);
	
	// help file from admin
	$xoopsTpl->assign('lang_hlp_about',_AM_XIM_HELP_ABOUT);
	$xoopsTpl->assign('lang_hlp_preface',_AM_XIM_HELP_PREFACE);
	$xoopsTpl->assign('lang_hlp_requirements_t',_AM_XIM_HELP_HEADER_REQUIREMENTS);
	$xoopsTpl->assign('lang_hlp_requirements',_AM_XIM_HELP_REQUIREMENTS);
	$xoopsTpl->assign('lang_hlp_recommended_t',_AM_XIM_HELP_HEADER_RECOMMENDED);
	$xoopsTpl->assign('lang_hlp_recommended',_AM_XIM_HELP_RECOMMENDED);
	$xoopsTpl->assign('lang_hlp_installation_t',_AM_XIM_HELP_HEADER_INSTALLATION);
	$xoopsTpl->assign('lang_hlp_firsttime',_AM_XIM_HELP_FIRSTTIMEINSTALL);
	$xoopsTpl->assign('lang_hlp_hostedplatform_t',_AM_XIM_HELP_HEADER_HOSTED_PLATFORM);
	$xoopsTpl->assign('lang_hlp_hostedplatform',_AM_XIM_HELP_HOSTED_PLATFORM);
	$xoopsTpl->assign('lang_hlp_upgrading_t',_AM_XIM_HELP_HEADER_UPGRADING);
	$xoopsTpl->assign('lang_hlp_upgrading',_AM_XIM_HELP_UPGRADING);
	$xoopsTpl->assign('lang_hlp_faq_t',_AM_XIM_HELP_HEADER_FAQ);
	$xoopsTpl->assign('lang_hlp_commen1_t',_AM_XIM_HELP_HEADER_COMMENPROBLEMS1);
	$xoopsTpl->assign('lang_hlp_commen1',_AM_XIM_HELP_COMMENPROBLEMS1);
	$xoopsTpl->assign('lang_hlp_soundproblems_t',_AM_XIM_HELP_HEADER_SOUNDPROBLEMS);
	$xoopsTpl->assign('lang_hlp_soundproblems',_AM_XIM_HELP_SOUNDPROBLEMS);
	$xoopsTpl->assign('lang_hlp_contacts_t',_AM_XIM_HELP_HEADER_CONTACTS);
	$xoopsTpl->assign('lang_hlp_otherhelp',_AM_XIM_HELP_OTHERHELP);
	
	$xoopsTpl->assign('lang_logs_clean',_AM_XIM_LOGSCLEAN);
	$xoopsTpl->assign('lang_logs_clean_desc',_AM_XIM_LOGSCLEANDESC);
	
	$xoopsTpl->assign('installversion', $installversion);
	$xoopsTpl->assign('installdate', $installdate); 
	$xoopsTpl->assign('installversion_status',$installCheck);
	$xoopsTpl->assign('dateoffirstmessage', $dateoffirstmessage); 
	$xoopsTpl->assign('totalusers', $sumallusers); 
	$xoopsTpl->assign('averagemsgperday', $avgperday); 	
	$xoopsTpl->assign('lam_msg', $lam_msg); 
	$xoopsTpl->assign('lam_date', $lam_date); 
	$xoopsTpl->assign('lam_count', $lam_count);
	$xoopsTpl->assign('dbhasposts', $totalposts);
	$xoopsTpl->assign('dbhasoldposts', $olderoneweek);
	$xoopsTpl->assign('adminlogsdropdown',$admindropdown);


	$xoopsTpl->display('db:xim_admin.html');
	
	global $xoTheme; 
	
	$xoTheme->addStyleSheet('modules/xim/css/ximAdmin.css');
	$xoTheme->addScript(XOOPS_URL . '/browse.php?Frameworks/jquery/jquery.js');
	$xoTheme->addScript(XOOPS_URL . '/browse.php?Frameworks/jquery/plugins/jquery.ui.js');
	$xoTheme->addScript('modules/xim/js/xim_tabs.js');
	$xoTheme->addScript(XOOPS_URL . '/browse.php?Frameworks/jquery/plugins/jquery.form.js');
	
	$xoTheme->addScript('modules/xim/js/adminddselector.js');
	$xoTheme->addScript(XOOPS_URL . '/modules/xim/js/jquery.form.js');
	
xoops_cp_footer();
?>
