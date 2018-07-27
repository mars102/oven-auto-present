var top_show=150;var delay=1000;

$(document).ready(function(){
	var area = $(".company-area").offset();
		

	var offset = $('.company-border').offset();
    var topPadding = $('.company-border').height();

	$(window).scroll(function(){
		if($(this).scrollTop()>top_show)
			$('#top').fadeIn();
		else $('#top').fadeOut();



		
    	if(typeof(area) != "undefined" && area !== null) {
    		var areabottom = area.top+$(".company-area").height();
    		if($(window).scrollTop() > areabottom-$('.company-border').height()-230){
    			//alert(1);
	        	$('.company-border').stop().animate({marginTop: 0 });
	        }
	        else if ($(window).scrollTop() > offset.top-$('.company-border').height()) {
	            $('.company-border').stop().animate({marginTop: $(window).scrollTop() - offset.top + topPadding+50});
	        }
	        
	        else {
	            $('.company-border').stop().animate({marginTop: 0});
	        }

	        //console.log("СКРОЛЛЕР="+$(window).scrollTop()+" AREABOTTOM="+areabottom);
	    }
	});

	$('#top').click(function(){
		$('body, html').animate({scrollTop:0},delay);
	});
});