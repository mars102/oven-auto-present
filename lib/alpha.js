/*ДЛЯ АЛЬФЫ*/
var color_pack = '';
$(document).ready(function(){

  $('.present').css('background',"#000");
  
  if($('.color-block div').attr("pay-color")=='true') 
    pay_color = "окраска кузова металлик";
  else
    pay_color = "окраска кузова не металлик";
  //$('.present').css('background',"url(/images/noncolor.jpg)");
  $('.color-block #text-color').html($('.color-block div').attr('data-color-name')+'<br/>'+pay_color);
  //$("#current-color").text(pay_color);
  $("#current-code").text($('.color-block div').attr('data-color-name'));
  $("#current-view-color").css("background",'#fff');
  $("#current-view-color").css("border-color",'#fff');



  $('.confbutton').each(function(){
    var p1 = $(".checkbox[data-code='"+$(this).attr("color-pack")+"']").attr("data-price");
    if(p1==undefined) p1 = 0;
    var p2 = $(".checkbox[data-code='"+$(this).attr("color-pack2")+"']").attr("data-price");
    if(p2 == undefined) p2 = 0;
    var p3 = $(".checkbox[data-code='"+$(this).attr("color-pack3")+"']").attr("data-price");
    if(p3 == undefined) p3 = 0;

    var price = parseInt(p1)+
                parseInt(p2)+
                parseInt(p3);
    
    //$(this).attr("data-toggle",'tooltip')
    //$(this).attr("title",$(this).attr("data-color-name"));
    
    if(price==0)
    {
      //$(this).attr("data-toggle",'tooltip')
      //$(this).attr("title",$(this).attr("title")+' Бесплатный цвет');
      $(this).append("<div class='basecolor'>");
    }

    $(this).attr("data-price",price);
    
    $(".checkbox[data-code='"+$(this).attr("color-pack")+"']").addClass('alertpack');
    $(".checkbox[data-code='"+$(this).attr("color-pack2")+"']").addClass('alertpack');
    $(".checkbox[data-code='"+$(this).attr("color-pack3")+"']").addClass('alertpack');

    //Если зашли в конфигуратор из машины на которой были какие-то опции включены
    if($(".checkbox[data-code='"+$(this).attr("color-pack")+"']").hasClass("preinstall"))
      $(".checkbox[data-code='"+$(this).attr("color-pack")+"']").addClass("red-check");
    if($(".checkbox[data-code='"+$(this).attr("color-pack2")+"']").hasClass("preinstall"))
      $(".checkbox[data-code='"+$(this).attr("color-pack2")+"']").addClass("red-check");
    if($(".checkbox[data-code='"+$(this).attr("color-pack3")+"']").hasClass("preinstall"))
      $(".checkbox[data-code='"+$(this).attr("color-pack3")+"']").addClass("red-check");
  })

  var selprice = 0;
  $(".red-check").each(function(){
      var packprice = parseInt($(this).attr("data-price"));
      if(packprice != undefined)
        selprice+=packprice;
  })

  var selpack = "";
  var selpack2 = "";
  var selpack3 = "";
  



  $('.color-button').on('click',function(event){
    $(".color-button").each(function(){
      $(this).removeClass("selbutton");
    })
    $(this).addClass("selbutton");

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
    colored.css('background',"");
    colored.css('backgroundColor',this.getAttribute('data-color'));
    if($(this).attr("pay-color")=='true') 
      pay_color = "окраска кузова металлик";
    else
      pay_color = "окраска кузова не металлик ";
    text.html($(this).attr("data-color-name")+'<br/>'+pay_color);
    //$("#current-color").text(pay_color);
    $("#current-code").text($(this).attr('data-color-name'));
    if($(this).attr('data-double')=='true')
      double = ", двухцветная";
    //$("#current-type").text(double);
    
    var color = $(this).attr('data-color');
    var bg = color;
    if($(this).attr('data-type')=="w")
      bg = "linear-gradient(to top,"+color+" 50%,"+"#fff"+" 50%)";
    if($(this).attr('data-type')=="b")
      bg = "linear-gradient(to top,"+color+" 50%,"+"#000"+" 50%)";

    $("#current-view-color").css("background",bg);
    $("#current-view-color").css("border-color",'#bbb');
    $("#postavka #changed").css("display","none");
    $("#postavka #hid").css("display","inline");
    
    /**/
    var button = $(this); //кнопка цвета

    var obj = $(".checkbox[data-code='"+$(this).attr("color-pack")+"']"); //чекбокс который нажала кнопка цвета

    var in_sel = 0;

    $(".red-check").each(function(){
      $(this).removeAttr("checked");
      $(this).removeClass("red-check");
    })

    //if(selpack != button.attr("color-pack") )
    //{
        $(".checkbox[data-code='"+selpack+"']").prop("checked",false);
        $(".checkbox[data-code='"+$(this).attr("color-pack")+"']").prop("checked",true);
        $(".checkbox[data-code='"+$(this).attr("color-pack")+"']").addClass("red-check");
        in_sel = 1;
    //}

    //if(selpack2 != button.attr("color-pack2") )
    //{
        $(".checkbox[data-code='"+selpack2+"']").prop("checked",false);
        $(".checkbox[data-code='"+$(this).attr("color-pack2")+"']").prop("checked",true);
        $(".checkbox[data-code='"+$(this).attr("color-pack2")+"']").addClass("red-check");
        in_sel = 1;
    //}
    //if(selpack3 != button.attr("color-pack3") )
    //{
        $(".checkbox[data-code='"+selpack3+"']").prop("checked",false);
        $(".checkbox[data-code='"+$(this).attr("color-pack3")+"']").prop("checked",true);
        $(".checkbox[data-code='"+$(this).attr("color-pack3")+"']").addClass("red-check");
        in_sel = 1;
    //}

    //if(in_sel != 0)
    //{   
        var checkedprice = $(this).attr("data-price");
        if(checkedprice==undefined) checkedprice = 0;

        colorPrice(checkedprice,selprice);
        //alert(checkedprice+' '+selprice);
        selpack = button.attr("color-pack");
        selpack2 = button.attr("color-pack2");
        selpack3 = button.attr("color-pack3");

        selprice = $(this).attr("data-price");
        if($(this).attr("data-price")==undefined)
          selprice = 0;
    //}

    //alert(checkedprice+' '+selprice);
  });
    
  /*КЛИК ПО ТЕМ ПАКЕТАМ КОТОРЫЕ ОТВЕЧАЮТ ЗА ОКРАСКУ*/
  $("body").on("click",".alertpack",function(event){
    event.preventDefault(event);
    var obj = $(this);
    alert("Данная опция включается/выключается автоматически при выборе платного цвета.");
    return;
  });

});