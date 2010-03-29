/* Credit: http://www.sohtanaka.com  */

im(document).ready(function(){

	//Adjust panel height
	im.fn.adjustPanel = function(){ 
		im(this).find("ul, .subpanel").css({ 'height' : 'auto'}); //Reset subpanel and ul height
		
		var windowHeight = im(window).height(); //Get the height of the browser viewport
		var panelsub = im(this).find(".subpanel").height(); //Get the height of subpanel	
		var panelAdjust = windowHeight - 100; //Viewport height - 100px (Sets max height of subpanel)
		var ulAdjust =  panelAdjust - 25; //Calculate ul size after adjusting sub-panel (27px is the height of the base panel)
		
		if ( panelsub >= panelAdjust ) {	 //If subpanel is taller than max height...
			im(this).find(".subpanel").css({ 'height' : panelAdjust }); //Adjust subpanel to max height
			im(this).find("ul").css({ 'height' : ulAdjust}); //Adjust subpanel ul to new size
		}
		else if ( panelsub < panelAdjust ) { //If subpanel is smaller than max height...
			im(this).find("ul").css({ 'height' : 'auto'}); //Set subpanel ul to auto (default size)
		}
	};
	
	//Execute function on load
	im("#chatpanel").adjustPanel(); //Run the adjustPanel function on #chatpanel
	im("#alertpanel").adjustPanel(); //Run the adjustPanel function on #alertpanel
	
	//Each time the viewport is adjusted/resized, execute the function
	im(window).resize(function () { 
		im("#chatpanel").adjustPanel();
		im("#alertpanel").adjustPanel();
	});
	
	//Click event on Chat Panel + Alert Panel	
	im("#chatpanel a:first, #alertpanel a:first").click(function() { //If clicked on the first link of #chatpanel and #alertpanel...
		if(im(this).next(".subpanel").is(':visible')){ //If subpanel is already active...
			im(this).next(".subpanel").hide(); //Hide active subpanel
			im("#footpanel li a").removeClass('active'); //Remove active class on the subpanel trigger
		}
		else { //if subpanel is not active...
			im(".subpanel").hide(); //Hide all subpanels
			im(this).next(".subpanel").toggle(); //Toggle the subpanel to make active
			im("#footpanel li a").removeClass('active'); //Remove active class on all subpanel trigger
			im(this).toggleClass('active'); //Toggle the active class on the subpanel trigger
		}
		return false; //Prevent browser jump to link anchor
	});
	
	//Click event outside of subpanel
	im(document).click(function() { //Click anywhere and...
		im(".subpanel").hide(); //hide subpanel
		im("#footpanel li a").removeClass('active'); //remove active class on subpanel trigger
	});
	im('.subpanel ul').click(function(e) { 
		e.stopPropagation(); //Prevents the subpanel ul from closing on click
	});
	
	//Delete icons on Alert Panel
	im("#alertpanel li").hover(function() {
		im(this).find("a.delete").css({'visibility': 'visible'}); //Show delete icon on hover
	},function() {
		im(this).find("a.delete").css({'visibility': 'hidden'}); //Hide delete icon on hover out
	});
	
});