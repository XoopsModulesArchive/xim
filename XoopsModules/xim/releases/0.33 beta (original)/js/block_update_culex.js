var refreshId = setInterval(function() {
xoops_im('#online_friends').load(xim_url+'blocks/blockupdater.php');
}, 5000);