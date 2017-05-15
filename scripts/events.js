$(function() {
	init_videos();
	init_teachers();
	init_addresses();
	init_gallery();
	init_header();
	init_reviews();
	init_register();
	init_camp();
});

$( window ).on('load', function() {
	resize_videos();
	resize_teachers();
	resize_addresses();
	resize_gallery();
	resize_header();	
	resize_reviews();	
	resize_camp();

});

$( window ).resize(function() {
	resize_videos();
	resize_teachers();
	resize_addresses();
	resize_gallery();
	resize_header();	
	resize_reviews();	
	resize_camp();
});
