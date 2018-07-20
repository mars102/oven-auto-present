function nospace(str)
{
	var VRegExp=new RegExp(' ');
	var VResult=str.replace(VRegExp,'');
	return VResult
}
function nospace2(str)
{
	var newStr = str.replace(/ /g, '');
	return newStr;
}
function number_format(number,decimals,dec_point,thousands_sep)
{
	var i,j,kw,kd,km;
	if(isNaN(decimals=Math.abs(decimals))){decimals=2;}
	if(dec_point==undefined){dec_point=",";}
	if(thousands_sep==undefined){thousands_sep=".";}
	i=parseInt(number=(+number||0).toFixed(decimals))+"";
	if((j=i.length)>3){j=j%3;}
	else{j=0;}
	km=(j?i.substr(0,j)+thousands_sep:"");
	kw=i.substr(j).replace(/(\d{3})(?=\d)/g,"$1"+thousands_sep);
	kd=(decimals?dec_point+Math.abs(number-i).toFixed(decimals).replace(/-/,0).slice(2):"");
	return km+kw+kd;
}

function getDate(data, day)
{
	var m_day ='';
	var m_month='';
	data = data.split('.');
	data = new Date(data[2], +data[1]-1, +data[0]+day, 0, 0, 0, 0);
	

	m_day = data.getDate();
	m_month = data.getMonth()+1;

	if(m_day<10) m_day = '0'+m_day;
	if(m_month+1<10) m_month = '0'+m_month;

	data = [m_day,m_month,data.getFullYear()];
	data = data.join('.').replace(/(^|\/)(\d)(?=\/)/g,"$10$2");
	return data;
}

$(document).ready(function(){
	$(".pricetext").keyup(function(){
		var text = number_format($(this).val(),0,'',' ');
		$(this).val(text);
	});

	var pricetotal = nospace2($("#total-price").text());
	var sumpack = 0;
	$(".checkbox").each(function(index, value) { 
	if($(this).prop("checked"))
		sumpack+= parseInt($(this).attr("data-price"));
	});
	$(".configure #total-price").text(number_format(parseInt(sumpack)+parseInt(pricetotal),0,'',' '));

	$("#predpay").html($("#total-price").text()+" руб.");
	var tp = number_format(nospace2($("#total-price").text())*0.02,0,'',' ');
	$("#predsale").html(tp+" руб");

	var countDays = 0;
	$(".pack-price input").click(function(event){
		var znak=$(this).attr('data-znak');
		var total=($("#total-price").text());
		total=total.replace(/\s/g,'');
		var pack_price=$(this).attr('data-price');
		total=parseInt(total,10);
		pack_price=parseInt(pack_price,10);
		switch(znak)
		{
			case'+':total+=pack_price;total=number_format(total,0,'',' ');
				$("#total-price").html(total);
				$("input[name='totalprice']").val(total);
				$(this).attr('data-znak','-');

				$("#predpay").html(total+" руб.");
				tp = number_format(Math.round((nospace2(total)*0.02)),0,'',' ');
				$("#predsale").html(tp+" руб");
				
				if(countDays==1)				
					$("#hid #datechange").html(getDate($("#hid #datechange").html(),3));
				if(countDays>1)
					$("#hid #datechange").html(getDate($("#hid #datechange").html(),5));
				countDays++;

				break;
			case'-':
				total-=pack_price;total=number_format(total,0,'',' ');
				$("#total-price").html(total);
				$("input[name='totalprice']").val(total);
				$(this).attr('data-znak','+');
				//
				$("#predpay").html(total+" руб.");
				tp = number_format(Math.round((nospace2(total)*0.02)),0,'',' ');
				$("#predsale").html(tp+" руб");

				countDays--;
				if(countDays==1)				
					$("#hid #datechange").html(getDate($("#hid #datechange").html(),-3));
				if(countDays>1)
					$("#hid #datechange").html(getDate($("#hid #datechange").html(),-5));
				
			default:
				break;
		}
		setTimeout(function()
			{$("#total-price").css("animation","pulsar-cart 1s")
		});
		$("#total-price").css('animation','');
		setTimeout(function()
			{$("#car-price-string").css("animation","pulsar-cart 1s")
		});
		$("#car-price-string").css('animation','');
	});
});