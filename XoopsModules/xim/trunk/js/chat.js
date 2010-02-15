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
var username;
var chatHeartbeatCount = 0;
var minChatHeartbeat = 1000;
var maxChatHeartbeat = 33000;
var chatHeartbeatTime = minChatHeartbeat;
var originalTitle;
var blinkOrder = 0;

var chatboxFocus = new Array();
var newMessages = new Array();
var newMessagesWin = new Array();
var newMessagesUser = new Array();
var chatBoxes = new Array();

im(document).ready(function(){
	originalTitle = document.title;
	startChatSession();

	im([window, document]).blur(function(){
		windowFocus = false;
	}).focus(function(){
		windowFocus = true;
		document.title = originalTitle;
	});
});

function restructureChatBoxes() {
	align = 0;
	for (x in chatBoxes) {
		chatboxID = chatBoxes[x];

		if (im("#chatbox_"+chatboxID).css('display') != 'none') {
			if (align == 0) {
				im("#chatbox_"+chatboxID).css('right', '20px');
			} else {
				width = (align)*(225+7)+20;
				im("#chatbox_"+chatboxID).css('right', width+'px');
			}
			align++;
		}
	}
}

function chatWith(chatuser, chatusername) {
	createChatBox(chatuser, chatusername);
	im("#chatbox_"+chatuser+" .chatboxtextarea").focus();
}

function createChatBox(chatboxID,chatboxname,minimizeChatBox) {
	if (im("#chatbox_"+chatboxID).length > 0) {
		if (im("#chatbox_"+chatboxID).css('display') == 'none') {
			im("#chatbox_"+chatboxID).css('display','block');
			restructureChatBoxes();
		}
		im("#chatbox_"+chatboxID+" .chatboxtextarea").focus();
		return;
	}

	im(" <div />" ).attr("id","chatbox_"+chatboxID)
	.addClass("chatbox")
	.html('<div class="chatboxhead"><div class="chatboxtitle">'+chatboxname+'</div><div class="chatboxoptions"><a href="javascript:void(0)" onclick="javascript:toggleChatBoxGrowth(\''+chatboxID+'\')">-</a> <a href="javascript:void(0)" onclick="javascript:closeChatBox(\''+chatboxID+'\')">X</a></div><br clear="all"/></div><div class="chatboxcontent"></div><div class="chatboxinput"><textarea class="chatboxtextarea" onkeydown="javascript:return checkChatBoxInputKey(event,this,\''+chatboxID+'\');"></textarea></div>')
	.appendTo(im( "body" ));
			   
	im("#chatbox_"+chatboxID).css('bottom', '30px');
	
	chatBoxeslength = 0;

	for (x in chatBoxes) {
		if (im("#chatbox_"+chatBoxes[x]).css('display') != 'none') {
			chatBoxeslength++;
		}
	}

	if (chatBoxeslength == 0) {
		im("#chatbox_"+chatboxID).css('right', '20px');
	} else {
		width = (chatBoxeslength)*(225+7)+20;
		im("#chatbox_"+chatboxID).css('right', width+'px');
	}
	
	chatBoxes.push(chatboxID);

	if (minimizeChatBox == 1) {
		minimizedChatBoxes = new Array();

		if (im.cookie('chatbox_minimized')) {
			minimizedChatBoxes = im.cookie('chatbox_minimized').split(/\|/);
		}
		minimize = 0;
		for (j=0;j<minimizedChatBoxes.length;j++) {
			if (minimizedChatBoxes[j] == chatboxID) {
				minimize = 1;
			}
		}

		if (minimize == 1) {
			im('#chatbox_'+chatboxID+' .chatboxcontent').css('display','none');
			im('#chatbox_'+chatboxID+' .chatboxinput').css('display','none');
		}
	}

	chatboxFocus[chatboxID] = false;

	im("#chatbox_"+chatboxID+" .chatboxtextarea").blur(function(){
		chatboxFocus[chatboxID] = false;
		im("#chatbox_"+chatboxID+" .chatboxtextarea").removeClass('chatboxtextareaselected');
	}).focus(function(){
		chatboxFocus[chatboxID] = true;
		newMessages[chatboxID] = false;
		im('#chatbox_'+chatboxID+' .chatboxhead').removeClass('chatboxblink');
		im("#chatbox_"+chatboxID+" .chatboxtextarea").addClass('chatboxtextareaselected');
	});

	im("#chatbox_"+chatboxID).click(function() {
		if (im('#chatbox_'+chatboxID+' .chatboxcontent').css('display') != 'none') {
			im("#chatbox_"+chatboxID+" .chatboxtextarea").focus();
		}
	});

	im("#chatbox_"+chatboxID).show();
}


function chatHeartbeat(){

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
				im('#chatbox_'+x+' .chatboxhead').toggleClass('chatboxblink');
			}
		}
	}
	
	im.ajax({
	  url: xim_url+"chat.php?action=chatheartbeat",
	  cache: false,
	  dataType: "json",
	  success: function(data) {

		im.each(data.items, function(i,item){
			if (item)	{ // fix strange ie bug

				chatboxID = item.f;

				if (im("#chatbox_"+chatboxID).length <= 0) {
					createChatBox(chatboxID,item.n);
				}
				if (im("#chatbox_"+chatboxID).css('display') == 'none') {
					im("#chatbox_"+chatboxID).css('display','block');
					restructureChatBoxes();
				}
				
				if (item.s == 1) {
					item.f = username;
				}

				if (item.s == 2) {
					im("#chatbox_"+chatboxID+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxinfo">'+item.m+'</span></div>');
				} else {
					newMessages[chatboxID] = true;
					newMessagesWin[chatboxID] = true;
					newMessagesUser[chatboxID]=item.n;
					im("#chatbox_"+chatboxID+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxmessagefrom">'+item.n+':&nbsp;&nbsp;</span><span class="chatboxmessagecontent">'+item.m+'</span></div>');
				}

				im("#chatbox_"+chatboxID+" .chatboxcontent").scrollTop(im("#chatbox_"+chatboxID+" .chatboxcontent")[0].scrollHeight);
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
		
		setTimeout('chatHeartbeat();',chatHeartbeatTime);
	}});
}

function closeChatBox(chatboxID) {
	im('#chatbox_'+chatboxID).css('display','none');
	restructureChatBoxes();

	im.post(xim_url+"chat.php?action=closechat", { chatbox: chatboxID} , function(data){	
	});

}

function toggleChatBoxGrowth(chatboxID) {
	if (im('#chatbox_'+chatboxID+' .chatboxcontent').css('display') == 'none') {  
		
		var minimizedChatBoxes = new Array();
		
		if (im.cookie('chatbox_minimized')) {
			minimizedChatBoxes = im.cookie('chatbox_minimized').split(/\|/);
		}

		var newCookie = '';

		for (i=0;i<minimizedChatBoxes.length;i++) {
			if (minimizedChatBoxes[i] != chatboxID) {
				newCookie += chatboxID+'|';
			}
		}

		newCookie = newCookie.slice(0, -1)


		im.cookie('chatbox_minimized', newCookie);
		im('#chatbox_'+chatboxID+' .chatboxcontent').css('display','block');
		im('#chatbox_'+chatboxID+' .chatboxinput').css('display','block');
		im("#chatbox_"+chatboxID+" .chatboxcontent").scrollTop(im("#chatbox_"+chatboxID+" .chatboxcontent")[0].scrollHeight);
	} else {
		
		var newCookie = chatboxID;

		if (im.cookie('chatbox_minimized')) {
			newCookie += '|'+im.cookie('chatbox_minimized');
		}


		im.cookie('chatbox_minimized',newCookie);
		im('#chatbox_'+chatboxID+' .chatboxcontent').css('display','none');
		im('#chatbox_'+chatboxID+' .chatboxinput').css('display','none');
	}
	
}

function checkChatBoxInputKey(event,chatboxtextarea,chatboxID) {
	 
	if(event.keyCode == 13 && event.shiftKey == 0)  {
		message = im(chatboxtextarea).val();
		message = message.replace(/^\s+|\s+im/g,"");

		im(chatboxtextarea).val('');
		im(chatboxtextarea).focus();
		im(chatboxtextarea).css('height','44px');
		if (message != '') {
			im.post(xim_url+"chat.php?action=sendchat", {to: chatboxID, message: message} , function(data){
				//message = message.replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/\"/g,"&quot;");
				message = data.message;
				im("#chatbox_"+chatboxID+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxmessagefrom">'+username+':&nbsp;&nbsp;</span><span class="chatboxmessagecontent">'+message+'</span></div>');
				im("#chatbox_"+chatboxID+" .chatboxcontent").scrollTop(im("#chatbox_"+chatboxID+" .chatboxcontent")[0].scrollHeight);
			}, "json");
		}
		chatHeartbeatTime = minChatHeartbeat;
		chatHeartbeatCount = 1;

		return false;
	}

	var adjustedHeight = chatboxtextarea.clientHeight;
	var maxHeight = 94;

	if (maxHeight > adjustedHeight) {
		adjustedHeight = Math.max(chatboxtextarea.scrollHeight, adjustedHeight);
		if (maxHeight)
			adjustedHeight = Math.min(maxHeight, adjustedHeight);
		if (adjustedHeight > chatboxtextarea.clientHeight)
			im(chatboxtextarea).css('height',adjustedHeight+8 +'px');
	} else {
		im(chatboxtextarea).css('overflow','auto');
	}
	 
}

function startChatSession(){  
	im.ajax({
	  url: xim_url+"chat.php?action=startchatsession",
	  cache: false,
	  dataType: "json",
	  success: function(data) {
 
		username = data.username;

		im.each(data.items, function(i,item){
			if (item)	{ // fix strange ie bug

				chatboxID = item.f;

				if (im("#chatbox_"+chatboxID).length <= 0) {
					createChatBox(chatboxID,item.n);
				}
				
				if (item.s == 1) {
					item.f = username;
				}

				if (item.s == 2) {
					im("#chatbox_"+chatboxID+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxinfo">'+item.m+'</span></div>');
				} else {
					im("#chatbox_"+chatboxID+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxmessagefrom">'+item.n+':&nbsp;&nbsp;</span><span class="chatboxmessagecontent">'+item.m+'</span></div>');
				}
			}
		});
		
		for (i=0;i<chatBoxes.length;i++) {
			chatboxID = chatBoxes[i];
			im("#chatbox_"+chatboxID+" .chatboxcontent").scrollTop(im("#chatbox_"+chatboxID+" .chatboxcontent")[0].scrollHeight);
			setTimeout('im("#chatbox_"+chatboxID+" .chatboxcontent").scrollTop(im("#chatbox_"+chatboxID+" .chatboxcontent")[0].scrollHeight);', 100); // yet another strange ie bug
		}
	
	setTimeout('chatHeartbeat();',chatHeartbeatTime);
		
	}});
}

/**
 * Cookie plugin
 *
 * Copyright (c) 2006 Klaus Hartl (stilbuero.de)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 */

jQuery.cookie = function(name, value, options) {
    if (typeof value != 'undefined') { // name and value given, set cookie
        options = options || {};
        if (value === null) {
            value = '';
            options.expires = -1;
        }
        var expires = '';
        if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
            var date;
            if (typeof options.expires == 'number') {
                date = new Date();
                date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
            } else {
                date = options.expires;
            }
            expires = '; expires=' + date.toUTCString(); // use expires attribute, max-age is not supported by IE
        }
        // CAUTION: Needed to parenthesize options.path and options.domain
        // in the following expressions, otherwise they evaluate to undefined
        // in the packed version for some reason...
        var path = options.path ? '; path=' + (options.path) : '';
        var domain = options.domain ? '; domain=' + (options.domain) : '';
        var secure = options.secure ? '; secure' : '';
        document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
    } else { // only name given, get cookie
        var cookieValue = null;
        if (document.cookie && document.cookie != '') {
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = jQuery.trim(cookies[i]);
                // Does this cookie string begin with the name we want?
                if (cookie.substring(0, name.length + 1) == (name + '=')) {
                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                    break;
                }
            }
        }
        return cookieValue;
    }
};
