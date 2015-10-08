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


function xim_getAmigos() {
    global $xoopsDB, $xoopsUser;
    $sql = 'SELECT amigosList FROM '.$xoopsDB->prefix('xim_amigos');
    $sql .= ' WHERE (uid='.$xoopsUser->getVar('uid').')';
    $result = $xoopsDB->query($sql);

    if (!$result) {
        return '';
    }
    $result = mysql_fetch_assoc($result);
return $result;
}

function xim_adicionaAmigo($id) {
    global $xoopsDB,  $xoopsUser;
    $sql = 'SELECT amigosList FROM '.$xoopsDB->prefix('xim_amigos');
    $sql .= ' WHERE (uid='.$xoopsUser->getVar('uid').')';
    $result = $xoopsDB->query($sql);

    if (!$result) {
	$amigos= $id;
	$sql = 'INSERT '.$xoopsDB->prefix('xim_amigos');
	$sql .= ' VALUES ('.$xoopsUser->getVar('uid').','.$amigos.')';

    } else{
	$amigos= mysql_fetch_assoc($result).'|'.$id; 
	$sql = 'UPDATE '.$xoopsDB->prefix('xim_amigos');
	$sql .= ' SET amigosList ='.$amigos;
	$sql .= ' WHERE (uid='.$xoopsUser->getVar('uid').')';
    }
	$result = $xoopsDB->query($sql);
}

// Get last saved configs from Db for user
function im_Getconfig ($username) {
 global $xoopsUser, $xoopsDB;
 $persc = array();
 $sql = "SELECT * FROM ".$xoopsDB->prefix('xim_pers_conf')." WHERE username='".$username."'";
  $result = $xoopsDB->query($sql);
	while ($sqlfetch = $xoopsDB->fetchArray($result)) {
	 $persc['sound'] = $sqlfetch['sound'];
	 $persc['status'] = $sqlfetch['status'];
	}
return $persc;
}

// Save config to database
function xim_setPersonalConfig () {
	global $xoopsDB, $xoopsTpl, $xoopsModule,$xoopsUser;
	 $username = $xoopsUser->getVar('uname');
	 // make mysql look up for configs already set
		$checkconfig = "SELECT * FROM ".$xoopsDB->prefix('xim_pers_conf')." WHERE username='".$username."'";
		 $result = $xoopsDB->query($checkconfig);
		  if ($xoopsDB->getRowsNum($result) < 1) {
		   // If none set, insert defaults
		    $default = "INSERT INTO ".$xoopsDB->prefix('xim_pers_conf')." (username, sound, status) VALUES ('$username', 1, 2)";
			 $result = $xoopsDB->queryF($default);
		  } 
		   else {
		   // If set and update do an mysql update
		   }
}

 /**
 * Get xoops_config data
 *
 * Borrowed function from News 1.63 module 
 * (http://xoops.instant-zero.com/modules/repository/product.php?prod_id=1)
 * --------------------------------
 * @param   Place       $User side
 * @param   integer     $repeat 1
 * @return  Status
 */ 
function xim_GetModuleOption($option, $repmodule='xim')
{
	global $xoopsModuleConfig, $xoopsModule;
	static $tbloptions= Array();
	if(is_array($tbloptions) && array_key_exists($option,$tbloptions)) {
		return $tbloptions[$option];
	}

	$retval = false;
	if (isset($xoopsModuleConfig) && (is_object($xoopsModule) && $xoopsModule->getVar('dirname') == $repmodule && $xoopsModule->getVar('isactive'))) {
		if(isset($xoopsModuleConfig[$option])) {
			$retval= $xoopsModuleConfig[$option];
		}
	} else {
		$module_handler =& xoops_gethandler('module');
		$module =& $module_handler->getByDirname($repmodule);
		$config_handler =& xoops_gethandler('config');
		if ($module) {
		    $moduleConfig =& $config_handler->getConfigsByCat(0, $module->getVar('mid'));
	    	if(isset($moduleConfig[$option])) {
	    		$retval= $moduleConfig[$option];
	    	}
		}
	}
	$tbloptions[$option]=$retval;
	return $retval;
}

	function xim_sanitize($text) 
    {
        $text = htmlspecialchars($text, ENT_QUOTES); 
        $myts = MyTextSanitizer::getInstance();
        $text = $myts->displayTarea($text, 1, 1, 1, 1);
        $text = str_replace("\n\r", "\n", $text);
        $text = str_replace("\r\n", "\n", $text);
        $text = str_replace("\n", "<br />", $text);
        $text = str_replace("\"", "'", $text);
        return $text;
    }
   
   /**
     * @Get url of smallworld
     * @returns string
     */ 
    function xim_getHostRequest() 
    {
        $protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') === FALSE ? 'http' : 'https';
        $host     = $_SERVER['HTTP_HOST'];
        $script   = $_SERVER['SCRIPT_NAME'];
        $params   = $_SERVER['QUERY_STRING'];
        $currentUrl = $protocol . '://' . $host;
        return $currentUrl;
    }    
?>