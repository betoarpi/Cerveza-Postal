$(function(){
	//Navigation Effect
	function showNav (){
    	$('.main-nav').toggleClass('hidden-xs');
	}

	$('.mobile-menu').on('click', showNav);

	$('.mobile-menu').on('click', function(){
		event.preventDefault()
	});
});