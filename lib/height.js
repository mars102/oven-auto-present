function setEqualHeight(columns){var tallestcolumn=0;columns.each(function(){currentHeight=$(this).height();if(currentHeight>tallestcolumn){tallestcolumn=currentHeight;}});columns.height(tallestcolumn);}function addOneHeight(){$('.option[main="true"]').each(function(i,elem){var k=$(this).attr("data-sub-class");var height=$(this).height();$(".option[data-sub-class='"+k+"']").each(function(){$(this).height(height);});});}$(document).ready(function(){setEqualHeight($(".desc"));setEqualHeight($(".news-on-main .news-block a"));setEqualHeight($(".avto-vnature h3"));setEqualHeight($(".avto-vnature .text"));setEqualHeight($(".avto-vnature .facts"));setEqualHeight($(".location"));setEqualHeight($(".car-slider .pic"));setEqualHeight($(".car-slider .about"));setEqualHeight($(".main_icons a"));setEqualHeight($(".filter-sort"));setEqualHeight($(".button-div"));setEqualHeight($(".action-summary"));setEqualHeight($(".company"));setEqualHeight($(".table-dop-ob"));addOneHeight();});


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
				$(this).css("pointer-events","none");
				$(this).find(".checkcompany").attr("data-input","0");
				$(this).find(".checkcompany").html("");
				$(this).css({"border-color":"#ccc","border-width":"1px"});
				$(this).find("div").css("color","#ccc");
			});
			$(".addingcompany").remove();
			obj.css("pointer-events","auto");
			obj.attr("data-input",1);
			obj.html('<i class="fa fa-check" aria-hidden="true"></i>');
			parent.css({"border-color":"#fc3","border-width":"5px"});
			parent.find("div").css("color","#333");
			$(".company-check").append("<div class='addingcompany' id='"+obj.attr("data-id")+"'>"+parent.find(".ofer").html()+"</div>");
			$(".company-total-price").html(price-parseInt(obj.attr("data-skidka"))-parseInt(obj.attr("data-bydget")));
			
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

$(document).ready(function(){

	var block = $(".company-border");
	var defTop = $(".company-border").offset();

	$(window).scroll(function(){
		if(typeof(defTop) != "undefined" && defTop !== null) {
		   if(defTop.top<$(this).scrollTop())
			{
				block.offset({top:$(this).scrollTop()+150});
				//console.log($(this).scrollTop());
			}
			else{
				block.offset({top:defTop});
			}
		}
	});

	$(".company").each(function(i,item){
		var width = $(this).find(".title").css("width");
		$(this).find(".ofer").css({"position":"absolute","bottom":"15px","left":"15px","width":width});
	});
	$("body").on("click",".company .checkcompany",function(){
		var parent = $(this).parent().parent().parent();
		var price = parseInt(nospace2($(".company-total-price").html()));



		if($(this).attr("data-input")=="0")
		{
			
			$(this).html('<i class="fa fa-check" aria-hidden="true"></i>');
			$(this).attr("data-input",1);
			parent.css({"border-color":"#fc3","border-width":"5px"});
			$(".company-check").append("<div class='addingcompany' id='"+$(this).attr("data-id")+"'>"+parent.find(".ofer").html()+"</div>");
			$(".company-total-price").html(price-parseInt($(this).attr("data-skidka"))-parseInt($(this).attr("data-bydget")));
			disabled($(this),parent);
			
		}
		else
		{
			
			$(this).html("");
			$(this).attr("data-input",0);
			parent.css({"border-color":"#acacac","border-width":"1px"});
			$("#"+$(this).attr("data-id")).remove();
			$(".company-total-price").html(price+parseInt($(this).attr("data-skidka"))+parseInt($(this).attr("data-bydget")));
			disabled($(this),parent);
			
		}
	})
})