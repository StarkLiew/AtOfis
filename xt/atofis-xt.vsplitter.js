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
	$.fn.vsplitter=function(options){	
       settings = $.extend({}, $.fn.vsplitter.defaults, options);

       $.vsplitter.create(this,settings);
  }
  var currentX;
  var $fill;
  var resizeTimeout;
  $.vsplitter={
    create: function(_self,settings){
       $me = $(_self);

          
        var i = 0;
        var childsize = $me.children().size()-1;
        var $fill;
       $me.children('div').each(function(){
           var $child = $(this);          
           $child.attr('dock','left');
           $child.height($me.innerHeight());
           $child.width(settings.columnWidth[i]);
           var $splitter = $('<div></div>');
          
           if(i==settings.fixed-1){
              $child.attr('dock','left');       
           }else{
              $fill = $child;
              $child.attr('dock','fill');
           }
           
           if(i==childsize){
    
             return false;
           }
        
           i+=1;

           $splitter.addClass('xt-spliter');
           $splitter.attr('dock','left');
           $splitter.css('display','inline-block');
           $splitter.css('padding','0px');      
           $splitter.css('margin','0px');
           $splitter.css('cursor','col-resize');

           $splitter.bind('mousedown',function(event){

              $(this).css('cursor','col-resize');
              currentX = event.pageX;
              $(this).parent().bind('mousemove',{target:this},$.vsplitter.spliting);
              return false;
            });
           $splitter.bind('mouseup',function(){

              $(this).parent().unbind('mousemove',$.vsplitter.spliting);
              return false;
           });
           
           $(this).after($splitter);
           
       });
       
      $me.dock();

     
      $me.bind('resize',function(event){
            
              var resizeTimeout=false;
              var $parent = $(this);
           
              var whenResize = function(){
               
                     $parent.dock(); 
                     if(resizeTimeout){
                        clearTimeout(resizeTimeout);
   
                        resizeTimeout=false;
                }
                    
              }
             
             resizeTimeout=setTimeout(whenResize,10);
              
         });
 

    },
    
    spliting: function(event){
            var $this = $(event.data.target);
             
             if(event.pageX>$this.parent().offset().left && event.pageX>$this.outerWidth(true)){
                  
                   var rate = (event.pageX)-($this.next().offset().left); //drag rate
                   var size =event.pageX+($this.position().left-$this.next().width());
                   if(event.pageX-$this.parent().offset().left>currentX){
                      
                 
                    if($this.next().width()<=20){
                      $this.triggerHandler('mouseup');
                      return false;
                    } 
                     
                     $this.prev().width($this.prev().width()+rate+$this.outerWidth());
                     $this.next().width($this.next().width()-rate-$this.outerWidth());
                     $this.next().css('left',(event.pageX+$this.outerWidth())-$this.parent().offset().left); 
                   }
                  if(event.pageX-$this.parent().offset().left<currentX){
                    
                    if($this.prev().width()<=20) {
                      $this.triggerHandler('mouseup');
                      return false;
                    } 
               
                    $this.next().width($this.next().width()-rate-$this.outerWidth());
                    $this.prev().width($this.prev().width()+rate+$this.outerWidth());
                    $this.next().css('left',(event.pageX+$this.outerWidth())-$this.parent().offset().left);
                    
                      
                   }
                 
                    $this.css("left",event.pageX-$this.parent().offset().left);

                    $this.prev().triggerHandler('resize');
                    $this.next().triggerHandler('resize');
                    
                    currentX=event.pageX-$this.parent().offset().left;
                   
             }
            

    }
   
  }    
  $.fn.vsplitter.defaults = {
     
  };
})(jQuery);
