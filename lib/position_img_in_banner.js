$(document).ready(function(){
	var margin = 0;
	var blockHeight = $(".block-banner").height();
	var pickHeight = $(".block-banner img").height();
	if(blockHeight<pickHeight){
		margin = (pickHeight-blockHeight)/2;
		$(".block-banner img").css("margin-top",(-1)*margin);
	}
});