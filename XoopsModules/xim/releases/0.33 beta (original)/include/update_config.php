<?php
// $Id: update_config.php ,v 1.oo (alpha 1) 24/02/2010 18:00:00 culex $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                  Copyright (c) 2000-2010 XOOPS.org                        //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

include('../../../mainfile.php');
global $xoopsDB,$xoopsLogger,$xoopsUser;
 $xoopsLogger->activated = false;
if (is_object($xoopsUser)){
	if($_POST) {
	 $sound=$_POST['sound'];
	  $sound=mysql_real_escape_string($sound);
	 
	 $status=$_POST['status'];
	  $status=mysql_real_escape_string($status);
	 
	 $username = $xoopsUser->uname(); 
		$sql = "UPDATE ".$xoopsDB->prefix('xim_pers_conf')." SET sound='".intval($sound)."', status='".intval($status)."' WHERE username='".addslashes($username)."'";
		 $result = $xoopsDB->queryF($sql);
	}
}
?>
<span>Saved!</span>