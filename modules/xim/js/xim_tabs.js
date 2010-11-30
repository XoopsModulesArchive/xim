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

var xoops_imAdmin = jQuery.noConflict();

xoops_imAdmin(document).ready(function() {

	//When page loads...
	xoops_imAdmin(".ximadmin_tab_content").hide(); //Hide all content
	xoops_imAdmin("ul.ximadmin_tabs li:first").addClass("active").show(); //Activate first tab
	xoops_imAdmin(".ximadmin_tab_content:first").show(); //Show first tab content

	//On Click Event
	xoops_imAdmin("ul.ximadmin_tabs li").click(function() {

		xoops_imAdmin("ul.ximadmin_tabs li").removeClass("active"); //Remove any "active" class
		xoops_imAdmin(this).addClass("active"); //Add "active" class to selected tab
		xoops_imAdmin(".ximadmin_tab_content").hide(); //Hide all tab content

		var activeTab = xoops_imAdmin(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
		xoops_imAdmin(activeTab).fadeIn(); //Fade in the active ID content
		return false;
	});

});