var refreshId = setInterval(function() {
im('#online_friends').load(xim_url+'/blocks/blockupdater.php');
}, 5000);