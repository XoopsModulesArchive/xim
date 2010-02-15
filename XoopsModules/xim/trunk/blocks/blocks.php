 <?php
 
/*********************************************************************
    Author: Andrax
    URL: http://guxbrasil.ning.com
    E-Mail: lcbc@ig.com.br
**********************************************************************/
 
 include(XOOPS_ROOT_PATH."/modules/xim/include/functions.php");


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
                 $block['amigos'][] = array('id'=> $onlines[$i]['online_uid'], 'nome' => $onlines[$i]['online_uname']);
             }
         }
         return $block;
     } else {
         return false;
     }
 }
 
 
?>
