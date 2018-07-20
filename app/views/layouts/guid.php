<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Выше 3 Мета-теги ** должны прийти в первую очередь в голове; любой другой руководитель контент *после* эти теги -->  
    <title><?=$title;?></title>

    <!-- Bootstrap -->  
    <link href="/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/style/guid.css" rel="stylesheet">
    <!--fonts-->
    <link href="/fonts/renault/font.css" rel="stylesheet">
    <link href="/fonts/fa-icons/css/font-awesome.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js for IE8 support of HTML5 elements and media queries -->  
    <!-- Предупреждение: Respond.js не работает при просмотре страницы через файл:// -->  
    <!--[if lt IE 9]>
 <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script >
 <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
 <![endif]-->  
  </head>
  <body>
    
    <?php
        require_once($view);
    ?>

    <!-- на jQuery (необходим для Bootstrap - х JavaScript плагины) -->  
    <script src="/lib/jquery.js"></script>
    <!-- Включают все скомпилированные плагины (ниже), или включать отдельные файлы по мере необходимости -->  
    <script src="/lib/bootstrap/js/bootstrap.min.js"></script>

    <!--SLICK-->
    <link rel="stylesheet" type="text/css" href="/lib/slick/slick.css"/>
    <!--link rel="stylesheet" type="text/css" href="/lib/slick/slick-theme.css"/-->
    <script type="text/javascript" src="/lib/slick/slick.min.js"></script>
    <script>
        $(document).ready(function(){
            /* SLICK SLIDER CONFIG */
            $('.model-carousel').slick({
                infinite: true,
                centerMode: true,
                centerPadding: '25%',
                slidesToShow: 1,
            });
            
        });
    </script>

  </body>
</html>