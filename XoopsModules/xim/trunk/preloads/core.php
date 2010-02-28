<?php
defined('XOOPS_ROOT_PATH') or die('Restricted access');

class XimCorePreload extends XoopsPreloadItem{

    function eventCoreHeaderAddmeta(){
	global $xoTheme;
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
		$xoTheme->addStylesheet(XOOPS_URL.'/modules/xim/css/default_chat.css');
		$xoTheme->addStylesheet(XOOPS_URL.'/modules/xim/css/culex_screen.css');
	} else {
		$xoTheme->addStylesheet(XOOPS_URL.'/modules/xim/css/culex_chat.css');
		$xoTheme->addStylesheet(XOOPS_URL.'/modules/xim/css/culex_screen.css');
		$xoTheme->addStylesheet(XOOPS_URL.'/modules/xim/css/configdiv.css');
	}

        $xoTheme->addScript(XOOPS_URL.'/modules/xim/js/jquery.js');
	$xoTheme->addScript('','','var xim_url="'.XOOPS_URL.'/modules/xim/";
	var im = jQuery.noConflict();');
	$xoTheme->addScript(XOOPS_URL.'/modules/xim/js/chat.js');
	$xoTheme->addScript(XOOPS_URL.'/modules/xim/js/configdiv.js');
	$xoTheme->addScript(XOOPS_URL.'/modules/xim/js/configscript.js');
	$xoTheme->addScript(XOOPS_URL.'/modules/xim/js/soundmanager2.js');
	$xoTheme->addScript(XOOPS_URL.'/modules/xim/js/sm_default.js');
    }

}
?>
