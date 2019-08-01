$(document).ready(function(){
	
	//二级导航的
    $('.sidelist').mousemove(function(){
	$(this).find('.i-list').show();
	$(this).find('h3').addClass('help_hover');
	});
	$('.sidelist').mouseleave(function(){
	$(this).find('.i-list').hide();
	$(this).find('h3').removeClass('help_hover');
	});
	
	
	
});