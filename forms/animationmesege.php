
<div style="width: 100%; display: none;"  id="smile" class="text-center">
	<div style="width: 200px; height: 150px; background: #fff; position: relative; display: inline-block;" >
		<div style="width: 33%; height: 0%; background:#ffcc33; float: left;" id="zaliv1"></div>
		<div style="width: 33%; height: 0%; background:#080; float: left;" id="zaliv2"></div>
		<div style="width: 33%; height: 0%; background:#ffcc33; float: left;" id="zaliv3"></div>
		
		<img src="/images/complite4.png" id="eror1" style ="position: absolute; top:0px; left: 0px;">
	</div>
	
	<div id="plan" class="text-left">
		<div class="work-scheme hidden-xs" id="sheme" style="display: none;">
          
          <div class="scheme-item">
            <img alt="" title="" src="/images/zaiav.png">
						<div class="scheme-line yellow-line" id="line1"></div>
            <div class="scheme-text">
              <div class="scheme-number">01</div>
              <strong>Получение заявки</strong> Ваш запрос принят и находится в очереди на обработку 

            </div>
          </div>

          <div class="scheme-item">
            <img alt="" title="" src="/images/phone.png">    <div class="scheme-line"></div>
            <div class="scheme-text">
              <div class="scheme-number">02</div>
              <strong>Обработка заявки</strong>  В ближайшее время с Вами свяжется персональный менеджер

            </div>
          </div>

          <div class="scheme-item">
			<img alt="" title="" src="/images/vstr.png">
			<div class="scheme-line yellow-line"></div>
            <div class="scheme-text">
              <div class="scheme-number">03</div>
              <strong>Встреча в салоне</strong> Договоритесь о встрече и пройдите пробную поездку
            </div>
          </div>
          
          <div class="scheme-item">
			<img alt="" title="" src="/images/avto.png">
			<div class="scheme-text">
              <div class="scheme-number">04</div>
            </div>
          </div>
        </div>
       <!--Сообщение об ошибке--> 
        <div class="hidden-xs text-center" id="sheme2" style="display: none;">
        	<div style="display: block;">
        		<span>К сожалению ваше письмо неудалось отправить. Повторите попытку позже или позвоните менеджеру по указанному номеру.</span>
			</div>
            <img alt="" title="" src="/images/phone.png" style="width: 40px; position: relative; left: 0px; opacity: .8;"> 
            <a class="phone" href="tel:88212288588" style="font-family: Renault; font-size: 25px;">8 (8212) 288-588</a>  
        </div>
   </div>
</div>

<script>

/*$( "#privet").on( "click", function() {
  myanime ();
//  myLoop2 ();
 // myLoop3 ();
});*/

var iy=1;
var ty=90;

function myanime () {          
   setTimeout(function () {
   //	by=by+1;
	ty=ty-1;  
      $(".scheme-line").css('background','repeating-linear-gradient('+ty+'deg, #ffdc4b, #ffdc4b 10px, #ffea93 10px, #ffea93 20px)');    
      iy++;                     
      if (iy < 140) {            
         
         myanime();             
      }                       
   }, 50)
}

	
		var i1 = 1;                  
		var i2 = 1; 
		var i3 = 1;
		 

		function myLoop1 () {
		   var container1=document.getElementById('zaliv1');           
		   setTimeout(function () {    
		           
		      i1++; 
		      var b=container1.style.height;
					b=Number(b.substring(0, b.length - 1));
					b=b+0.5; 
					//alert(b);
					container1.style.height=b+"%";	
					                   
		      if (i1 < 190) {            
		         myLoop1();             
		      }                        
		   }, 10)
		 //console.log(i1);
		}

		function myLoop2 () {           
		   var container2=document.getElementById('zaliv2');
		   setTimeout(function () {    
		           
		      i2++; 
		      var b=container2.style.height;
					b=Number(b.substring(0, b.length - 1));
					b=b+0.5;
					//alert(b);
					container2.style.height=b+"%";	
					                   
		      if (i2 < 190) {            
		         myLoop2();             
		      }                        
		   }, 10)
		}

		function myLoop3 () {
		   var container3=document.getElementById('zaliv3');           
		   setTimeout(function () {    
		           
		      i3++; 
		      var b=container3.style.height;
					b=Number(b.substring(0, b.length - 1));
					b=b+0.5;
					//alert(b);
					container3.style.height=b+"%";	
					                   
		      if (i3 < 190) {            
		         myLoop3();             
		      }                        
		   }, 10)
		}


	function resultMesege (result) {
   		$('.userModal .modal-body .send-form').html("");
   		
   		

         
	        $(".userModal").modal();
	      	
	      	if (result==1){
	        	$('.userModal .modal-title').html("<b>Ваше сообщение успешно отправлено!</b>");
	        	document.getElementById("eror1").src="/images/complite4.png";
	        	document.getElementById("zaliv2").style.background = '#080';
	        	document.getElementById('sheme2').style.display="none";
	            document.getElementById('sheme').style.display="block";
	        } else{
	        	$('.userModal .modal-title').html("<b>Произошла ошибка! Сообщение не доставлено!</b>");
	        	document.getElementById("eror1").src="/images/complite5.png";
	        	document.getElementById("zaliv2").style.background = 'red';
	        	document.getElementById('sheme2').style.display="block";
	            document.getElementById('sheme').style.display="none";
	        }          
	                  
	        document.getElementById('zaliv1').style.height=0+"%";
	        document.getElementById('zaliv2').style.height=0+"%";
	        document.getElementById('zaliv3').style.height=0+"%";
	                  
	        var block = $("#smile").clone();
	        block.css("display","inline-block");
	        $(".userModal .modal-body .send-form").html(block);
	        $(".userModal").modal('show');

	        $('.userModal').on('shown.bs.modal', function() {
	        	i1 = 1;                  
	            i2 = 1; 
	            i3 = 1;
	            iy=1;
	            ty=90;
	            $("#zaliv1").trigger('click');
	            $("#zaliv2").trigger('click');
	            $("#zaliv3").trigger('click');
	            myLoop1(); myLoop2();  myLoop3(); 
	            
	            if (result==1){
	            	setTimeout(function() {
	                	myanime ();
	                }, 600);
	                      
	            }    

        	});
           
    

	}	

 
</script>