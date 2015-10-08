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

 
// English language file for xim Admin.php

// tab titles
	define('_AM_XIM_ADMINMESSAGESEND','Post to all'); 
	define('_AM_XIM_LOGSMAINTNANCE','Database maintenance'); 

// tab one in admin section
define('_AM_XIM_MODULEINSTALL','Module version installed');
define('_AM_XIM_INSTALLDATE','Module installed on');
define('_AM_XIM_DATEOFFIRSTMESSAGE','Date of the oldest message');
define('_AM_XIM_TOTALUSERS','Total members using Xim');
define('_AM_XIM_AVERAGEMSGPERDAY','Average messages per day');
define('_AM_XIM_TOPCHATTERS','Most active chatters overall');
define('_AM_XIM_TOPCHATTERS_TODAY','Most active users in last 24 hours');
define('_AM_XIM_STATISTICS_TITLE','XIM Statistics'); 
define('_AM_XIM_MODULEINFO','Module info'); 
define('_AM_XIM_USERSTATS','User stats');
define('_AM_XIM_NONEYET','No messages in database');
define('_AM_XIM_NO','no');
define('_AM_XIM_THEREARE','There are');
define('_AM_XIM_UPDATE_STATUS','Status of your XIM version:');

// tab two in admin section
define('_AM_XIM_ADMINMESSAGE','Admin message');
define('_AM_XIM_MESSAGES','messages');
define('_AM_XIM_SUBMIT','Send!');
define('_AM_XIM_LASTADMINMESSAGE_TITLE','Last Admin message');
define('_AM_XIM_LASTADMINMESSAGE_MSG','Message');
define('_AM_XIM_LASTADMINMESSAGE_DATE','Date sent');
define('_AM_XIM_LASTADMINMESSAGE_WASREAD','Last admin message is read by ');
define('_AM_XIM_LASTADMINMESSAGE_USERS','users');
define('_AM_XIM_NOADMINMESSAGEYET','You haven\'t sent any admin message to all users yet ;-) ');
define('_AM_XIM_NOADMINMESSAGEYET_DATE','Duh!!');

// tab three in admin section
define('_AM_XIM_LOGS_TITLE','Logs Information');
define('_AM_XIM_DBHAS','Database has ');
define('_AM_XIM_DBHASPOSTS',' messages in total');
define('_AM_XIM_DBHASOLDPOSTS',' messages older than 1 week');
define('_AM_XIM_LOGSCLEAN','Clean old logs');
define('_AM_XIM_LOGSCLEANDESC','Choose here wich logs you\'d like to clean');
define('_AM_XIM_LOGS_CHOOSE','Choose action for messages');
define('_AM_XIM_LOGS_USER_MOW_RECD','Delete User posts older than 1 week (recieved)');
define('_AM_XIM_LOGS_USER_MOW_ALL','Delete User posts older than 1 week (ALL)');
define('_AM_XIM_LOGS_USER_MTW_RECD','Delete User posts older than 2 weeks (recieved)');
define('_AM_XIM_LOGS_USER_MTW_ALL','Delete User posts older than 2 weeks (ALL)');
define('_AM_XIM_LOGS_USER_MOM_RECD','Delete User posts older than 1 month (recieved)');
define('_AM_XIM_LOGS_USER_MOM_ALL','Delete User posts older than 1 month (ALL)');
define('_AM_XIM_LOGS_ADMIN_MOW_RECD','Delete Admin posts older than 1 week (recieved)');
define('_AM_XIM_LOGS_ADMIN_MOW_ALL','Delete Admin posts older than 1 week (ALL)');
define('_AM_XIM_LOGS_ADMIN_MTW_RECD','Delete Admin posts older than 2 weeks (recieved)');
define('_AM_XIM_LOGS_ADMIN_MTW_ALL','Delete Admin posts older than 2 weeks (ALL)');
define('_AM_XIM_LOGS_ADMIN_MOM_RECD','Delete Admin posts older than 1 month (recieved)');
define('_AM_XIM_LOGS_ADMIN_MOM_ALL','Delete Admin posts older than 1 month (ALL)');
define('_AM_XIM_LOGS_ADMIN_MSG_ALL_RECD','Delete ALL admin posts that have been recieved.');
define('_AM_XIM_LOGS_SUBMIT','Send');
define('_AM_XIM_LOGS_DOUPDATE','Message maintnance drop down!');

// various others
define('_AM_XIM_UPDATE_CRITICAL_UPD','There is a critical update ready!!');
define('_AM_XIM_UPDATE_NORMAL_UPD','There is a newer version ready for download');
define('_AM_XIM_UPDATE_SERVER_ERROR','Server seems to be down or update is in progress.<br/>Try again later.');
define('_AM_XIM_UPDATE_FILE_DESC','Description of newest version');
define('_AM_XIM_UPDATE_SERVER_FILE','You can download the new version from here');
define('_AM_XIM_UPDATE_YOUHAVENEWESTVERSION','You have the newest version of Xim');
define('_AM_XIM_HELP','Help');

// Send to all
define('_AM_XIM_POSTTOALL_TITLE','Send your message');
define('_AM_XIM_POSTTOALL_DESC','Send message to everyone who uses XIM');
define('_AM_XIM_POSTTOALL_COUNT','Message (Characters: ');
define('_AM_XIM_POSTTOALL_SUBMIT','Send');


//Help section
define('_AM_XIM_HELP_ABOUT','About Xim');
define('_AM_XIM_HELP_PREFACE','Xim is a Messenger system. Inspired by the jQuery Gmail/Facebook chat example written by Anant Garg and the Gmail/Facebook Messenger. The base system has been re-written, adapted, and heavily expanded for XOOPS by Culex & Andrax.<br/>The chat is one-on-one and fully supported by XOOPS version 2.4.0 and higher.<br/>XIM is released under the terms of the <a href="http://www.gnu.org/copyleft/gpl.html" target="_blank">GNU General Public License (GPL)</a> and is free to use and modify. It is free to redistribute as long as you abide by the distribution terms of the GPL.');
define('_AM_XIM_HELP_HEADER_REQUIREMENTS','Requirements');
define('_AM_XIM_HELP_REQUIREMENTS','<ul class="help">
										<li>WWW Server (<a href="http://www.apache.org/" target="_blank">Apache</a>, IIS, Roxen, etc)</li>
										<li><a href="http://www.xoops.org/" target="_blank">XOOPS</a> 2.4.0 or higher as xim uses preloads</li>
										<li><a href="http://www.php.net/" target="_blank">PHP</a> 4.3.0 or higher (5.2 or higher recommended)</li>
										<li><a href="http://www.mysql.com/" target="_blank">MySQL</a> 3.23 or higher (4.1 or higher recommended)</li>
									</ul>');
define('_AM_XIM_HELP_HEADER_RECOMMENDED','Recommended for testing XIM');
define('_AM_XIM_HELP_RECOMMENDED','<ul class="help">
									<li>Browser <a href="http://www.mozilla.com" target"_blank">Firefox</a> and the Firefox plugin <a href="https://addons.mozilla.org/en-US/firefox/downloads/latest/1843/addon-1843-latest.xpi" target="_blank">FireBug plugin (latest version)</a></li> 
								  </ul>');
define('_AM_XIM_HELP_HEADER_INSTALLATION','How to install');
define('_AM_XIM_HELP_FIRSTTIMEINSTALL','<ul class="help">
											<li>Check to see if the downloaded xim version is the latest released version.</li>
											<li>Turn cookie and JavaScript of your browser on.</li>
										</ul>');
										
define('_AM_XIM_HELP_HEADER_HOSTED_PLATFORM','Installing on a hosted platform');
define('_AM_XIM_HELP_HOSTED_PLATFORM','<ul class="help">
										<li>Upload the unzipped folder xim to your module directory.</li>
										<li>Install using XOOPS module install as any other module installation.</li>
										<li>Make the block visible for the user groups you want to see the block (admin/moderators etc etc).</li>
									</ul>');
define('_AM_XIM_HELP_HEADER_UPGRADING','Upgrading from a previous version');
define('_AM_XIM_HELP_UPGRADING','<ul class="help">
									<li>Make sure you are using newest version</li>
									<li>Read the readme.txt in archieve</li>
									<li>Maybe do a backup of your tables</li>
								</ul>');
define('_AM_XIM_HELP_HEADER_FAQ','Problem solving');
define('_AM_XIM_HELP_HEADER_COMMENPROBLEMS1','I get blank page, can\'t click username, The block does not show.......');
define('_AM_XIM_HELP_COMMENPROBLEMS1','<ul class="help">
										<li>Make sure your block is visible on "All pages" and not only frontpage.</li>
										<li>Make sure your Xoops version is > 2.4.0. Older versions of Xoops don\'t have preloads, which are required.</li>
										<li>Turn on debug and check to see if any errors emerge.</li>
										<li>Using FireFox, right click on the screen, choose inspect element, choose console in the tabs and check to see if chat heartbeat is running<br/>
										"GET http://www.yoursite.com/modules/xim/chat.php?action=chatheartbeat&_=XXXXXXXXXXXX xxx OK xxx MS"</li>
										<li>If no errors, use Firebug (Right click->inspect element->console) and see if there are any jQuery errors.</li>
										<li>If there are no jQuery errors. Clean caches-> module update xim, system modules.</li>
										<li>If the page is still blank, Go to your protector module -> settings and write xim in the form "Modules out of Dos / Crawler checker".</li>
										<li>Check if your theme is including more than one version of jQuery. Usually in the head of your theme.html file.<br/>
										Normally this is no problem as long as the other including jQuery > 1.3.2</li>
									</ul>');
define('_AM_XIM_HELP_HEADER_SOUNDPROBLEMS','I selected message sound but I get no audio');
define('_AM_XIM_HELP_SOUNDPROBLEMS','<ul class="help">
										<li>Check to see if your speakers are turned on and your volume is turned up</li>
										<li>XIM sound uses the framework soundmanager2. This uses a small utility in flash to play sounds. If you support Flash in your browser it should work</li>
									</ul>');
define('_AM_XIM_HELP_HEADER_CONTACTS','Ask question');
define('_AM_XIM_HELP_OTHERHELP','<ul class="help">
									<li>If still questions or errors please post at the <a href="http://www.xoops.org/modules/newbb" target="_blank">Xoops support Forum</a></li>
								</ul>');
?>
