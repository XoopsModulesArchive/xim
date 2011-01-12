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

 
class ximAdmin {
	// Get oldes message in Db
	function oldestMsg () {
		global $xoopsDB;
		$sql = "SELECT * FROM ".$xoopsDB->prefix('xim_chat')." WHERE sys='1' ORDER BY sent limit 1";
		$result = $xoopsDB->queryF($sql);
		$counter = $xoopsDB->getRowsNum($result);
		if ($counter < 1) {$date = _AM_XIM_NONEYET;}
		while ($sqlfetch = $xoopsDB->fetchArray($result)) {
		 $date = $sqlfetch['sent'];
		}
			return $date;
	}
	
	// Get average messages sent per day
	function AvgMsgDay ($totaldays) {
		global $xoopsDB;
		$sql = "SELECT count( * ) / ".$totaldays." AS averg FROM ".$xoopsDB->prefix('xim_chat')."";
		$result = $xoopsDB->queryF($sql);
		while ($sqlfetch = $xoopsDB->fetchArray($result)) {
		 $avg = number_format($sqlfetch['averg'], 2, '.', ',');
		}
		return $avg;
	}

	// total users using xim
	function TotalUsers () {
		global $xoopsDB;
		$sql = "SELECT * FROM ".$xoopsDB->prefix('xim_chat')." WHERE sys != '-1'";
		$result = $xoopsDB->queryF($sql);
		$counter = $xoopsDB->getRowsNum($result);
		if ($counter < 1) {
			$sum = 0;
		} else {		
		$i = 0;
		while ( $myrow = $xoopsDB->fetchArray($result) ) {
		$to[$i]['to'] = $myrow['to'];
		$from[$i]['from'] = $myrow['from'];
		$i++;
		}
		 $array1 = $this->flatten($to);
		 $array2 = $this->flatten($from);
		 $all = array_merge($array1, $array2);
		 $sum = count(array_unique($all));
		 $unique = array_unique($all);
		  }
		 return $sum;
	}

	// Get version of module
	function ModuleInstallVersion () {
		global $xoopsModule;
		$version = round($xoopsModule->getVar('version') / 100, 2);
		return $version;
	}
	
	// Get date when Module was installed
	function ModuleInstallDate () {
		global $xoopsModule;
		$date = formatTimestamp($xoopsModule->getVar('last_update'),'m');	
		return $date;
	}

	// Count total days represented in db
	function CountDays () {
		global $xoopsDB;
		$sql="SELECT DATEDIFF(NOW(), `sent`) as intval from ".$xoopsDB->prefix('xim_chat')." WHERE id='1' AND sys != '-1'";
		$result = $xoopsDB->queryF($sql);
		while ($sqlfetch = $xoopsDB->fetchArray($result)) {
		 $days = $sqlfetch['intval'];
		}
			if ($days = $sqlfetch['intval'] <= 0) {
			$days = 0;
			}
		return $days;
	}
	// find user with most posted messages
	function mostactiveusers_allround() {
		global $xoopsDB,$xoopsUser,$xoopsTpl;
		$sql = "SELECT COUNT(*) as cnt, `from` FROM ".$xoopsDB->prefix('xim_chat')." WHERE sys != '-1' GROUP BY `from` ORDER BY cnt DESC LIMIT 20";
		$result = $xoopsDB->queryF($sql);
		$counter = $xoopsDB->getRowsNum($result);
		if ($counter < 1) {
			$msg['cnt'] = _AM_XIM_NO;
			$msg['from'] = _AM_XIM_THEREARE;
			$xoopsTpl->append('topuser', $msg);
		} else {	
		$msg = array();
		$counter = 1;
			while ($row = $xoopsDB->fetchArray($result)) {
               $msg["counter"] = $counter;
			   $msg["img"] = "<img src = '../images/".$counter.".png'></img>";
				if ($msg['counter'] > 3) { $msg["img"] = '';}
			   $msg["cnt"] = $row["cnt"];
			   $msg["from"] = $xoopsUser->getUnameFromId($row["from"]);
				$xoopsTpl->append('topuser', $msg);
				$counter++;
			}
		 }
		return $msg;
	}
		// find user with most posted messages in last 24 hours
		function mostactiveusers_today() {
		global $xoopsDB,$xoopsUser,$xoopsTpl;		
		$sql = "SELECT COUNT( * ) AS cnt, `from` FROM ".$xoopsDB->prefix('xim_chat')." WHERE `sent` > DATE_SUB( NOW( ) , INTERVAL 1 DAY ) AND sys != '-1' GROUP BY `from` ORDER BY cnt DESC LIMIT 20";
		$result = $xoopsDB->queryF($sql);
		if ($xoopsDB->getRowsNum($result) > 0) {
		
		
		$msgtoday = array();
		$counter = 1;
			while ($row = $xoopsDB->fetchArray($result)) {
               $msgtoday["counter"] = $counter;
			   $msgtoday["img"] = "<img src = '../images/".$counter.".png'></img>";
				if ($msgtoday['counter'] > 3) { $msgtoday["img"] = '';}
			   $msgtoday["cnt"] = $row["cnt"];
			   $msgtoday["from"] = $xoopsUser->getUnameFromId($row["from"]);
				$xoopsTpl->append('topusertoday', $msgtoday);
				$counter++;
			}	
		}	else {
			$msgtoday['cnt'] = _AM_XIM_NO;
			$msgtoday['from'] = _AM_XIM_THEREARE;
			$xoopsTpl->append('topusertoday', $msgtoday);
			}
		return $msgtoday;
	}
	
	// Show last admin message in tab
	function lastAdminMessage () {
	global $xoopsDB;
	$sql = "SELECT * FROM ".$xoopsDB->prefix('xim_chat')." WHERE `from` = '-1' ORDER BY `sent` DESC limit 1";
	$result = $xoopsDB->queryF($sql);
	$counter = $xoopsDB->getRowsNum($result);
	if ($counter < 1) {
		$message[0] = _AM_XIM_NOADMINMESSAGEYET;
		$message[1] = _AM_XIM_NOADMINMESSAGEYET_DATE;
	} else	{
				$message = array();
				while ($r = $xoopsDB->fetchArray($result)) {
					$message[0] = $this->sanitize($r['message']);
					$message[1] = $r['sent'];
				}
			}
	return $message;
	}
	
	// Show how many users has read last admin message
	function HowManyMessageReads () {
	global $xoopsDB;
	$count = 0;
	$sql = "SELECT count( * ) AS cntlms, `to` FROM ".$xoopsDB->prefix('xim_chat')." WHERE `from` = '-1' AND `recd` = '1' GROUP BY sent LIMIT 1";
	$result = $xoopsDB->queryF($sql);
		while ($r = $xoopsDB->fetchArray($result)) {
		$count = $r['cntlms'];
		}
		return $count;
	}
	
	// Count number of posts in database
	function countAllLogs () {
	global $xoopsDB;
	$sql = "SELECT COUNT( * ) AS cntall FROM ".$xoopsDB->prefix('xim_chat')." WHERE sys != '-1'";
	$result = $xoopsDB->queryF($sql);
		while ($r = $xoopsDB->fetchArray($result)) {
			$cntall = $r['cntall'];
		}
		return $cntall;
	}
	
	// Count number of posts older than one week
	function CountOlderThanOneWeek () {
	global $xoopsDB;
	$sql = "SELECT COUNT( * ) AS cntold FROM ".$xoopsDB->prefix('xim_chat')." WHERE `sent` <= DATE_SUB( NOW( ) , INTERVAL 1 WEEK ) AND sys != '-1'";
	$result = $xoopsDB->queryF($sql);
		while ($r = $xoopsDB->fetchArray($result)) {
			$cntold = $r['cntold'];
		}
		return $cntold;	
	}
	
	// Make dropdown for logs/message maintnance
	function DoDropDown () {
	$admindropdown = "<form method='post' id='ximAdminLogMaintnance' class='ximadmin' action=''>
		</p><p class='ximadmin'>
		<select name='AdminDDoptions'>
			<option value='0'>"._AM_XIM_LOGS_USER_MOW_RECD."</option>
			<option value='1'>"._AM_XIM_LOGS_USER_MOW_ALL."</option>
			<option value='2'>"._AM_XIM_LOGS_USER_MTW_RECD."</option>
			<option value='3'>"._AM_XIM_LOGS_USER_MTW_ALL."</option>
			<option value='4'>"._AM_XIM_LOGS_USER_MOM_RECD."</option>
			<option value='5'>"._AM_XIM_LOGS_USER_MOM_ALL."</option>
			<option value='6'>"._AM_XIM_LOGS_ADMIN_MOW_RECD."</option>
			<option value='7'>"._AM_XIM_LOGS_ADMIN_MOW_ALL."</option>
			<option value='8'>"._AM_XIM_LOGS_ADMIN_MTW_RECD."</option>
			<option value='9'>"._AM_XIM_LOGS_ADMIN_MTW_ALL."</option>
			<option value='10'>"._AM_XIM_LOGS_ADMIN_MOM_RECD."</option>
			<option value='11'>"._AM_XIM_LOGS_ADMIN_MOM_ALL."</option>
			<option value='12'>"._AM_XIM_LOGS_ADMIN_MSG_ALL_RECD."</option>
		</select>
			<input type='submit' id='XimAminLogsSubmit' value="._AM_XIM_LOGS_SUBMIT." name='"._AM_XIM_LOGS_SUBMIT."' class='ximAdminLogs_update_button' title='"._AM_XIM_LOGS_DOUPDATE."'/>
	 </form></p>
	<p class='ximadmin'><div id='flash'></div></p>";  
		return $admindropdown;
	}
	
	// check server if update is available
	// Server currently at culex.dk
	// Variable $version = current xim version number
	// return csv file with (version, description, status, downloadUrl)
	
function doCheckUpdate () {
 $version = $this->ModuleInstallVersion ();
 $critical = FALSE;
 $update = FALSE;
 $rt = '';
	
	$url = "http://www.culex.dk/updates/xim_version.csv";
	$fileC = file_get_contents($url);
	$read = explode(";", $fileC);
	$upd_img = '../images/upd_ok.png';
 	if ($read[0] > $version && $read[2] == "1") {
		$critical = TRUE; 
		$upd_img = '../images/upd_critical.png';
	}
	if ($read[0] > $version && $read[2] != "1") {
		$update = TRUE; 
		$upd_img = '../images/upd_normal.png';
	}
  if ($critical) { 
	$rt = "<div class='xim_update'><span class='xim_update_header'><img class='xim_upd_img' src='".$upd_img."' />"._AM_XIM_UPDATE_CRITICAL_UPD."</span></div></p>";
	$rt .="<textarea class='xim_update_changelog'>".$read[1]."</textarea><br /><br />";
	$rt .=_AM_XIM_UPDATE_SERVER_FILE."<br /><a href='".$read[3]."'>".$read[3]."</a></div><br/>";
  }	else if ($update) {
		$rt =  "<div class='xim_update'><span class='xim_update_header'><img class='xim_upd_img' src='".$upd_img."' />"._AM_XIM_UPDATE_NORMAL_UPD."</span></div></p>";
		$rt .= "<textarea class='xim_update_changelog'>".$read[1]."</textarea><br /><br />";
		$rt .="<p>". _AM_XIM_UPDATE_SERVER_FILE."<br /><a href='".$read[3]."'>".$read[3]."</a>";
	}	else {
		$rt =  "<div class='xim_update'><span class='xim_update_header'><img class='xim_upd_img' src='".$upd_img."' />"._AM_XIM_UPDATE_YOUHAVENEWESTVERSION."</span></div><br />";
		}
	return $rt;
}
	
	// flatten multidimentional arrays to one dimentional
	function flatten($array) {
		$return = array();
		while(count($array)) {
			$value = array_shift($array);
			if(is_array($value))
				foreach($value as $sub)
					$array[] = $sub;
			else
				$return[] = $value;
		}
		return $return;
	}
	
	function sanitize($text) {
    $text = htmlspecialchars($text, ENT_QUOTES);
    //$text = preg_replace('/([^\s]{10})(?=[^\s])/m', '$1<br />', $text); 
    $myts = MyTextSanitizer::getInstance();
    $text = $myts->displayTarea($text,1,1,1,1);
    $text = str_replace("\n\r","\n",$text);
    $text = str_replace("\r\n","\n",$text);
    $text = str_replace("\n","<br />",$text);
    $text = str_replace("\"","'",$text);

    return $text;
}
	
	function sendall_form () {
	}
}
?>