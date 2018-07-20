/*Раскрытие списка оборудования на странице viewcar*/
$(document).ready(function(){
  $(".totalcars-block-open").css('cursor','pointer');
  $('.open_complect').click(function(event){
     var a = $(this);
     var parent = a.parent();
     /*parent = parent.parent();
     parent = parent.parent();
     parent = parent.parent();*/
     var forcount = parent;
     if(a.attr("data-role")==1)
     {
      parent = parent.find('.complect-hidden');
      parent.css('display','block');
      parent.find(".carList:last").css('border','none');
      a.attr("data-role","0");
      a.find(".fa").removeClass("fa-angle-down");
      a.find(".fa").addClass("fa-angle-up");
      forcount.find(".totalcars-block-open").attr("data-role","0");
      $(this).css("background","#f5f5f5");
      $(this).css("border-radius"," 0 0 5px 5px");
      $(this).css("border-bottom",'0px');
      $(this).css('color','#333');
      forcount.find(".totalcars-block-open").css("background","transparent");
     }
     else
     {
      parent = parent.find('.complect-hidden');
      parent.css('display','none');
      a.attr("data-role","1");
      a.find(".fa").removeClass("fa-angle-up");
      a.find(".fa").addClass("fa-angle-down");
      forcount.find(".totalcars-block-open").attr("data-role","1");
      $(this).css("background","#fff");
      $(this).css("border-bottom",'1px solid rgb(223,223,223)');
      $(this).css('color','#777');
      forcount.find(".totalcars-block-open").css("background","rgb(252, 251, 177)");
     }
  });

  $(".totalcars-block-open").click(function(){
      var a = $(this);
      if(a.attr("data-role")==1)
      {   
          $(this).parent().parent().parent().parent().find(".complect-hidden").css("display","block");
          a.attr("data-role","0");
          $(this).parent().parent().parent().parent().find(".open_complect").html("<i class='fa fa-angle-down'></i>");
          $(this).parent().parent().parent().parent().find(".open_complect").attr("data-role","0");
      }
      else
      {   
          $(this).parent().parent().parent().parent().find(".complect-hidden").css("display","none");
          a.attr("data-role","1");
          $(this).parent().parent().parent().parent().find(".open_complect").html("<i class='fa fa-angle-up'></i>");
          $(this).parent().parent().parent().parent().find(".open_complect").attr("data-role","1");
      }
  });

  $("#opencharlist").click(function(){
    if($(this).attr("data-status")==1)
    {
      $(this).attr("data-status",0)
      $("#texhcharoption").css("display","block");
      $(this).find("i").removeClass("fa-angle-down");
      $(this).find("i").addClass("fa-angle-up");
    }
    else
    {
      $(this).attr("data-status",1)
      $("#texhcharoption").css("display","none");
      $(this).find("i").removeClass("fa-angle-up");
      $(this).find("i").addClass("fa-angle-down");
    }
  });

  $(".accordion-item label").click(function(){
    if($(this).find("i").hasClass("fa-angle-down"))
    {
      $(this).find("i").removeClass("fa-angle-down");
      $(this).find("i").addClass("fa-angle-up");
    }
    else 
    {
      $(this).find("i").removeClass("fa-angle-up");
      $(this).find("i").addClass("fa-angle-down");
    }
  });

  $(".click-option-complect").click(function(){
    if($(this).parent().find(".option-list").hasClass("option-list-disabled"))
    {
      $(this).parent().find(".option-list").removeClass("option-list-disabled");
      $(this).find(".fa").html("свернуть");
      /*$(this).find(".fa").removeClass("fa-angle-down");
      $(this).find(".fa").addClass("fa-angle-up");*/
    }
    else
    {
      $(this).parent().find(".option-list").addClass("option-list-disabled");
      $(this).find(".fa").html("подробнее");
      /*$(this).find(".fa").removeClass("fa-angle-up");
      $(this).find(".fa").addClass("fa-angle-down");*/
    }
  });

  if($("body").width()<700)
  {
    $(".option-form-list").css("display","none");
  }
  $(".filter-form-option-link").click(function(){
    if($(this).find(".fa").hasClass("fa-angle-down"))
    {
      $(".option-form-list").css("display","block");
      $(this).find(".fa").removeClass("fa-angle-down");
      $(this).find(".fa").addClass("fa-angle-up");
      $(".filter-message").html("Свернуть");
    }
    else
    {
      $(".option-form-list").css("display","none");
      $(this).find(".fa").removeClass("fa-angle-up");
      $(this).find(".fa").addClass("fa-angle-down");
      $(".filter-message").html("Больше параметров");
    }
  })
});