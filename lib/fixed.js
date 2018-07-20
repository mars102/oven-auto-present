
jQuery(function($) {
  $(document).ready(function(){
      var offsetTop = ($("#car_price").offset()); 
      //$("#available-list").css('min-height',($("#filter-form").height())+50);
      var offsetTopFilter = ($("#filter-form").offset());

      var offsetTopAbout = $(".about").offset();
      var k = 0;
      var navtop = $('nav').offset();
      $(window).scroll(function(){
          //console.log(k);
          //alert(1);
          if($(this).scrollTop()>navtop.top)
          {
            $('nav').addClass('navbar-fixed-top border-navbar'); 
            $(".cbp-vimenu").css("top",0);
            $(".marlboro").addClass("marlboro-fixed");
          }
          else if ($(this).scrollTop()<navtop.top)
          {
            $('nav').removeClass('navbar-fixed-top border-navbar'); 
            $(".cbp-vimenu").css("top",0);
            $(".marlboro").removeClass("marlboro-fixed");
          }
          
          /*if(typeof(offsetTopFilter) != "undefined" && offsetTopFilter !== null) {
          
            if($(this).scrollTop()>offsetTopFilter.top-120) {$("#filter-form").addClass('fixed-filter');}
            else if($(this).scrollTop()<offsetTopFilter.top-120) {$("#filter-form").removeClass('fixed-filter');}

          }*/
          //alert(offsetTop);
          if(typeof(offsetTop) != "undefined" && offsetTop !== null) {
            if($(this).scrollTop()>offsetTop.top-50) 
            {
              //var right = Math.round($("#car_price").width()+$("#car_price").offset().left-$(".fixed-button").width())+"px";
              //console.log("offsetleft - "+$("#car_price").offset().left + "width - "+$("#car_price").width() + "sum - "+right);
              $("#car_price").addClass('fixed-car-price');
              $("#car_price").css("width",$(".container").width()+35);
              $(".fixed-button-car-head").css({"display":"block"});
            }
            else if($(this).scrollTop()<offsetTop.top)
            {
              $("#car_price").removeClass('fixed-car-price');
              $("#car_price").css("width","100%");
              $(".fixed-button-car-head").css({"display":"none"});
            }
          }

          if(typeof(offsetTopAbout) != "undefined" && offsetTopAbout !== null) {
            var scroll = $(this).scrollTop();

            if($(this).scrollTop()>offsetTopAbout.top+70 ) {
              if(k==0) {
                $(".car-slider").each(function(e,item){
                  $(this).append("<div class='fix'>"+$(this).find(".about").html()+"</div>");
                  $(this).find(".fix").css("width",$(this).css("width"));
                  $(this).find(".fix").css("padding","0px");

                  $(".car-slider[data-menu='1'] .fix").css("text-align","left");
                  $(".car-slider[data-menu='1'] .fix").css("padding-left","0px");
                  $(".car-slider[data-menu='1'] .fix span").css("padding-left","8px");
                })
                k=1;
              }
              $(".car-slider[data-type='1'] .fix").css("top",scroll-318);
              $(".car-slider[data-menu='1'] .fix").css("top",53);
            }
            else if($(this).scrollTop()<offsetTopAbout.top+70) {
              $(".car-slider .fix").remove();
              k=0;
            }
          }

      });
    });
 });