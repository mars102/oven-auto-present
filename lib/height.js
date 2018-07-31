function setEqualHeight(columns){
	var tallestcolumn=0;
	columns.each(function(){
		currentHeight=$(this).height();
		if(currentHeight>tallestcolumn){
			tallestcolumn=currentHeight;
		}
	});
	columns.height(tallestcolumn);
}
function addOneHeight(){
	$('.option[main="true"]').each(function(i,elem){
		var k=$(this).attr("data-sub-class");
		var height=$(this).height();
		$(".option[data-sub-class='"+k+"']").each(function(){
			$(this).height(height);
		});
	});
}
$(document).ready(function(){
	setEqualHeight($(".desc"));
    if(document.documentElement.clientWidth > 700) {
        setEqualHeight($(".news-on-main .news-block a"));
    }
	
	setEqualHeight($(".avto-vnature h3"));
	setEqualHeight($(".avto-vnature .text"));
	setEqualHeight($(".avto-vnature .facts"));
	setEqualHeight($(".location"));
	setEqualHeight($(".car-slider .pic"));
	setEqualHeight($(".car-slider .about"));
	setEqualHeight($(".main_icons a"));
	setEqualHeight($(".filter-sort"));
	setEqualHeight($(".button-div"));
	setEqualHeight($(".action-summary"));
	
	setEqualHeight($(".table-dop-ob"));

	setEqualHeight($(".smallcompany"));
	setEqualHeight($(".company-small"));
	
	setEqualHeight($(".company"));
	setEqualHeight($(".company .ofer"));
	addOneHeight();

	/*$(window).resize(function(){
		setEqualHeight($(".desc"));
		setEqualHeight($(".news-on-main .news-block a"));
		setEqualHeight($(".avto-vnature h3"));
		setEqualHeight($(".avto-vnature .text"));
		setEqualHeight($(".avto-vnature .facts"));
		setEqualHeight($(".location"));
		setEqualHeight($(".car-slider .pic"));
		setEqualHeight($(".car-slider .about"));
		setEqualHeight($(".main_icons a"));
		setEqualHeight($(".filter-sort"));
		setEqualHeight($(".button-div"));
		setEqualHeight($(".action-summary"));
		
		setEqualHeight($(".table-dop-ob"));

		setEqualHeight($(".smallcompany"));
		setEqualHeight($(".company-small"));
		
		setEqualHeight($(".company"));
		setEqualHeight($(".company .ofer"));

		addOneHeight();
	})*/
});


































