<?php
/*********************************************************************
    Author: Andrax                                                         
    URL: http://guxbrasil.ning.com
    E-Mail: lcbc@ig.com.br
**********************************************************************/
if (!defined('XOOPS_ROOT_PATH')) {
	die('XOOPS root path not defined');
}
$modversion['dirname'] = basename(dirname(__FILE__));
$modversion['name'] = _MI_XIM_MODULE_NAME;
$modversion['version'] = '0.03';
$modversion['description'] = _MI_XIM_MODULE_DESC;
$modversion['author'] = "Andrax & Culex";
$modversion['credits'] = _XIM_CREDIT;
$modversion['help'] = "";
$modversion['Testers'] = "ArtsGeral, Edison, Izzy, Rmarx, Culex, Mazarin, btesec";
$modversion['license'] = "GPL see LICENSE";
$modversion['official'] = 0;
$modversion['image'] = "images/xim.png";

// Menu
$modversion['hasMain'] = 1;

// Admin
$modversion['hasAdmin'] = 1;
// $modversion['adminindex'] = "admin/index.php";
// $modversion['adminmenu'] = "admin/menu.php";
$i=0;
$modversion['config'][$i]['name'] = 'chatstyle';
$modversion['config'][$i]['title'] = '_XIM_STYLE';
$modversion['config'][$i]['description'] = "";
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;
$modversion['config'][$i]['options'] = array( '_XIM_DEFAULT' => 0, '_XIM_CULEX' => 1);


$modversion['sqlfile']['mysql'] = "sql/mysql.sql";

// Tables
$modversion['tables'][0] = 'xim_chat';
$modversion['tables'][1] = 'xim_friends'; //Future buddy list

//Templates
$modversion['templates'][0]['file'] = 'xim_index.html';
$modversion['templates'][0]['description'] = '';

// Blocks
$i=0;
$modversion['blocks'][$i]['file'] = "b_instantmessenger.php";
$modversion['blocks'][$i]['name'] = '_MI_XIM_BLOCK';
$modversion['blocks'][$i]['description'] = 'This is a Block for the empty module';
$modversion['blocks'][$i]['show_func'] = "b_instantmessenger";
$modversion['blocks'][$i]['template'] = 'b_instantmessenger.html';
$i++;
?>
