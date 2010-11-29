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

xoops_imAdmin(document).ready(function(){
  
  xoops_imAdmin('#xim_admin_message').val("");
  xoops_imAdmin("#xim_admin_message").keyup(function() {
     limitChars(300);
  });
  
   xoops_imAdmin(".xim_admin_button").click(function() {
	     if(xoops_imAdmin('#xim_admin_message').val()==''){
        xoops_imAdmin('#xim_admin_error').html("Message cannot be empty").addClass('xim_admin_error').hide().fadeIn("slow");
			setTimeout(function() { 
				xoops_imAdmin('#xim_admin_error').html("<br>").hide().fadeIn("fast");
			}, 2000);	 
        return false; 
	 } else {
		postData();
		}
		 });
		 
	 if(xoops_imAdmin('#xim_admin_message').val().length>300){
	 xoops_imAdmin('#xim_admin_error').html("Message must not exceed 300 characters.").addClass('xim_admin_error').hide().fadeIn("slow");
	 		setTimeout(function() { 
			xoops_imAdmin('#xim_admin_error').html("<br>").hide().fadeIn("fast");
		}, 2000);	
	 return false; 
	 };

	 
	 if(postData()){
	 xoops_imAdmin('#xim_admin_error').html("Processing.....").removeClass('xim_admin_error').hide().fadeIn("slow");
	 xoops_imAdmin.timer(10000,function(){
	 xoops_imAdmin('#xim_admin_error').html("Message inserted!").addClass('success').hide().fadeIn("slow");
	  setTimeout(function() { 
		xoops_imAdmin('#xim_admin_count').html('0');
		xoops_imAdmin('#xim_admin_error').html("<br>").hide().fadeIn("fast");
	  }, 2000);	 
		xoops_imAdmin('#xim_admin_message').val("");
	 });
	 }else{
	 //xoops_imAdmin('#xim_admin_error').html("Database Error.").fadeIn("slow");
	 return false; 
	 }
	 return false;

  }); 

function limitChars(limit){

	var text = xoops_imAdmin('#xim_admin_message').val(); 
	var textlength = text.length;

	xoops_imAdmin('#xim_admin_count').html(textlength);
	//xoops_imAdmin('#xim_admin_error').hide();

	if(textlength > limit){
		
	 xoops_imAdmin('#xim_admin_error').html("Message must not exceed 300 characters.").addClass('xim_admin_error').hide().fadeIn("slow");
		setTimeout(function() { 
			xoops_imAdmin('#xim_admin_error').html("<br>").hide().fadeIn("fast");
		}, 2000);	 
	 return false; 
	}	else{
			return true;
		}
}

function postData(){
	var xim_admin_message = xoops_imAdmin('#xim_admin_message').val();
	 var dataString = 'xim_admin_message=' + xim_admin_message;  
	 if (xim_admin_message === '') {
	 return false;
	 }
	 xoops_imAdmin.ajax({  
	   type: "POST",  
	   url: "../admin/adminsend.php",  
	   data: dataString,  
	   error: function(){
		 //alert('Error loading document');
		 return false; 
	   },
	   success: function() {
		 xoops_imAdmin('#xim_admin_error').html("Message inserted!").addClass('success').hide().fadeIn("slow");
		 setTimeout(function() { 
			xoops_imAdmin('#xim_admin_message').val("");
			xoops_imAdmin('#xim_admin_count').html('0');
			xoops_imAdmin('#xim_admin_error').html("<br>").hide().fadeIn("fast");
			
		}, 2000);	 
	   }
	 });
	//return true;
}

/*
 * jQuery Timer Plugin
 * http://www.evanbot.com/article/jquery-timer-plugin/23
 *
 * @version      1.0
 * @copyright    2009 Evan Byrne (http://www.evanbot.com)
 */ 

xoops_imAdmin.timer = function(time,func,callback){
	var a = {timer:setTimeout(func,time),callback:null}
	if(typeof(callback) == 'function'){a.callback = callback;}
	return a;
};

xoops_imAdmin.clearTimer = function(a){
	clearTimeout(a.timer);
	if(typeof(a.callback) == 'function'){a.callback();};
	return this;
};