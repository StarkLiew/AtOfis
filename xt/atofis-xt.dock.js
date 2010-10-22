/*!
 * AtOfis 1.0.0
 *
 * Copyright (c) 2010 Kuan Yaw Liew (http://www.atofis.com/)
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 *
 * http://www.atofis.com/
 */
(function($){
  var $me;
  var $parent;
  var dockoption;
  var isresizing=false;
  var isresizing_elem=false;

  var parentAutoHeight=false;
  $.fn.dock=function(){  
     $parent = $(this);
     $.dock.dockNow();

  },

  $.dock={

     dockNow: function(){
       $.dock.resizeBody();

       $parent.find('> *').each(function(){
          $me = $(this);
          dockoption=$me.attr('dock');
         
          if(dockoption=='') return false;
          
          
          
          $me.attr('originWidth',$me.width());
          $me.attr('originHeight',$me.height());
               
           $me.css('position','absolute');     
           
           
           switch(dockoption){
              case 'none':
                 
                    if($me.css('position')=='absolute'){
           
                      $me.css('position','');
                      $me.css("z-index","14999");
                      $me.width($me.attr('originWidth'));
                      $me.height($me.attr('originHeight'));
                     $me.triggerHandler('resize');
                    }
                    break;
              case 'fill':
                    
                    $me.css("z-index","14999");
                    var sizes=$.dock.setDockingSize();
                    $me.css('top',sizes.top);
                    $me.css('left',sizes.left);
                    var marginsizet= $me.outerWidth(true)-$me.outerWidth();
                    var bordersizet= $me.outerWidth()-$me.innerWidth();
                    var marginsizel= $me.outerHeight(true)-$me.outerHeight();
                    var bordersizel= $me.outerHeight()-$me.innerHeight();
                    var paddingsizet= $parent.outerWidth()-$parent.innerWidth()+1;
                    var paddingsizel= $parent.outerHeight()-$parent.outerHeight()+1;
                    $me.width($parent.innerWidth()-marginsizet-sizes.left-sizes.right-bordersizet-paddingsizet);
                    $me.height($parent.innerHeight()-marginsizel-sizes.top-sizes.bottom-bordersizel-paddingsizel);
                    $me.triggerHandler('resize');
                  
                    
                    break;
              case 'top': 

                    var sizes=$.dock.setDockingSize();
                    $me.css('top',sizes.top);
                    $me.css('left',sizes.left);
                    var marginsize= $me.outerWidth(true)-$me.outerWidth();
                    var paddingsize= $parent.outerWidth()-$parent.innerWidth()+1;
                    var bordersize= $me.outerWidth()-$me.innerWidth();             
                    $me.css("z-index","14999");
                   
                    $me.width($parent.innerWidth()-marginsize-sizes.left-sizes.right-bordersize-paddingsize);
                     $me.triggerHandler('resize');
                    
                    break;
              case 'bottom':
     
                    var sizes=$.dock.setDockingSize();
                    $me.css('top',$parent.innerHeight()-$me.outerHeight(true)-sizes.bottom);
                    $me.css('left',sizes.left);
                    var bordersize= $me.outerWidth()-$me.innerWidth();
                    var marginsize= $me.outerWidth(true)-$me.outerWidth();  
                      var paddingsize= $parent.outerWidth()-$parent.innerWidth()+1;
                    $me.css("z-index","14999");
                    $me.width($parent.innerWidth()-marginsize-sizes.left-sizes.right-bordersize-paddingsize);
                    $me.triggerHandler('resize');
        
                    break;
              case 'left':
  
                    var sizes=$.dock.setDockingSize();
                    var marginsize= $me.outerHeight(true)-$me.outerHeight();  
                    var bordersize= $me.outerHeight()-$me.innerHeight();
                    var paddingsize= $parent.outerHeight()-$parent.innerHeight()+1;
                    $me.css("z-index","14999");
                    $me.css('left',sizes.left);
                    $me.css('top',sizes.top);
                    $me.height($parent.innerHeight()-sizes.bottom-sizes.top-bordersize-paddingsize);
                      $me.triggerHandler('resize');
                    break;
              case 'right':

                     var sizes=$.dock.setDockingSize();   
                     var marginsize= $me.outerHeight(true)-$me.outerHeight();
                     var bordersize= $me.outerHeight()-$me.innerHeight();
                     var paddingsize= $parent.outerHeight()-$parent.innerHeight()+1;
                     $me.css('top',sizes.top);                        
                     $me.css('left',$parent.innerWidth()-$me.outerWidth(true)-sizes.right);
                     $me.height($parent.innerHeight()-sizes.bottom-sizes.top-bordersize-paddingsize);
                     $me.triggerHandler('resize');
                     break;
           }
      

      }); 


             


            if(isresizing){
                   clearTimeout(isresizing);  
                   isresizing=false;
              }
    
                
     },
     setParentHeight: function(parent){
             if(parent) $parent = $(parent);
             var totalDockChildHeight = 0;
             $parent.children("*[dock='top']").each(function(){
                  totalDockChildHeight+=$(this).outerHeight(true);
             });
            $parent.children("*[dock='bottom']").each(function(){
                 totalDockChildHeight+=$(this).outerHeight(true);
             });
             $parent.height(totalDockChildHeight);
             return false;
             
     },
     me_resize:function(){
             $parent=$(this);
             if(isresizing){
                   clearTimeout(isresizing);  
                   isresizing=false;
              }
             isresizing=setTimeout($.dock.dockNow,10);   
      
     },
     resizeBody: function(){

      if($parent.is('body')){
        
         $parent.css('margin','0px');
         $parent.css('padding','0px');
         $parent.css('overflow','hidden');
         var scrollWidth = document.body.scrollWidth;
         var scrollHeight = document.body.scrollHeight;
         var scrollbarsize = $.dock.getScrollbarSize();
         var wWidth =$(window).width();
         var wHeight=$(window).height();
         if(wWidth==scrollWidth) wWidth = wWidth-1; 
         if(wHeight==scrollHeight) wHeight = wHeight-1;
         $parent.width(wWidth);
         $parent.height(wHeight);
       if(!isresizing){
         $(window).bind('resize',function(event){
               $parent=$('body');
               if(isresizing){
                   clearTimeout(isresizing);  
                   isresizing=false;
              }
             
              isresizing=setTimeout($.dock.dockNow,10);                
                    
         });}
   
         //$parent.css('overflow','auto');
         parentAutoHeight=false;
     }else{
       
        if($parent.css('height')=='auto') parentAutoHeight = true;
        else parentAutoHeight = false;
     }

     },
     setDockingSize: function(){
         
         var topHeights =0;
         var bottomHeights =0;
         var leftWidths =0;
         var rightWidths =0;

         $me.prevAll("*[dock='top']").each(function(){      
               topHeights += $(this).outerHeight();
         });
         $me.prevAll("*[dock='bottom']").each(function(){
               bottomHeights += $(this).outerHeight();   
         });
         $me.prevAll("*[dock='left']").each(function(){
               leftWidths += $(this).outerWidth();   
         });
         $me.prevAll("*[dock='right']").each(function(){
               rightWidths += $(this).outerWidth();   
         });
         
         return {top:topHeights,bottom:bottomHeights,left:leftWidths,right:rightWidths};
     },
      getScrollbarSize: function(){
        var $inner = $('<p></p>').css({width:'100%',height:'100%'});
        var $outer = $('<div></div>')
          .css({
            position:'absolute',
            top: '0px',
            left: '0px',
            visibility: 'hidden',
            width: '200px',
            height: '150px',
            overflow: 'hidden'
          })
          .append($inner)
          .appendTo('body');
        
        var w1 = $inner.innerWidth();
        $outer.css('overflow','scroll');
        var w2 = $inner.innerWidth();
        if (w1 == w2) w2 = $outer.innerWidth();
        $outer.remove();
        return(w1 - w2);
    },
    docked: function(){
        
    }
  }
 
  
    
})(jQuery);