<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="yandex-verification" content="6fdd26a92d5642c1" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content='"Фирма "Овен-Авто" официальный дилер Renault в республике Коми'/>
    <meta name="google-site-verification" content="XSSCXxgznzGE53HF7TwSwFsipEa6Vp98QkqEAtxETEI" />
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>
      <?= ucwords('renault | '.$data['title']).' | Овен-Авто | Сыктывкар'; ?>
    </title>

    
    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="icon" type="image/png" href="/images/favicon_152x152.png">
     

  </head>
  <body>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    
    
    <!--preloader-->
    <script>
     
      $(window).on('load', function () {
          var $preloader = $('#page-preloader'),
              $spinner   = $preloader.find('.spinner');
          $spinner.fadeOut();
          $preloader.delay(50).fadeOut('slow');
      });
    </script>
    <style>
      #page-preloader {
          position: fixed;
          left: 0;
          top: 0;
          right: 0;
          bottom: 0;
          background: #fff;
          z-index: 100500;
      }

      #page-preloader .spinner {
          width: 32px;
          height: 32px;
          position: absolute;
          left: 50%;
          top: 50%;
         
          margin: -16px 0 0 -16px;
      }
      @media screen and (max-width: 600px){
        .address{font-size: 12px;}
      }
    </style>
    <div id="page-preloader"><span class="spinner"><img style="width:30px;" src="/images/load.gif"></span></div>
    <!--preloader end-->


    <?php echo \app\models\Rmenu_model::viewMenu();?>


    <div class="container-fluid top-header hidden-xs" style="padding-right:0px";>
      
      <div class="col-sm-12">
        <ul class="left">
          <li><a href="http://renault.ru/my-renault/index.jsp" target="_blank">Подключитесь к My Renault</a></li>
        </ul>
        <ul class="right">
          <li><a href="/content/availablelist">Автомобили в продаже</a></li>
          <li><a href="/content/testform">Тест-драйв</a></li>
          <li><a href="/content/service">Записаться на сервис</a></li>
        </ul>
      </div>

    </div>


  <div class="container-fluid mid-header" style="border-bottom: 1px solid #ddd;">
    <div class="row">
      <div class="col-sm-1 col-xs-4 text-center">
        <a href="/"><img src="/images/logo.png" alt="Логотип"></a>
      </div>
      <div class="col-sm-5 hidden-xs">
        <span class="name">ОВЕН-АВТО</span>
        <span class="slogan hidden-xs">Официальный дилер Renault в Республике Коми</span>
      </div>
      <div class="col-sm-4 ">
          <a class="phone" href="tel:88212288588">8 (8212) 288-588</a>
          <span class="address">г. Сыктывкар, ул. Гаражная, 1</span>
      </div>
      <div class="col-sm-2 hidden-xs text-center">
        <img src="/images/renault_logo.png" alt="Логотип Renault">
      </div>
    </div>
  </div>

  <?php
    \app\core\PageElements::getMenu();
  ?>

  <div class="marlboro text-center hidden-xs hidden-sm">
    <form action="/content/availablelist" method="POST">
    <button type="submit" style="background:transparent;border:0px;" name="selectedcars">
      <i class="fa fa-star-o"></i>
      <span class="countcars"><?=count($_SESSION['cart']);?></span>
      <svg width="0" height="0">
        <defs>
          <clipPath id="clip-shape" clipPathUnits="objectBoundingBox">
            <polygon points="0.5 0, 1 0, 1 1, 0.5 0.7, 0 1, 0 0" />
          </clipPath>
        </defs>
      </svg>
    </button>
    </form>
  </div>

  <?php
    require_once($view);
  ?>

<div class="container-fluid footer block hidden-xs">
  <div class="container">
  <?php
    \app\core\PageElements::viewFooter();
  ?>  
  </div>
</div>

<div class="container-fluid" style="background: #555;">
  <div class="container">
    <div class="row footer-text"  style="color: #fff;padding: 15px 0; ">
      <div class="col-sm-6">
        2006-<?=date('Y');?> © ООО «Фирма «Овен-Авто». Все права защищены.
      </div>
      <div class="col-sm-12 text-justify hidden-xs" style="font-size: 12px; padding-top: 15px;">
        Обращаем Ваше внимание на то, что сайт <?=$_SERVER['HTTP_HOST'];?> носит исключительно информационный характер и ни при каких условиях не является публичной офертой, определяемой положениями Статьи 437 (2) Гражданского кодекса Российской Федерации. Для получения подробной информации, Вы можете связаться с нашими специалистами.
      </div>
    </div>
  </div>
</div>


<style>
  .modal-header{
    background:#fc3;
    border-radius: 5px 5px 0 0;
  }
</style>

<!--USER Modal -->
<div class="modal fade userModal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <div>
          <h3 class="modal-title" id="exampleModalLabel" style="float: left;"></h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <div class="modal-body">
        <form action="" method="POST" class="send-form" id="userModal">

        </form>
      </div>
    </div>
  </div>
</div>
<!--END USER Modal-->

<div id="top" class="hidden-xs"><i class="fa fa-arrow-circle-o-up" aria-hidden="true"></i></div>
  <!-- Bootstrap -->
  <link href="/lib/bootstrap/css/bootstrap.css" rel="stylesheet">

  <link href="/style/main.css" rel="stylesheet">
  <link href="/style/company.css" rel="stylesheet">
  <link rel="stylesheet" href="/style/style.css">
  <link rel="stylesheet" href="/fonts/fa-icons/css/font-awesome.min.css">
  <link rel="stylesheet" href="/fonts/icofont/css/icofont.css">
  <link rel="stylesheet" href="/style/v_menu.css"> 
  <link rel="stylesheet" href="/style/button.css"> 
  <link rel="stylesheet" href="/style/available.css">
  <link rel="stylesheet" href="/style/hover.css">
  <link rel="stylesheet" href="/fonts/renault/font.css">

  <script src="/lib/fixed.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="/lib/bootstrap/js/bootstrap.min.js"></script>

  <!--MASK JQUERY-->
  <script src="/lib/mask/mask.js"></script>
  <script>
    //$(".phone").mask("+7(999) 999-9999");
    $(document).on('focus', '.phone', function(e){
        $(this).mask("+7(999) 999-9999");
    });
  </script>

  <!--SLICK SLIDER-->
  <link rel="stylesheet" type="text/css" href="/lib/slick/slick.css"/>
  <script type="text/javascript" src="/lib/slick/slick.min.js"></script>
  <script src="/lib/slick_slider_config.js"></script>

  <script src="/lib/scroller.js"></script>
  
  <script src="/lib/height.js"></script>

  <script src="/lib/open_block.js"></script>
  
  <script src="/lib/form.js"></script>
  <script src="/lib/configurator_page.js"></script>
  <script src="/lib/alpha.js"></script>
  <script src="/lib/position_img_in_banner.js"></script>

  <!--КРАСИВЫЙ АЛЕРТ-->
  <script type="text/javascript" src="/lib/sweetalert/sweetalert.js"></script>
  <link rel="stylesheet" type="text/css" href="/lib/sweetalert/sweetalert.css">

  <!--pulsar-->
  <script src="/lib/rippleria-master/js/jquery.rippleria.min.js"></script>
  <link rel="stylesheet" type="text/css" href="/lib/rippleria-master/css/jquery.rippleria.min.css">
  <script src="/lib/cart.js"></script>

  <!--CALENDAR TCALL-->
  <link href="/lib/air-datepicker-master/css/datepicker.min.css" rel="stylesheet" type="text/css">
  <script src="/lib/air-datepicker-master/js/datepicker.min.js"></script>
  <script>
    $(document).ready(function(){
      $(document).on('focus', '.date_', function(e){
        $(this).addClass('datepicker-here');
        $(this).datepicker({
          changeMonth: true,
          changeYear: true,
          dateFormat: 'dd-mm-yy',
          //yearRange: '1920:2020',
          timepicker: true});


          //.data('datepicker');
      });
    })
  </script>

  

<script>
  $(document).ready(function(){
    $(".modalButton").click(function(){
      $(".userModal").find(".modal-title").html();
      $(".userModal").find(".modal-body").find("form").html();
      $.ajax({
        url: '/ajax/loadform/'+$(this).attr("data-form"),
        success: function(data){
          var obj = jQuery.parseJSON(data);
          var car = '';

          $(".userModal").find(".modal-title").html(obj['header']);
          $(".userModal").find(".modal-body").find("form").html("");
          
          car = $("<div class='modal-car hidden-xs'></div>").appendTo($(".userModal").find(".modal-body").find("form"));
          
          if(typeof(carformodal)!='undefined' && carformodal !== null)
            car.append(carformodal);

          if(typeof(carformodaltext)!='undefined' && carformodaltext !== null)
            car.append(carformodaltext);

          $(".userModal").find(".modal-body").find("form").append(obj['html']);
          
          
        },
        error: function(){
          alert("Ошибка");
        }
      });
      
      $(".userModal").modal("show");
    })
  })
  /*$('.userModal').on('shown.bs.modal', function (e) {
    alert('Модальное окно успешно показано!');
  });*/
</script>

<script type="text/javascript">
  $(document).ready(function() {
      $("#content .tab-block").hide(); // Скрытое содержимое
      $("#tabs div:first").attr("id","current"); // Какой таб показать первым
      $("#content #tab1").show(); // Показ первого контента таба

    $('#tabs a').click(function(e) {
        e.preventDefault();
        $("#content .tab-block").hide(); //Скрыть всё содержимое
        $("#tabs div").attr("id",""); //Сброс идентификаторов
        $(this).parent().attr("id","current"); // Активация идентификаторов
        $('#' + $(this).attr('title')).fadeIn(); // Показать содержимое текущей вкладки
    });

    $(".deletext").click(function(){
      $(this).parent().find("input").val("");
    })
});
</script>


<!--justyGallery-->
<link rel="stylesheet" type="text/css" href="/lib/gallery/justifiedGallery.min.css">
<script src="/lib/gallery/jquery.justifiedGallery.min.js"></script>
<script>
  $("#mygallery").justifiedGallery({
    rowHeight : 150,
    lastRow : 'justify',
    margins : 0
  });
</script>
<!--lightbox-->
<link rel="stylesheet" type="text/css" href="/lib/lightbox/css/lightbox.css">
<script src="/lib/lightbox/js/lightbox.js"></script>



<script>

    $('.block-news table').addClass('table');
    $('.block-news table').removeAttr("border");
    $('.block-news table').removeAttr("width");

</script>


<script>
  /*Показать кнопку подробнее на списке машин*/
  $(".aboutcar").mouseenter(function(){
    $(this).parent().find(".locationcell").find(".locationinfo").css('display','none');
    $(this).parent().find(".locationcell").find(".opencar").css('display','block');
  })
  $(".carList").mouseleave(function(){
    $(this).find(".locationcell").find(".locationinfo").css('display','block');
    $(this).find(".locationcell").find(".opencar").css('display','none');
  })
</script>

<script>
  $(document).ready(function(){
    var width = $("#filter-block").width();
    var height = $("#filter-block").height();
    var parent = $("#filter-block").parent();
    if(parent.height()<300)
      parent.height(400);
    $("#filter-block form").width(width);
  });
</script>



<script>
  $(document).ready(function(){
    $(".non-title").each(function(){
      $(this).find("img").attr("title","");
    });
    var clicktooltip = 1;

    $('[data-toggle="tooltip"]').on('click', function(){
      
      if(clicktooltip==0){
        $(".tooltip").css("display","block");
        $(this).tooltip("show");
        clicktooltip=1;
      }
      else{
        $(".tooltip").css("display","none");
        $(this).tooltip("hide");
        clicktooltip=0;
      }

    })
    /*$('body').on('click touchstart', function (e) {
      $(".tooltip").css("display","none");
      alert(clicktooltip+"body");
      if(clicktooltip==0)
      {
        alert(1);
        $(".tooltip").css("display","none");
        clicktooltip++;
      }
    });*/

  });
  $(function () {
    // инициализировать все элементы на страницы, имеющих атрибут data-toggle="tooltip", как компоненты tooltip
    $('[data-toggle="tooltip"]').tooltip()
  });

  //alert($('.avacarblock .carList:last').attr('class'));//.css('border-bottom', 'none');
</script>

<script>
  $(document).ready(function() {
    $("a.scrollto").click(function() {
      var elementClick = $(this).attr("href")
      var destination = $(elementClick).offset().top;
      jQuery("html:not(:animated),body:not(:animated)").animate({
        scrollTop: destination-200
      }, 800);
      return false;
    });
  });

  $(document).ready(function(){
      // disable carousel cycling
      $('.avacarslider').carousel({ interval: false });
  });

  // Закругление при 22 и при 2 разное
  
  function circleclass  (classid){
    $('.'+classid).each(function(i,elem) {
      var numbercircle = $(elem).text();
      if (typeof numbercircle !== "undefined"){
        //numbercircle = parseInt(numbercircle);
        numbercircle = String(numbercircle).trim();
        long = numbercircle.length;
        //alert(long);
      
        if (long == 1) 
          { $(elem).removeClass('circletwo circlethree').addClass('circleone');}
        else if (long == 2)
          {$(elem).removeClass('circleone circlethree').addClass('circletwo'); }
        else if (long > 2) 
          {$(elem).removeClass('circleone circletwo').addClass('circlethree');
          $(elem).css("right", "0px");
          }

      } else {return false};
    });
  };
  circleclass('number-circle-min');
  circleclass('number-circle');
  circleclass('number-circle-right');
  circleclass('number-circle-right-model');




</script>
<style>
  .circleone {
      padding: .1em .56em;
      border-radius: 50%;
  }
  .circletwo {
      padding: .1em .24em;
      border-radius: 50%;
  }
  .circlethree {
      padding: .1em .24em;
      border-radius: 40% ;
  }
  .number-circle {
    background:#f00;
    color:#fff; 
    text-align:center;
    position:absolute;

    top:20px;
    right:25px; 
    z-index:99;
  }
  .number-circle-min {
    background:#4b74a3;
    color:#fff; 
    text-align:center;
    position:absolute;
    top:55px;
    right:20px; 
    z-index:99;
  }

  .number-circle-right {
    background:#4b74a3;
    color:#fff; 
    text-align:center;

    
  }

  .number-circle-right-model {
    background:#fcfbb1;
    color:#ff3b30; 
    text-align:center;

    
  }

  

</style>






  </body>
</html>
