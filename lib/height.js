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
	setEqualHeight($(".company"));
	setEqualHeight($(".table-dop-ob"));
	setEqualHeight($(".smallcompany"));
	setEqualHeight($(".company .ofer"));
	addOneHeight();
});


































function nospace2(str)
{
	var newStr = str.replace(/ /g, '');
	return newStr;
}

function disabled(obj,parent)
{
	price = parseInt(nospace2($(".def-price").html()));

	if(obj.attr("data-main")=="1")
	{
		if(obj.attr("data-input")=="1")
		{
			$(".company").each(function(i,item){
				if($(this).find(".checkcompany").attr("data-immortal")!="1") {
					$(this).css("pointer-events","none");
					$(this).find(".checkcompany").attr("data-input","0");
					$(this).find(".checkcompany").html("");
					$(this).css({"border-color":"#ccc","border-width":"1px"});
					$(this).find("div").css("color","#ccc");
				}
			});
			$(".addingcompany").remove();
			obj.css("pointer-events","auto");
			obj.attr("data-input",1);
			obj.html('<i class="fa fa-check" aria-hidden="true"></i>');
			parent.css({"border-color":"#fc3","border-width":"5px"});
			parent.find("div").css("color","#333");
			$(".vigoda").append("<div class='addingcompany' id='"+obj.attr("data-id")+"'>"+parent.find(".ofer").html()+"</div>");
			$(".vigoda").append("<div class='clearfix'></div>");
			//$(".company-total-price").html(price-parseInt(obj.attr("data-skidka"))-parseInt(obj.attr("data-bydget")));
			
		}
		else{
			$(".company").each(function(i,item){
				$(this).css("pointer-events","auto");
				$(this).find("div").css("color","#333");
				$(this).css({"border-color":"#acacac","border-width":"1px"});
			});
		}
		
	}
}







function disabledsmall(obj,parent)
{
	price = parseInt(nospace2($(".def-price").html()));

	if(obj.attr("data-main")=="1")
	{
		if(obj.attr("data-input")=="1")
		{
			$(".smallcompany").each(function(i,item){
				if($(this).find(".checkcompany").attr("data-immortal")!="1") {
					$(this).css("pointer-events","none");
					$(this).find(".checkcompany").attr("data-input","0");
					$(this).find(".checkcompany").find("div").html("");
					$(this).find(".checkcompany").find("div").css("border-color","#efefef");
					$(this).css({"border-color":"#efefef","border-width":"1px"});
					$(".smallcompany .ofer").css("color","#ccc ");
				}

			});
			$(".addingcompany").remove();
			obj.css("pointer-events","auto");
			obj.find("div").css("border-color","#acacac");
			obj.attr("data-input",1);
			obj.find("div").html('<i class="fa fa-check" aria-hidden="true"></i>');
			parent.css({"border-color":"#fc3","border-width":"3px"});
			parent.find(".ofer").css("color","#000");
			$(".vigoda").append("<div class='addingcompany' id='"+obj.attr("data-id")+"'>"+parent.find(".ofer").html()+obj.find("div").html()+"</div>");
			$(".vigoda").append("<div class='clearfix'></div>");
			//$(".company-total-price").html(price-parseInt(obj.attr("data-skidka"))-parseInt(obj.attr("data-bydget")));
			
		}
		else{
			$(".smallcompany").each(function(i,item){
				$(this).css("pointer-events","auto");
				$(".smallcompany .ofer").css("color","#000");
				$(this).css({"border-color":"#dcdcdc","border-width":"1px"});
				$(this).find(".checkcompany").find("div").css("border-color","#acacac");
			});
		}
		
	}
}





$(document).ready(function(){

	$(".company").each(function(i,item){
		var width = $(this).find(".title").css("width");
		$(this).find(".ofer").css({"position":"absolute","bottom":"37px","left":"15px","width":width});
		$(this).css("height",$(this).height()+$(this).find(".ofer").height()+30);
		$(this).height($(this).height()+30);
	});

	$(".smallcompany .checkcompany").css("height",$(".smallcompany").parent().height());














	$(".smallcompany").on("click"," .checkcompany",function(){
		var parent = $(this).parent().parent();
		if($(this).attr("data-input")=="0")
		{
			$(this).attr("data-input",1);
			$(this).find("div").html('<i class="fa fa-check" aria-hidden="true"></i>');
			parent.css({"border-color":"#fc3","border-width":"3px"});
			$(".vigoda").append("<div class='addingcompany' id='"+$(this).attr("data-id")+"'>"+parent.find(".ofer").html()+$(this).find("div").html()+"</div>");
			$(".vigoda").append("<div class='clearfix'></div>");
			disabledsmall($(this),parent);
		}
		else{
			$(this).attr("data-input",0);
			$(this).find("div").html("");
			parent.css({"border-color":"#dcdcdc","border-width":"1px"});
			$("#"+$(this).attr("data-id")).remove();
			disabledsmall($(this),parent);
		}

	});



















	$("body").on("click",".company .checkcompany",function(){

		var parent = $(this).parent().parent().parent();
		//var price = parseInt(nospace2($(".company-total-price").html()));

		if($(this).attr("data-input")=="0")
		{
			
			$(this).html('<i class="fa fa-check" aria-hidden="true"></i>');
			$(this).attr("data-input",1);
			parent.css({"border-color":"#fc3","border-width":"5px"});
			$(".vigoda").append("<div class='addingcompany' id='"+$(this).attr("data-id")+"'>"+parent.find(".ofer").html()+"</div>");
			$(".vigoda").append("<div class='clearfix'></div>");
			//$(".company-total-price").html(price-parseInt($(this).attr("data-skidka"))-parseInt($(this).attr("data-bydget")));
			disabled($(this),parent);
			
		}
		else
		{
			
			$(this).html("");
			$(this).attr("data-input",0);
			parent.css({"border-color":"#acacac","border-width":"1px"});
			$("#"+$(this).attr("data-id")).remove();
			//$(".company-total-price").html(price+parseInt($(this).attr("data-skidka"))+parseInt($(this).attr("data-bydget")));
			disabled($(this),parent);
			
		}
	})















})