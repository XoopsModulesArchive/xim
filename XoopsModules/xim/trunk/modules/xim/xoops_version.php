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

if (!defined('XOOPS_ROOT_PATH')) {
	die('XOOPS root path not defined');
}
$modversion['dirname'] = basename(dirname(__FILE__));
$modversion['name'] = _MI_XIM_MODULE_NAME;
$modversion['version'] = 1.03;
$modversion['description'] = _MI_XIM_MODULE_DESC;
$modversion['author'] = "Andrax & Culex";
$modversion['credits'] = _XIM_CREDIT;
$modversion['Testers'] = "ArtsGeral, Edison, Izzy, Rmarx, Mazarin, btesec, Kris_fr, Runeher, Stance";
$modversion['license'] = "GPL see LICENSE";
$modversion['official'] = 1;
$modversion['image'] = "images/xim.png";

// Menu
$modversion['hasMain'] = 1;

// System Menu
$modversion['system_menu'] = 1;

// Admin
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

$modversion['sqlfile']['mysql'] = "sql/mysql.sql";

// Tables
$modversion['tables'][0] = 'xim_chat';
//$modversion['tables'][1] = 'xim_friends'; //Future buddy list
$modversion['tables'][2] = 'xim_pers_conf'; //Personal configs

//Templates
$modversion['templates'][0]['file'] = 'xim_index.html';
$modversion['templates'][0]['description'] = '';
$modversion['templates'][1]['file'] = 'xim_admin.html';
$modversion['templates'][1]['description'] = '';

//Module Configs
$i=0;
$modversion['config'][$i]['name'] = 'showfooterbar';
$modversion['config'][$i]['title'] = '_XIM_SHOW_FOOTER_BAR';
$modversion['config'][$i]['description'] = '_XIM_SHOW_FOOTER_BAR_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;

$i++;
$modversion['config'][$i]['name'] = 'footerbarstyle';
$modversion['config'][$i]['title'] = '_XIM_FOOTER_BAR_STYLE';
$modversion['config'][$i]['description'] = '_XIM_FOOTER_BAR_TYPE_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;
$modversion['config'][$i]['options'] = array('_XIM_FOOTER_FULL' => 0, '_XIM_FOOTER_TINY' => 1);

$i++;
$modversion['config'][$i]['name'] = 'chatwindowstyle';
$modversion['config'][$i]['title'] = '_XIM_CHATWINDOWSTYLE_STYLE';
$modversion['config'][$i]['description'] = '_XIM_CHATWINDOWSTYLE_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 'default';
$modversion['config'][$i]['options'] = array(
									'_XIM_CHATWINDOWSTYLE_DEFAULT' 	=>	0,
									'_XIM_CHATWINDOWSTYLE_WHITE'	=>	1,
									'_XIM_CHATWINDOWSTYLE_BLACK'	=>	2,
									'_XIM_CHATWINDOWSTYLE_STIKY'	=>	3,							
									'_XIM_CHATWINDOWSTYLE_ALERT'	=>	4
									);
									
// Blocks
$i=0;
$modversion['blocks'][$i]['file'] = "b_instantmessenger.php";
$modversion['blocks'][$i]['name'] = _MB_XIM_BLOCK;
$modversion['blocks'][$i]['description'] = 'This is a Block for the empty module';
$modversion['blocks'][$i]['show_func'] = "b_instantmessenger";
$modversion['blocks'][$i]['template'] = 'b_instantmessenger.html';
$i++;
?>
