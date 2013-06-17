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

	include '../../../mainfile.php';
	include_once XOOPS_ROOT_PATH.'/kernel/module.php';
	include XOOPS_ROOT_PATH.'/include/cp_functions.php';
	if ( $xoopsUser ) {
	$xoopsModule = XoopsModule::getByDirname("xim");

		if ( !$xoopsUser->isAdmin($xoopsModule->mid()) ) { 
		redirect_header(XOOPS_URL."/",2,_NOPERM);
		exit();
		}
	}
	else {
	redirect_header(XOOPS_URL."/",2,_NOPERM);
	exit();
	}

	if ( file_exists("../language/".$xoopsConfig['language']."/admin.php") ) {
	include("../language/".$xoopsConfig['language']."/admin.php");
	}
	else {
	include("../language/english/admin.php");
	}
?>