var refreshId = setInterval(function() {
im('#online_friends').load(xim_url+'/blocks/blockupdater_default.php');
}, 5000);