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


class Buddy {


   //Add the user to the buddylist.
   function addBuddy($userID, $buddyId) {

    $sql = "select count(*) as count from ".$xoopsDB->prefix('xim_buddylist')." where (userid = '".mysql_real_escape_string($userID)."' AND buddyid = '".mysql_real_escape_string($buddyID)."') LIMIT 1";
    $query = $xoopsDB->query($sql);     
    $row = mysql_fetch_assoc($query);
      
      if($row['count'] == 0) {
	 $sql = "insert into ".$xoopsDB->prefix('xim_buddylist')." values ('".mysql_real_escape_string($userID)."', '".mysql_real_escape_string($buddyId)."',0)";
	 $query = $xoopsDB->query($sql);
         return 1;
      } else {
         return 0;
      }
   }
   

    // Remove the buddy from the buddylist.
   function removeBuddy($userID, $buddyId) {
          $sql = "select count(*) as count from ".$xoopsDB->prefix('xim_buddylist')." where (userid = '".mysql_real_escape_string($userID)."' AND buddyid = '".mysql_real_escape_string($buddyID)."') LIMIT 1";
	  $query = $xoopsDB->query($sql);     
      
      if(mysql_num_rows($query) > 0) {
         $sql = "DELETE FROM from ".$xoopsDB->prefix('xim_buddylist')." where (userid = '".mysql_real_escape_string($userID)."' AND buddyid = '".mysql_real_escape_string($buddyID)."'";
		 $query = $xoopsDB->queryF($sql);
         return 1;
      } else {
         return 0;
      }  
   }
   

   //Retrieves a list of all of the user's buddies.
   function getBuddylist($userID) {
      $sql = "select buddyid from ".$xoopsDB->prefix('xim_buddylist')." where userid = '".mysql_real_escape_string($userID)."'";
      $query = $xoopsDB->query($sql);   
      $buddylist = array();
      while($row = mysql_fetch_assoc($query))
         if ($row['blocked']==0) {
	      $buddylist['normal'][] = $row;
	 }else {
	      $buddylist['blocked'][] = $row;
	 }
      return $buddylist;
   }

}
?>