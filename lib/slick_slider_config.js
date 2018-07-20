$(document).ready(function(){
  $('.autoplay').slick({
    
    infinite: false,
    speed: 300,
    slidesToShow: 3,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 3,
          infinite: true,
          dots: true
        }
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
    ]
  });
  $('.slick-center').slick({
    
      infinite: false,
      speed: 300,
      slidesToShow: 1,
  });

  $('.banner-main').slick({
    
      infinite: true,
      speed: 300,
      slidesToShow: 1,
  });

  $('.action-area').slick({
    
    infinite: true,
    speed: 300,
    slidesToShow: 2,
    responsive: [
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
    ]
  });

  $('.kredit_banners').slick({
    fade: true,
    cssEase: 'linear',
    infinite: true,
    speed: 500,
    slidesToShow: 1,
    dots: false,
    arrows: false,
    autoplay: true,
    autoplaySpeed: 2000,
  });

});