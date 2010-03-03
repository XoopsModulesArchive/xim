// $Id: configscript.js ,v 1.oo (alpha 1) 24/02/2010 18:00:00 culex $
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

im(function() {
im(".update_button").click(function()
{
var sound = im("#sound").val();
var status = im("#status").val();
dataString = im("#config").serialize();
//var dataString = 'sound='+ sound + '&status=' + status;
if(status=='' || sound=='')
{
alert('Please Give Valid Details');
}
else
{
im("#flash").show();
im("#flash").fadeIn(800).html('<img src="'+xim_url+'/images/ajaxloader.gif"/>Saved!');
im.ajax({
type: "POST",
url: xim_url+"include/update_config.php",
data: dataString,
cache: false,
success: function(html){
im("#flash").hide(2000);
im(".xim_configDiv_body").hide(6000);
}
});
}return false;
}); });