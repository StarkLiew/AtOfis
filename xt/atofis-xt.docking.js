/*!
 * AtOfis 1.0.1
 *
 * Copyright (c) 2010 Kuan Yaw Liew (http://www.atofis.com/)
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 *
 * http://www.atofis.com/
 */


(function($){
  $.fn.docking=function(options){
    
    

    
     switch(options){
       case 'top':
              
                $(this).css('position',"absolute");
                  $(this).css("z-index","14999");
                $(this).width($(this).parent().width());
                 $(this).css('top',getTopDockingElemHeight());
                 $(this).addClass('xt-top');
                 
               break;
       case 'bottom':
               $(this).addClass('xt-bottom');
               $(this).css("z-index","14999");
               $(this).css('top',$(this).parent().height()-$(this).height());
                $(this).width($(this).parent().width());
               $(this).css('left',0); 
               break;
       case 'left':
    	 
               $(this).css('position','absolute');
               $(this).css("z-index","13000");
               $(this).css('left',getLeftDockingElementWidth());
               $(this).css('top',getTopDockingElemHeight()+2);
               $(this).addClass('xt-left'); 
               var height=$(this).parent().height()-(getTopDockingElemHeight()+getBottomDockingElemHeight())-5; 
               $(this).height(height);
               $(this).trigger("resize");
                      //resize height for last element only that has xt-resizable class
            
               
              
                break;
       case 'right':
               $(this).css('position','absolute');
               $(this).css("z-index","13000");
               $(this).css('top',getTopDockingElemHeight()+2);
               $(this).css('margin-right','5px');
               $(this).css('left',$("body").width()-($(this).width()+getRightDockingElementWidth())-2);    
               $(this).addClass('xt-right');
               $(this).height($(this).parent().height()-(getTopDockingElemHeight()+getBottomDockingElemHeight())-5);
          
               break;
       case 'center':

              $(this).css('position','absolute');    
              
              var leftElemWidth=0;
              var rightElemWidth=0;   
              leftElemWidth=getLeftDockingElementWidth();
              rightElemWidth=getRightDockingElementWidth();
              $(this).css('top',getTopDockingElemHeight()+2);
              $(this).css('left',getLeftDockingElementWidth()+5);
              $(this).width($(this).parent().width()-(getLeftDockingElementWidth()+getRightDockingElementWidth())-12);
              $(this).height($(this).parent().height()-(getTopDockingElemHeight()+getBottomDockingElemHeight())-5);
               $(this).css("z-index","13000");
         
               break;
     }

     

  }

  
  
  function getTopDockingElemHeight(){
          var topElemTall=0;
          $('.xt-top').each(function(i){
              topElemTall+=$(this).height();
           });
           return topElemTall;
  }

  function getBottomDockingElemHeight(){
        var bottomElemTall=0;
        $('.xt-bottom').each(function(i){
               bottomElemTall+=$(this).height();
         });
         return bottomElemTall;  
  }
  function getLeftDockingElementWidth(){
        var leftElemWidth=0;
        $('.xt-left').each(function(i){
               leftElemWidth+=$(this).width();
         });
         return leftElemWidth+5;  
  }
  function getRightDockingElementWidth(){
        var rightElemWidth=0;
        $('.xt-right').each(function(i){
               rightElemWidth+=$(this).width();
         });
         return rightElemWidth+5;  
  }
 function getRightDockingElementHeight(){
        var rightElemHeight=0;
        $('.xt-right').each(function(i){
               rightElemHeight+=$(this).height();
         });
         return rightElemHeight;  
  }
  function getRightDockingElementHeight(){
        var rightElemHeight=0;
        $('.xt-right').each(function(i){
               rightElemHeight+=$(this).height();
         });
         return rightElemHeight;  
  }
   function getCenterDockingElementHeight(){
        var centerElemHeight=0;
        $('.xt-center').each(function(i){
               centerElemHeight+=$(this).height();
         });
         return centerElemHeight;  
  }
   function getCenterDockingElementWidth(){
        var centerElemWidth=0;
        $('.xt-center').each(function(i){
               centerElemWidth+=$(this).width();
         });
         return centerElemWidth;  
  }

})(jQuery);


