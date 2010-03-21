 <?php
 
/*********************************************************************
    Author: Andrax
    URL: http://guxbrasil.ning.com
    E-Mail: lcbc@ig.com.br
**********************************************************************/
 
 require_once (XOOPS_ROOT_PATH."/modules/xim/include/functions.php");


 function amigos() {
     global $xoopsUser, $xoopsModule;
     $online_handler =& xoops_gethandler('online');
     mt_srand((double)microtime()*1000000);
     // set gc probabillity to 10% for now..
     if (mt_rand(1, 100) < 11) {
         $online_handler->gc(300);
     }
     if (is_object($xoopsUser)) {
         $uid = $xoopsUser->getVar('uid');
         $uname = $xoopsUser->getVar('uname');
     } else {
         return false;
     }
     $online_handler->write($uid, $uname, time(), 0, $_SERVER['REMOTE_ADDR']);
     
     $onlines = $online_handler->getAll();
     if (false != $onlines) {
         $total = count($onlines);
         $block = array();
         for ($i = 0; $i < $total; $i++) {
             if (($onlines[$i]['online_uid'] > 0) && ($onlines[$i]['online_uid']!=$uid)) {
              $config = im_Getconfig($onlines[$i]['online_uname']);
				 $status = $config['status'];
				if($style == 0) {
					 if ($status == '0') {$image = XOOPS_URL."/modules/xim/images/Absent-blue16.png";}
					 if ($status == '1') {$image = XOOPS_URL."/modules/xim/images/busy-blue16.png";}
					 if ($status == '2') {$image = XOOPS_URL."/modules/xim/images/messenger-blue16.png";}
				} else {
					 if ($status == '0') {$image = XOOPS_URL."/modules/xim/images/na.png";}
					 if ($status == '1') {$image = XOOPS_URL."/modules/xim/images/busy.png";}
					 if ($status == '2') {$image = XOOPS_URL."/modules/xim/images/online.png";}
				  }
				 $block['amigos'][] = array('id'=> $onlines[$i]['online_uid'], 'nome' => $onlines[$i]['online_uname'], 'status' => $image);	
				// print_r($block);
	   
	// Config form for personal config.
	// $cf assigned to $block['config'], controlled by /js/configdiv.js & js/configscript.js
	// Using ajax to call /include/update_config.php wich serialize $_POST to sql.
	 $cf = "<form method='post' id='config' action=''>"._MB_XIM_USESOUND."
		<select name='sound'>
		 <option value='0'>"._MB_XIM_NOSOUND."</option>
		 <option value='1'>"._MB_XIM_SOUND1."</option>
		 <option value='2'>"._MB_XIM_SOUND2."</option>
		 <option value='3'>"._MB_XIM_SOUND3."</option>
		 <option value='4'>"._MB_XIM_SOUND4."</option>
		 <option value='5'>"._MB_XIM_SOUND5."</option>
		 <option value='6'>"._MB_XIM_SOUND6."</option>
		 <option value='7'>"._MB_XIM_SOUND7."</option>
		 <option value='8'>"._MB_XIM_SOUND8."</option>
		 <option value='9'>"._MB_XIM_SOUND9."</option>
		 <option value='10'>"._MB_XIM_SOUND10."</option></select><br /><br />
		 "._MB_XIM_STATUS."
		<select name='status'>
		 <option value='0'>"._MB_XIM_HIDDEN."</option>
		 <option value='1'>"._MB_XIM_BUSY."</option>
		 <option value='2'>"._MB_XIM_ONLINE."</option></select><br /><br /><center>
	  <input type='submit' value='"._MB_XIM_UPDATE."' name='submit' class='update_button'/></center></select>
	 </form>
		</span><div id='flash'></div>";  
	   
	  $block['config'] = $cf;
	 }
         }
         return $block;
     } else {
         return false;
     }
 }
 
 
?>
