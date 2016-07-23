$(document).ready(function(){

/* Revolution Slider */
$('.tp-banner').not('.full-width-revolution').revolution({
	delay:5000,
	startwidth:1170,
	startheight:500,
	hideThumbs:10,
    navigationType:"both",					//bullet, thumb, none, both	 (No Shadow in Fullwidth Version !)
    navigationArrows:"verticalcentered",		//nexttobullets, verticalcentered, none
    navigationStyle:"round",

});

/* Revolution Slider Fullwidth */
$('.tp-banner.full-width-revolution').revolution({
	delay:5000,
	startwidth:1170,
	startheight:500,
	hideThumbs:10,
	navigationType:"none",
	fullWidth:"on",
	forceFullWidth:"on"
});



});