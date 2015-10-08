/*
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
*/

xoops_im(document).ready(function() {
	//hide the all of the element with class msg_body
	xoops_im(".xim_configDiv_body").hide();

	//toggle the componenet with class msg_body
	xoops_im(".xim_configDiv_head").click(function() {
		xim_reSetConf();
    	xoops_im(".xim_configDiv_body").slideToggle(2500);
	});
});

xoops_im(function() {
	xoops_im(".update_button").click(function(){
		var sound = xoops_im("#sound").val();
		var status = xoops_im("#status").val();
		dataString = xoops_im("#config").serialize();
		//var dataString = 'sound='+ sound + '&status=' + status;
		if(status=='' || sound==''){
			alert('Please Give Valid Details');}
		else{
			xoops_im("#flash").show();
			xoops_im("#flash").fadeIn(800).html('<img src="'+xim_url+'/images/ajaxloader.gif" alt=""/>Saved!');
			xoops_im.ajax({
				type: "POST",
				url: xim_url+"include/update_config.php",
				data: dataString,
				cache: false,
				success: function(html){
					xoops_im("#flash").hide(2000);
					xoops_im(".xim_configDiv_body").hide(6000);
				}
			});
		}
		return false;
	}); 
});
