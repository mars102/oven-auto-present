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
			//бежим по всем компаниям
			$(".company").each(function(i,item){
				//выбираем те у которых immortal не равен 1
				if(
					$(this).find(".checkcompany").attr("data-immortal")!="1" 
				) {
					//убираем курсор
					$(this).css({"pointer-events":"none"});
					//очищаем содержимое, удаляем галку
					$(this).find(".checkcompany").html("");
					//ставим бледную границу
					$(this).css({"border-color":"#ccc","border-width":"1px"});
					//цвет шрифта бледный
					$(this).find("div").css("color","#ccc");
					//цвет описания акции бледный
					$(this).find(".description").css("color","#ccc");
					//ЦВЕТ ГРАНИЦЫ ЯЧЕЙКИ
					$(this).find(".checkcompany").css({"border-color":"#efefef","pointer-events":"none"});
				}
			});
			//УДАЛЯЕМ ВСЁ ИЗ ЧЕКА
			$(".addingcompany").remove();
			//ПРОХОИМ СНОВА ПО ВСЕМ КОМПАНИЯМ
			$(".company").each(function(i,item){
				//ЕСЛИ ВКЛЮЧЕНА И БЕССМЕРТНА
				if(
					$(this).find(".checkcompany").attr("data-input")=="1" &&
					$(this).find(".checkcompany").attr("data-immortal")=="1"
				) {
					//ТО КУРСОР АКТИВЕН
					$(this).find(".checkcompany").css({"pointer-events":"auto",});
					//СОДЕРЖИМОЕ ФА ИКОНКА
					$(this).find(".checkcompany").html('<i class="fa fa-check" aria-hidden="true"></i>');
					//ВСТАВЛЯЕМ В ЧЕК
					$(".vigoda").append("<div class='addingcompany' id='"+$(this).find(".checkcompany").attr("data-id")+"'>"+$(this).find(".ofer").html()+"</div>");
					//ЧИСТИМ ЛИНИЮ
					$(".vigoda").append("<div class='clearfix'></div>");
				}
			});

			obj.css("pointer-events","auto");
			obj.attr("data-input",1);
			obj.html('<i class="fa fa-check" aria-hidden="true"></i>');
			parent.css({"border-color":"#fc3","border-width":"5px"});
			parent.find("div").css("color","#333");
			$(".vigoda").append("<div class='addingcompany' id='"+obj.attr("data-id")+"'>"+parent.find(".ofer").html()+"</div>");
			$(".vigoda").append("<div class='clearfix'></div>");
		}
		else{
			$(".company").each(function(i,item){
				$(this).css("pointer-events","auto");
				$(this).find("div").css("color","#333");
				$(this).css({"border-color":"#acacac","border-width":"1px"});
				$(this).find(".checkcompany").css({"border-color":"#ccc","pointer-events":"auto"});
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
					$(this).find(".ofer").css("color","#ccc ");
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