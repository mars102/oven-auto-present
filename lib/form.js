/*Показы выбранной формы*/
/*$(document).ready(function(){
  $("#select-change").change(function(){
    $("#forms-block .change-form").css("display","none");
    $("#forms-block h2").remove();
    $("#"+$(this).val()).css("display","block");
  })
})*/

/*Отправка форм*/
$(document).ready(function(){
  
  //$(".form-list #submit-button").css("pointer-events","none");
  //$(".form-list #submit-button").removeClass("button-main-page");
  //$(".form-list #submit-button").addClass("btn-clear");

function checkMail(str)
{
    if(/^[\w]{1}[\w-\.]*@[\w-]+\.[a-z]{2,4}$/i.test(str)){
      return true;
    }
    return false;
}

function checkName(str)
{
    if(/^[A-zА-яЁё ]+$/.test(str) && str.length>1) {
      return true;
    }
    return false;
}
function checkPhone(str)
{
    /*if(/^\d[\d\(\)\ -]{4,14}\d$/.test(str)){
      return true;
    }
    return false;*/
    if(str.length>14)
      return true;
    return false;
}
function checkComment(str)
{
    var regV = /http/gi;     // шаблон
    var result = str.match(regV);  // поиск шаблона в юрл

    // вывод результата
    if (result) {
        return false;
    } else {
        if(str.length>=2)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}

/*$(".form-list #submit-button").click(function(){
  if($(this).parent().parent().find('input[name="valid"]').prop("checked"))
  { 
    $.ajax({
      url: '/ajax/formsend',
      type: 'POST',
      data: $(this).parent().parent().parent().serialize(),
      success: function(data){
        //alert(data);
        swal("Ваше сообщение принято!", "В ближайшее время наш специалист с Вами свяжется", "success");
      }
    });
  }
  else
  {
    $(this).parent().parent().find('label').css('color','red');
  }
});*/


  $(".document-car a").click(function(){
    $(".get-link .modal-form a").attr("href",$(this).attr("link"));
  })
  var k1=0, k2=0, k3=0;
  $(".modal-form input").keyup(function(){
    if($(this).attr("name")=='name') {
      if(checkName($(this).val())) {$(this).css("border","1px solid #66aa66");$(this).css("box-shadow","0 0 3px #66aa66"); k1=1;}
    }
    if($(this).attr("name")=='phone') {
      if(checkPhone($(this).val())) {$(this).css("border","1px solid #66aa66");$(this).css("box-shadow","0 0 3px #66aa66"); k2=1;}
    }
    if($(this).attr("name")=='mail') {
      if(checkMail($(this).val())) {$(this).css("border","1px solid #66aa66");$(this).css("box-shadow","0 0 3px #66aa66"); k3=1;}
    }
    if(k1+k2==2) {
        $(this).parent().find("button").css("pointer-events","auto");
        $(this).parent().find("button").addClass("button-black");
    }
    else {
        $(this).parent().find("button").css("pointer-events","none");
        $(this).parent().find("button").removeClass("button-gray");
    }
  });
  $(".modal-form input").blur(function(){
    if($(this).attr("name")=='name') {
      if(!checkName($(this).val())) {$(this).css("border","1px solid #ff6666");$(this).css("box-shadow","0 0 3px #ff6666"); k1=0;}
    }
    if($(this).attr("name")=='phone') {
      if(!checkPhone($(this).val())) {$(this).css("border","1px solid #ff6666");$(this).css("box-shadow","0 0 3px #ff6666"); k2=0;}
    }
    if($(this).attr("name")=='mail') {
      if(!checkMail($(this).val())) {$(this).css("border","1px solid #ff6666");$(this).css("box-shadow","0 0 3px #ff6666"); k3=0;}
    }
    if(k1+k2==2) {
        $(this).parent().find("button").css("pointer-events","auto");
        $(this).parent().find("button").addClass("button-black");
    }
    else {
        $(this).parent().find("button").css("pointer-events","none");
        $(this).parent().find("button").removeClass("button-gray");
    }
  });
  /*$(".modal-form button").click(function(){
    var link = $(this).parent().find("a");
    $.ajax({
      url: '/ajax/getlink',
      type: 'POST',
      data: $(this).parent().serialize(),
      success: function(data){
        alert(data);
        link.css("pointer-events","auto");
        link.addClass("modal-btn-active");
      }
    });
  });*/
  $(".document-block").click(function(){
    $('<input>', { form: 'getmodalform', name:'link', id: 'now-link',type: 'hidden', value: $(this).attr('link')}).appendTo('.modal-form');
  });

  $(document).on('click', '#getLinkButton', function(e){
      var error = 0;

      if($(this).parent().find('input[name="valid"]').prop("checked")){error = 0;}
      else error++;

      if(error==0){
        $.ajax({
          url: '/ajax/getlink',
          type: 'POST',
          data: $(this).parent().serialize(),
          success: function(data){
            $(".modal-form").empty();
            
            if(data==1)
            {
              $(".modal-form").empty();
              $(".modal-title").find("b").text("Выберите файлы")
              $(".document-car .item-file").each(function(i,item){
                var txt = $(item).find("span").text();
                var link = $(item).attr("link");
                $('<a>', {target: '_blank', style: 'margin-bottom:10px', class: 'button button-yellow', href: link, text: txt}).appendTo('.modal-form');
              })
            }
            //link.css("pointer-events","auto");
            //link.addClass("modal-btn-active");
          }
        });
      }
      //console.log($(this).parent().serialize());
  });

  /*$("#getLinkButton").click(function(){
  var error = 0;

    if($(this).parent().find('input[name="valid"]').prop("checked")){error = 0;}
    else error++;

    if(error==0){
      $.ajax({
        url: '/ajax/getlink',
        type: 'POST',
        data: $(this).parent().serialize(),
        success: function(data){
          if(data==1)
          {
            var link = $(".modal-form").find("#now-link").val();
            $(".modal-form").remove("#now-link");
            window.open(link,'_blank');
          }
          //link.css("pointer-events","auto");
          //link.addClass("modal-btn-active");
        }
      });
    }

    
  });*/
});


  

$(document).ready(function(){

  $("body").on('click',".check-client", function(){
    if($(this).hasClass("fa-circle-thin"))
    {
      $(this).removeClass("fa-circle-thin");
      $(this).addClass("fa-check-circle");
      $(this).addClass("checked-client");
      $(this).parent().find("#check-client").attr("checked","checked");
    }
    else{
      $(this).addClass("fa-circle-thin");
      $(this).removeClass("fa-check-circle");
      $(this).removeClass("checked-client");
      $(this).parent().find("#check-client").removeAttr("checked");
    }
  })

  function checkMail(str)
  {
      if(/^[\w]{1}[\w-\.]*@[\w-]+\.[a-z]{2,4}$/i.test(str)){
        return true;
      }
      return false;
  }

  function checkName(str)
  {
      if(/^[A-zА-яЁё ]+$/.test(str) && str.length>1) {
        return true;
      }
      return false;
  }
  function checkPhone(str)
  {
      /*if(/^\d[\d\(\)\ -]{4,14}\d$/.test(str)){
        return true;
      }
      return false;*/
      if(str.length>14)
        return true;
      return false;
  }
  function checkComment(str)
  {
      var regV = /http/gi;     // шаблон
      var result = str.match(regV);  // поиск шаблона в юрл

      // вывод результата
      if (result) {
          return false;
      } else {
          if(str.length>=2)
          {
              return true;
          }
          else
          {
              return false;
          }
      }
  }

  $('.userModal ').on('click', '.send-form button', function(e){
    var error = 0;
    var form = $('.userModal .send-form');
    form.find('input,select,textarea').each(function(i) {
      if($(this).attr("required"))
      {
        if($(this).attr("name")=="name")
        {
          if(!checkName($(this).val()))
          {
            $(this).css('border-color','#f00');
            error = 'name';
          }
          else
          {
            $(this).css('border-color','#0a0');
          }
        }
        if($(this).attr("name")=="phone")
        {
          if(!checkPhone($(this).val()))
          {
            $(this).css('border-color','#f00');
            error = 'phone';
          }
          else
          {
            $(this).css('border-color','#0a0');
          }
        }
        if($(this).attr("name")=="comment")
        {
          if(!checkComment($(this).val()))
          {
            $(this).css('border-color','#f00');
            error = 'comment';
          }
          else
          {
            $(this).css('border-color','#0a0');
          }
        }
        if($(this).attr("name")=="valid")
        {
          if($(this).attr("checked")=="checked")
          {
            $(this).parent().find("label").css('color','#0a0');
          }
          else
          {
            $(this).parent().find("label").css('color','#f00');
            error = 'valid';
          }
        }
      }
    });

    if(error==0)
    {
      var dataForm = $(".send-form").serializeArray();
      $.ajax({
        url: '/ajax/processor',
        type: 'post',
        data: dataForm,
        success: function(result) {
          formview = 0;
          $('.userModal').modal('hide');
          $('.userModal .modal-title').html('Renault');
          $('.userModal .modal-body .send-form').html(result);
          
          $('.userModal').on('hidden.bs.modal', function (e) {
              if(formview==0) {
                 $(".userModal").modal();
                 $(".userModal").modal('show');
                 formview++;
              }
          }); 
        }
      })
    }
    else{
      alert('Некоректно указанны данные\r\n1) Имя должно состоять из букв и быть длиной не менее двух символов,\r\n2) Номер телефона должен состоять из цифр, длина номера должна быть от 5 до 11 символов,\r\n3) Комментарий не должен содержать ссылок');
    }
  });

  /**************************************************************/

  $('.form-list ').on('click', 'button', function(e){
    var error = 0;
    var form = $('.form-list');
    form.find('input,select,textarea').each(function(i) {
      if($(this).attr("required"))
      {
        if($(this).attr("name")=="name")
        {
          if(!checkName($(this).val()))
          {
            $(this).css('border-color','#f00');
            error = 'name';
          }
          else
          {
            $(this).css('border-color','#0a0');
          }
        }
        if($(this).attr("name")=="phone")
        {
          if(!checkPhone($(this).val()))
          {
            $(this).css('border-color','#f00');
            error = 'phone';
          }
          else
          {
            $(this).css('border-color','#0a0');
          }
        }
        if($(this).attr("name")=="comment")
        {
          if(!checkComment($(this).val()))
          {
            $(this).css('border-color','#f00');
            error = 'comment';
          }
          else
          {
            $(this).css('border-color','#0a0');
          }
        }
        if($(this).attr("name")=="valid")
        {
          if($(this).attr("checked")=="checked")
          {
            $(this).parent().find("label").css('color','#0a0');
          }
          else
          {
            $(this).parent().find("label").css('color','#f00');
            error = 'valid';
          }
        }
      }
    });

    if(error==0)
    {
      var dataForm = $(".form-list").serializeArray();
      $.ajax({
        url: '/ajax/processor',
        type: 'post',
        data: dataForm,
        success: function(result) {
          formview = 0;
          //$('.userModal').modal('hide');
          
          $('.userModal .modal-title').html('Renault');
          $('.userModal .modal-body .send-form').html(result);
          $('.userModal').modal('show');
          /*$('.userModal').on('hidden.bs.modal', function (e) {
              if(formview==0) {
                 $(".userModal").modal();
                 $(".userModal").modal('show');
                 formview++;
              }
          });*/
        }
      })
    }
    else{
      alert('Некоректно указанны данные\r\n1) Имя должно состоять из букв и быть длиной не менее двух символов,\r\n2) Номер телефона должен состоять из цифр, длина номера должна быть от 5 до 11 символов,\r\n3) Комментарий не должен содержать ссылок');
    }
  });
});



var opacity = 0;
window.onscroll = function(){
  var top_animate = $("#animate-block").offset();
  var height = $(window).height();
  var totalheight = $(document).height();
  var bottom_animate = top_animate.top + $("#scrollanimation").height();
  if ($(window).scrollTop() + height > top_animate.top)
  {
    $("#animate-block").css("background","rgba(255,204,51,"+opacity);

    console.log(opacity);
    opacity =  1 - ((top_animate.top - $(window).scrollTop()) / 1000)  ;
  }
}