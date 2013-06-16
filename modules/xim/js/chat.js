/*

Copyright (c) 2009 Anant Garg (anantgarg.com | inscripts.com)

This script may be used for non-commercial purposes only. For any
commercial purposes, please contact the author at 
anant.garg@inscripts.com

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.

*/
//Algumas alterações realizada por Andrax na adptação ao XOOPS

var windowFocus = true;
var xim_username;
var userAvatar;
var userSound = 0;
var chatHeartbeatCount = 0;
var minChatHeartbeat = 1000;
var maxChatHeartbeat = 33000;
var chatHeartbeatTime = minChatHeartbeat;
var originalTitle;
var blinkOrder = 0;
var un;

var chatboxFocus = new Array();
var newMessages = new Array();
var newMessagesWin = new Array();
var newMessagesUser = new Array();
var chatBoxes = new Array();
document.containers= new Object();

	var refreshId = setInterval(function() {
	xoops_im('#online_friends').load(xim_url+'blocks/blockupdater.php');
	}, 5000);

xoops_im(document).ready(function(){
	// if exists zetagenesis toolbar do hide it to not overlap 2 toolbars
	xoops_im('#xo-footerstatic').hide();
	originalTitle = document.title;
	xim_startChatSession();
	xoops_im([window, document]).blur(function(){
		windowFocus = false;
	}).focus(function(){
		windowFocus = true;
		document.title = originalTitle;
	});
});

function xim_chatWith(userId, chatusername) {
	if (showFooterBar ==1) {
		xoops_im(".subpanel").hide(); //hide subpanel
		xoops_im("#footpanel li a").removeClass('active'); //remove active class on subpanel 
	}
	avatar = xim_getAvatar(userId);
	xim_createChatBox(userId, chatusername, avatar);
	xoops_im("#MBchatbox_"+userId+" .chatboxtextarea").focus();
}

function xim_createChatBox(containerId,chatBoxName,avatar){
	if (xoops_im("#MBchatbox_"+containerId).length > 0) {
		 if (xoops_im("#MBchatbox_"+containerId).mb_getState('iconized')) {
			xoops_im("#MBchatbox_"+containerId).mb_iconize();
			xoops_im("#MBchatbox_"+containerId+" .chatboxtextarea").focus();
		 }
		if (xoops_im("#MBchatbox_"+containerId).mb_getState('closed')) {
			xoops_im("#MBchatbox_"+containerId).mb_open();
			xoops_im("#MBchatbox_"+containerId+" .chatboxtextarea").focus();
		}
		return;
	}
	var html = '<div id="MBchatbox_'+containerId+'" class="containerPlus draggable resizable {buttons:\'m,i,c\', icon:\'browser.png\', dckicon:\''+avatar+'\', skin:\''+cws+'\',iconized:\'false\',dock:\'dock\', width:\'250\', height:\'300\',rememberMe:\'true\', minWidth:\'250\', grid:\'5\', minHeight:\'300\'}" style="position:absolute;top:100px;left:100px"></div>';
	
	if (containerId != '-1') {
	var content ='<div class="no"><div class="ne"><div class="n">'+chatBoxName+'</div></div><div class="o"><div class="e"><div class="c"><div class="mbcontainercontent"></div><div class="chatboxtextarea"><textarea  onkeydown="javascript:return checkChatBoxInputKey(event,this,\''+containerId+'\');"></textarea></div></div></div></div><div class="so"><div class="se"><div class="s"></div></div></div>';
	}	else {
	var content ='<div class="no"><div class="ne"><div class="n">'+chatBoxName+'</div></div><div class="o"><div class="e"><div class="c"><div class="mbcontainercontent"></div><div>No reply possible with system messages</div></div></div></div><div class="so"><div class="se"><div class="s"></div></div></div>';
		}
	
          xoops_im("body").append(html);
	  xoops_im("#MBchatbox_"+containerId).append(content);
          xoops_im("#MBchatbox_"+containerId).buildContainers({
            containment:"document",
            elementsPath:xim_url+"images/elements/",
	    dockedIconDim:20,
            effectDuration:200,
	    onRestore:function(o){},
	    onIconize:function(o){},
		onResize:function(o){},
            onLoad:function(o){
              document.containers[o.attr("id")]=1;
			  xim_keepInWindow (containerId);
            },
            onClose:function(o){
              o.mb_removeCookie("closed");
			  o.mb_removeCookie("iconized");
			  o.mb_removeCookie("collapsed");
			  o.mb_removeCookie("restored");
	      xoops_im.post(xim_url+"chat.php?action=closechat", { chatbox: containerId } , function(data){ });
	      chatBoxes = xoops_im.grep(chatBoxes, function(value) {  return value != containerId; });
              document.containers[o.attr("id")]=null;
            }
          });
      chatBoxes.push(containerId);
}

function xim_chatHeartbeat(){

	var itemsfound = 0;
	if (windowFocus == false) {
 
		var blinkNumber = 0;
		var titleChanged = 0;
		for (x in newMessagesWin) {
			if (newMessagesWin[x] == true) {
				++blinkNumber;
				if (blinkNumber >= blinkOrder) {
					document.title = newMessagesUser[x]+' says...';
					titleChanged = 1;
					break;	
				}
			}
		}
		
		if (titleChanged == 0) {
			document.title = originalTitle;
			blinkOrder = 0;
		} else {
			++blinkOrder;
		}

	} else {
		for (x in newMessagesWin) {
			newMessagesWin[x] = false;
		}
	}

	for (x in newMessages) {
		if (newMessages[x] == true) {
			if (chatboxFocus[x] == false) {
				//FIXME: add toggle all or none policy, otherwise it looks funny
				xoops_im('#chatbox_'+x+' .chatboxhead').toggleClass('chatboxblink');
			}
		}
	}
	
	xoops_im.ajax({
	  url: xim_url+"chat.php?action=chatheartbeat",
	  cache: false,
	  dataType: "json",
	  success: function(data) {
		xoops_im.each(data.items, function(i,item){
			if (item)	{ // fix strange ie bug
				chatboxID = item.f;
				userSound = item.q;
                
				if (xoops_im("#MBchatbox_"+chatboxID).length <= 0) {
					xim_createChatBox(chatboxID,item.n, item.a);
				}
				if (xoops_im("#MBchatbox_"+chatboxID).mb_getState('closed')) {
					xoops_im("#MBchatbox_"+chatboxID).mb_open();
					xim_doBounce (chatboxID,1,un);
				}
				// if iconized do bounce in dock
				if (xoops_im("#MBchatbox_"+chatboxID).mb_getState('iconized')) {
					un = xoops_im(item.n).attr('title');
					xim_doBounce (chatboxID,0,un);
				}				
				if (item.s == 1) {
					item.f = xim_username;
				}
				if (item.s == 2) {
					xoops_im("#MBchatbox_"+chatboxID+" .mbcontainercontent").append('<div class="chatboxmessage"><span class="chatboxinfo">'+item.m+'</span></div>');
				} else {
					newMessages[chatboxID] = true;
					newMessagesWin[chatboxID] = true;
				// Added stripHTML function to remove html tags in document.title	
					newMessagesUser[chatboxID]= xim_stripHTML(item.n);
					xoops_im("#MBchatbox_"+chatboxID).find(".mbcontainercontent:first").append('<div class="chatboxmessage"><span class="ghost"></span><span class="chatAvatar"><img src="'+item.a+'" alt=""/></span><span class="chatboxmessagefrom">'+item.n+':&nbsp;&nbsp;</span><span class="chatboxmessagecontent">'+item.m+'</span></div>');
	
				// Making sure soundmanager is ready before calling play
				soundManager.onready(function() {
					soundManager.createSound({
						id: userSound, // required
						url: userSound, // required
						// optional sound parameters here, see Sound Properties for full list
						volume: 50,
						autoPlay: true
					});
					// Play item.q (ie sound selected in options)
					soundManager.play(userSound, userSound);
				}); // End soundmager call
					// bounce chat window
					xim_doBounce (chatboxID,1,un);
				}
				xoops_im("#MBchatbox_"+chatboxID+" .mbcontainercontent").scrollTop(xoops_im("#MBchatbox_"+chatboxID+" .mbcontainercontent")[0].scrollHeight);
				itemsfound += 1;
			}
		});
		chatHeartbeatCount++;

		if (itemsfound > 0) {
			chatHeartbeatTime = minChatHeartbeat;
			chatHeartbeatCount = 1;
		} else if (chatHeartbeatCount >= 10) {
			chatHeartbeatTime *= 2;
			chatHeartbeatCount = 1;
			if (chatHeartbeatTime > maxChatHeartbeat) {
				chatHeartbeatTime = maxChatHeartbeat;
			}
		}
		setTimeout('xim_chatHeartbeat();',chatHeartbeatTime);
	}});
}

function checkChatBoxInputKey(event,chatboxtextarea,chatboxID) {
	 
	if(event.keyCode == 13 && event.shiftKey == 0)  {
		message = xoops_im(chatboxtextarea).val();
		message = message.replace(/^\s+|\s+xoops_im/g,"");

		xoops_im(chatboxtextarea).val('');
		xoops_im(chatboxtextarea).focus();
		xoops_im(chatboxtextarea).css('height','44px');
		container =xoops_im("#MBchatbox_"+chatboxID);
		var elHeight= container.height()-container.find(".n:first").outerHeight()-(container.find(".s:first").outerHeight());
		container.find(".mbcontainercontent:first").css('height',elHeight-52 +'px');
		
		if (message != '') {
			xoops_im.post(xim_url+"chat.php?action=sendchat", {to: chatboxID, message: message} , function(data){

				message = data.message;
				xoops_im("#MBchatbox_"+chatboxID).find(".mbcontainercontent:first").append('<div class="chatboxmessage"><span class="ghost"></span><span class="chatAvatar"><img src="'+userAvatar+'" alt=""/></span><span class="chatboxmessagefrom">'+xim_username+':&nbsp;&nbsp;</span><span class="chatboxmessagecontent">'+message+'</span></div>');
				xoops_im("#MBchatbox_"+chatboxID+" .mbcontainercontent").scrollTop(xoops_im("#MBchatbox_"+chatboxID+" .mbcontainercontent")[0].scrollHeight);
			}, "json");
		}
		chatHeartbeatTime = minChatHeartbeat;
		chatHeartbeatCount = 1;

		return false;
	}
        var conteinerheight = xoops_im("#MBchatbox_"+chatboxID).find(".mbcontainercontent:first").height();
	var adjustedHeight = chatboxtextarea.clientHeight;
	var maxHeight = 94;

 	if (maxHeight > adjustedHeight) {	
 		xoops_im(chatboxtextarea).css('overflow','auto');
 	}
}

function xim_startChatSession(){  
  if (showFooterBar !== 0) {  
    xim_createFooterBar();
  }
	  if (showFooterBar==1) {
		setTimeout('xim_updateUserList()',200);
	  }
	xoops_im.ajax({
	  url: xim_url+"chat.php?action=startchatsession",
	  cache: false,
	  dataType: "json",
	  success: function(data) {
		userSound = data.q;
		xim_username = data.username;
		userAvatar = data.avatar; 
		xoops_im.each(data.items, function(i,item){
			if (item)	{ // fix strange ie bug
				chatboxID = item.f;
				if (xoops_im("#MBchatbox_"+chatboxID).length <= 0) {
					if (item.s <= 1) {
					xim_createChatBox(chatboxID,item.n,item.a);
					}
				}
				if (item.s == 1) {
					item.f = xim_username;
				}
				if (item.s == 2) {
					xoops_im("#MBchatbox_"+chatboxID).find(".mbcontainercontent:first").append('<div class="chatboxmessage"><span class="chatboxinfo">'+item.m+'</span></div>');
				} else {
					xoops_im("#MBchatbox_"+chatboxID).find(".mbcontainercontent:first").append('<div class="chatboxmessage"><span class="ghost"></span><span class="chatAvatar"><img src="'+item.a+'" alt=""/></span><span class="chatboxmessagefrom">'+item.n+':&nbsp;&nbsp;</span><span class="chatboxmessagecontent">'+item.m+'</span></div>');
				}
			}
		});
		for (i=0;i<chatBoxes.length;i++) {
			chatboxID = chatBoxes[i];
			xoops_im("#MBchatbox_"+chatboxID+" .mbcontainercontent").scrollTop(xoops_im("#MBchatbox_"+chatboxID+" .mbcontainercontent")[0].scrollHeight);
			setTimeout('xoops_im("#MBchatbox_"+chatboxID+" .mbcontainercontent").scrollTop(xoops_im("#MBchatbox_"+chatboxID+" .mbcontainercontent")[0].scrollHeight);', 100); // yet another strange ie bug
		}
    xim_reSetConf();
	setTimeout('xim_chatHeartbeat();',chatHeartbeatTime);		
	}});
	
}

function xim_createFooterBar() {
    xoops_im("<div />" ).attr("id","footpanel")
    .appendTo(xoops_im( "body" ));
    xoops_im("footpanel").show();
    xoops_im('#footpanel').load(xim_url+"footer_bar.php?style="+footerBarStyle , function() {  
	/* Credit: http://www.sohtanaka.com  */
	//Adjust panel height
	xoops_im.fn.adjustPanel = function(){ 
		xoops_im(this).find("ul, .subpanel").css({ 'height' : 'auto'}); //Reset subpanel and ul height
		
		var windowHeight = xoops_im(window).height(); //Get the height of the browser viewport
		var panelsub = xoops_im(this).find(".subpanel").height(); //Get the height of subpanel	
		var panelAdjust = windowHeight - 100; //Viewport height - 100px (Sets max height of subpanel)
		var ulAdjust =  panelAdjust - 25; //Calculate ul size after adjusting sub-panel (27px is the height of the base panel)
		
		if ( panelsub >= panelAdjust ) {	 //If subpanel is taller than max height...
			xoops_im(this).find(".subpanel").css({ 'height' : panelAdjust }); //Adjust subpanel to max height
			xoops_im(this).find("ul").css({ 'height' : ulAdjust}); //Adjust subpanel ul to new size
		}
		else if ( panelsub < panelAdjust ) { //If subpanel is smaller than max height...
			xoops_im(this).find("ul").css({ 'height' : 'auto'}); //Set subpanel ul to auto (default size)
		}
	};
	
	//Execute function on load
	xoops_im("#chatpanel").adjustPanel(); //Run the adjustPanel function on #chatpanel
	xoops_im("#alertpanel").adjustPanel(); //Run the adjustPanel function on #alertpanel
	
	//Each time the viewport is adjusted/resized, execute the function
	xoops_im(window).resize(function () { 
		xoops_im("#chatpanel").adjustPanel();
		xoops_im("#alertpanel").adjustPanel();
	});
	
	//Click event on Chat Panel + Alert Panel	
	xoops_im("#chatpanel a:first, #alertpanel a:first").click(function() { //If clicked on the first link of #chatpanel and #alertpanel...
		if(xoops_im(this).next(".subpanel").is(':visible')){ //If subpanel is already active...
			xoops_im(this).next(".subpanel").hide(); //Hide active subpanel
			xoops_im("#footpanel li a").removeClass('active'); //Remove active class on the subpanel trigger
		}
		else { //if subpanel is not active...
			xoops_im(".subpanel").hide(); //Hide all subpanels
			xoops_im(this).next(".subpanel").toggle(); //Toggle the subpanel to make active
			xoops_im("#footpanel li a").removeClass('active'); //Remove active class on all subpanel trigger
			xoops_im(this).toggleClass('active'); //Toggle the active class on the subpanel trigger
		}
		return false; //Prevent browser jump to link anchor
	});
	
	//Click event outside of subpanel
	xoops_im(document).click(function() { //Click anywhere and...
		xoops_im(".subpanel").hide(); //hide subpanel
		xoops_im("#footpanel li a").removeClass('active'); //remove active class on subpanel trigger
	});
	xoops_im('.subpanel ul').click(function(e) { 
		e.stopPropagation(); //Prevents the subpanel ul from closing on click
	});
	
	//Config Panel
	xoops_im(".xim_configDiv_bodyf").hide();
	xoops_im(".xim_img_infof").click(function() {
	xim_reSetConf();
	      xoops_im(".xim_configDiv_bodyf").slideToggle(2500);
	      return false;
	});
	xoops_im(".xim_configDiv_bodyf").click(function() {
	      return false;
	});
	xoops_im(".update_buttonf").click(function() {
		var soundf = xoops_im("#soundf").val();
		var statusf = xoops_im("#statusf").val();
		var dataStringf = xoops_im("#configf").serialize();
		//var dataString = 'soundf='+ soundf + '&statusf=' + statusf;
		if(statusf=='' || soundf=='') {
			alert('Please Give Valid Details');
		} else {
			xoops_im("#flashf").show();
			xoops_im("#flashf").fadeIn(800).html('<img src="'+xim_url+'/images/ajaxloader.gif" alt=""/>Saved!');
			xoops_im.ajax({
			type: "POST",
			url: xim_url+"include/update_config.php",
			data: dataStringf,
			cache: false,
			success: function(html){
			xoops_im("#flashf").hide(2000);
			xoops_im(".xim_configDiv_bodyf").hide(6000);
		}
		});
		}return false;
	});
	//Delete icons on Alert Panel
	xoops_im("#alertpanel li").hover(function() {
		xoops_im(this).find("a.delete").css({'visibility': 'visible'}); //Show delete icon on hover
	},function() {
		xoops_im(this).find("a.delete").css({'visibility': 'hidden'}); //Hide delete icon on hover out
	});            
    });  
}

function xim_updateUserList() {
	xoops_im.ajax({
	  url: xim_url+"ajax_userlist.php",
	  cache: false,
	  dataType: "json",
	  success: function(data) {
		xoops_im("#total").html(data.total);
		xoops_im("#userlist").html('');
		xoops_im.each(data.users, function(i,user){
			if (user){ 
			    switch (user.status) {
				case 0: userstatus=xim_url+"images/Absent-blue16.png"; 
				break;
				case 1: userstatus=xim_url+"images/busy-blue16.png"; 
				break;
				case 2: userstatus=xim_url+"images/messenger-blue16.png"; 
				break;
			    }
				// fix strange ie bug  	<li><span>Family Members</span></li>
				xoops_im("#userlist").append('<li><a href="javascript:void(0)" onclick="javascript:xim_chatWith(\''+user.id+'\',\''+user.n+'\');" title=""><img class="image" src="'+user.a+'" alt="">'+user.n+'<img class="status" src="'+userstatus+'" alt=""></a></li>');
			}
		});
	}});
	setTimeout('xim_updateUserList();',10000);
}

// Strip html from string and return oly text
function xim_stripHTML(oldString) {
   var newString = "";
   var inTag = false;
   for(var i = 0; i < oldString.length; i++) {
        if(oldString.charAt(i) == '<') inTag = true;
        if(oldString.charAt(i) == '>') {
           if(oldString.charAt(i+1)=="<")
           {
		//dont do anything
	   }	else	{
		inTag = false;
		i++;
	    }
	}
        if(!inTag) newString += oldString.charAt(i);
   }
   return newString;
}


function xim_getAvatar(uid){
	xoops_im.ajax({
	  url: xim_url+"chat.php?action=avatar",
	  cache: false,
	  data: "uid="+uid,
	  dataType: "json",
	  success: function(data) {
		return data.a;		   
   }
 });
};

function xim_keepDivs (divname,divname2,height, id) {
			// Added these repetative lines to prevent textarea popping out main div in IE (culex)
			// usage for instance xim_keepDivs (".chatboxtextarea",".mbcontainercontent:first","44px", containerId);
			xoops_im(divname).val('');
			xoops_im(divname).focus();
			xoops_im(divname).css('height',height);
			container =xoops_im("#MBchatbox_"+id);
			var elHeight= container.height()-container.find(".n:first").outerHeight()-(container.find(".s:first").outerHeight());
			container.find(divname2).css('height',elHeight-52 +'px');
			// Keeping the container fixed in position when scrolling
			xoops_im("#MBchatbox_"+id).css("position","fixed");
			xoops_im("#MBchatbox_"+id+" "+divname2).scrollTop(xoops_im("#MBchatbox_"+id+" "+divname2)[0].scrollHeight);
}

	// Function to bounce box or iconized when recieving new message
	// Id = id of box
	// state: 0=iconized or 1=opened
	// name: name to check for in conttitle atribute for img
	// culex dec 28-2010
function xim_doBounce (chatboxID,state,name) {
	//If opened window
	if (state==1) {
	xoops_im(function() {
	  // shake window 
	  xoops_im("#MBchatbox_"+chatboxID).fadeIn(100).animate({top:"-=20px"},100).animate({top:"+=20px"},100).animate({top:"-=20px"},100)
	  .animate({top:"+=20px"},100).animate({top:"-=20px"},100).animate({top:"+=20px"},100);
	  return;
	});
	}
	// if iconized
	if (state==0) {
		xoops_im(function() {
			xoops_im("img:[conttitle]").each(function() {
				if(xoops_im(this).attr("conttitle") == un) { 
					// max loops is 1000. Click icon to stop before
					var x = 0;
					do {
						xoops_im(this).animate({top: "0px"}, 2000 ).fadeOut(200).fadeIn(200).fadeOut(200).fadeIn(200).fadeOut(200).fadeIn(200).fadeOut(200).fadeIn(200);
							x++;
							if (xoops_im(this).click(function(){
								x = 1000;
								xoops_im(this).stop().show();
								return;
							}));
					} while (x <= 1000);
				} else {return;}
			});
		});
	} 
}

// Function to keep container in window view when scrolling
function xim_keepInWindow (containerId) {
		var scrollingDiv = xoops_im("#MBchatbox_"+containerId);
 		xoops_im(window).scroll(function(){			
			scrollingDiv
				.stop()
				.animate({"marginTop": (xoops_im(window).scrollTop() + 30) + "px"}, "slow" );	
		});
}

// Function to reset sound & Status select:Selected in forms after send and in pagerefresh
function xim_reSetConf() {
	var data;
    var xim_RandNumGenerate = Math.floor(Math.random()*101);
	xoops_im.ajax({
	  url: xim_url+"getmystats.php?chk="+xim_RandNumGenerate,
	  cache: false,
	  dataType: "json",
	  success: function(data) {
		xoops_im("select[name=sound] option[value="+data.uso+"]").attr("selected", true);
		xoops_im("select[name=status] option[value="+data.uss+"]").attr("selected", true);
		xoops_im("select[name=soundf] option[value="+data.uso+"]").attr("selected", true);
		xoops_im("select[name=statusf] option[value="+data.uss+"]").attr("selected", true);
      }
	});
	return;
}
