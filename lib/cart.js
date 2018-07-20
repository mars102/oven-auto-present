if($("#cart").html()=="0")
    $("#cart-block").css('pointer-events','none');
else
    $("#cart-block").css('pointer-events','');

$(document).ready(function(){
    function setCart(param){
        $.ajax({
            url:'/ajax/addtocart',
            type:'POST',
            data:{"param":param},
            success:function(data){
                $("#cart").html(data);
                if(data>0){
                    $("#cart-str").html("Сравнить автомобили");
                    $("#cart-block").css("pointer-events","");
                }
                else{
                    $("#cart-str").html("");
                    $("#cart-block").css("pointer-events","none");
                }
            },
            error:function(){
                console.log(0);
            }
        });
    }
    $(".available-star,#car-select").mousedown(function(){
        var currentval = parseInt($(".countcars").html());
        $(".countcars").text("");
        $(".cart-from").text("");

        if($(this).attr('check')=="false"){
            $(this).find(".icon-text").css({"color":"#333"});
            $(this).find(".icon-star").css({"color":"#ff3b30"});
            $(this).find(".icon-img").css({"color":"#ff3b30"});
            $(this).attr('check',"true");
            $(".cart-from").html(currentval+1);
            $(".countcars").html(currentval+1);
            setCart($(this).attr('data-param'));
        }
        else{
            $(this).find(".icon-text").css({"color":"#333"});
            $(this).find(".icon-img").css({"color":"#ddd"});
            $(this).find(".icon-star").css({"color":"#ddd"});
            $(this).attr('check',"false");
            $(".cart-from").html(currentval-1);
            $(".countcars").html(currentval-1);
            setCart($(this).attr('data-param'));
        }
        var obj=$(this);
        setTimeout(function(){
            obj.find("i").css("animation","pulsar-cart 1s");
            $("#cart-block").css("animation","pulsar-cart 1s");
        });
        
        $("#cart-block").css('animation','');
        $(this).find("i").css('animation','');
    });
    
    $(".delete-car-cart").click(function(){
        $(this).parent().parent().remove();
        var data=$(this).attr("data-del-id");
        $.ajax(
        {
            url:'/ajax/delcar',
            type:'POST',
            data: {"id":data},
            success:function(data){
                $(".countcars").text(data);
            }
        });
    });
});
$(document).ready(function(){
    $("#clear").click(function(){
        $.ajax({url:'/ajax/clearcart',
        type:'POST',
        success:function(){
            $('#cart').html('0');
            $('.autoplay').slick('unslick');
            $('.autoplay').remove();
        }
    })
});

$('#clear-filter').click(function(){
    $.ajax({
        url:'/ajax/clearfilter',
        type:'POST',success:function(data){

        }
    });
});
});