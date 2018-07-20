/*ДЛЯ АЛЬФЫ*/
$(document).ready(function(){
  if($('.color-block div').attr("pay-color")=='true') 
    pay_color = "окраска кузова металлик";
  else
    pay_color = "окраска кузова не металлик";
  $('.present').css('background',$('.color-block div').attr('data-color'));
  $('.color-block #text-color').html($('.color-block div').attr('data-color-name')+'<br/>'+pay_color);
  $("#current-color").text(pay_color);
  $("#current-code").text($('.color-block div').attr('data-color-name'));
  $("#current-view-color").css("background",'#fff');
  $("#current-view-color").css("border-color",'#fff');
});

$('.color-button').on('click',function(event){
  $(".color-visible").css("color",'#333');
  var elem = $(this);
  var parent = elem.parent();
  var pay_color = '';
  var grandParent = parent.parent();
  var colored = grandParent.find(".present");
  var text = grandParent.find("#text-color");
  var double = "";
  $(".present").css("display","none");
  $("."+elem.attr('data-type')).css("display","block");
  colored.css('backgroundColor',this.getAttribute('data-color'));
  if($(this).attr("pay-color")=='true') 
    pay_color = "окраска кузова металлик";
  else
    pay_color = "окраска кузова не металлик ";
  text.html($(this).attr("data-color-name")+'<br/>'+pay_color);
  $("#current-color").text(pay_color);
  $("#current-code").text($(this).attr('data-color-name'));
  if($(this).attr('data-double')=='true')
    double = ", двухцветная";
  $("#current-type").text(double);
  $("#current-view-color").css("background",$(this).css('background'));
  
  $("#postavka #changed").css("display","none");
  $("#postavka #hid").css("display","inline");
  
});