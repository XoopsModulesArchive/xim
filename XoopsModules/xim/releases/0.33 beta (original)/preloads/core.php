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
	    	if(isset($moduleConfig['showfooterbar'])) {
	    		$showFooterBar = $moduleConfig['showfooterbar'];
	    	}
		if(isset($moduleConfig['footerbarstyle'])) {
	    		$footerBarStyle =$moduleConfig['footerbarstyle'];
	    	}
		
	}
	if($style == 0) {
		$xoTheme->addStylesheet(XOOPS_URL.'/modules/xim/css/default_chat.css');
		$xoTheme->addStylesheet(XOOPS_URL.'/modules/xim/css/culex_screen.css');
		$xoTheme->addStylesheet(XOOPS_URL.'/modules/xim/css/configdiv.css');
		//Removed becouse cause unecessary requests when blocks isn't used
		//$xoTheme->addScript(XOOPS_URL.'/modules/xim/js/block_update_default.js'); 
	} else {
		$xoTheme->addStylesheet(XOOPS_URL.'/modules/xim/css/culex_chat.css');
		$xoTheme->addStylesheet(XOOPS_URL.'/modules/xim/css/culex_screen.css');
		$xoTheme->addStylesheet(XOOPS_URL.'/modules/xim/css/configdiv.css');
		//Removed becouse cause unecessary requests when blocks isn't used
		//$xoTheme->addScript(XOOPS_URL.'/modules/xim/js/block_update_culex.js');

	}
        $xoTheme->addScript(XOOPS_URL.'/modules/xim/js/jquery.js');
$xoops_url= XOOPS_URL;
$script= <<<SCRIPT
var xoops_url="$xoops_url";
var xim_url="$xoops_url/modules/xim/";
var showFooterBar = $showFooterBar;
var footerBarStyle = $footerBarStyle;
	var xoops_im = jQuery.noConflict();
SCRIPT;
	$xoTheme->addScript('','',$script);
	$xoTheme->addScript(XOOPS_URL.'/modules/xim/js/chat.js');
	$xoTheme->addScript(XOOPS_URL.'/modules/xim/js/configdiv.js');
	$xoTheme->addScript(XOOPS_URL.'/modules/xim/js/configscript.js');
	$xoTheme->addScript(XOOPS_URL.'/modules/xim/js/soundmanager2.js');
	$xoTheme->addScript(XOOPS_URL.'/modules/xim/js/sm_default.js');
	//$xoTheme->addScript(XOOPS_URL.'/modules/xim/js/jquery.easydrag.js');
	$xoTheme->addScript(XOOPS_URL.'/modules/xim/js/jquery.event.drag-1.5.js');
	if ($showFooterBar!=0) {
		$xoTheme->addStylesheet(XOOPS_URL.'/modules/xim/css/footer.css.php?style='.$footerBarStyle);
	}

    }

}
?>
