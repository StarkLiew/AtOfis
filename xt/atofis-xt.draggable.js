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
    var $self;
    var isMouseDown=false;
    var lastMouseX;
    var lastMouseY;
    var lastElemTop;
    var lastElemLeft;

    $.fn.draggable=function(options){
         $self = $(this);

         settings = $.extend({}, $.fn.draggable.defaults, options);
         $.draggable._set();        
    }
    $.draggable={
    
     _getCursorPos: function(e){
     var posx = 0;
     var posy = 0;

     if (!e) var e = window.event;

     if (e.pageX || e.pageY) {
      posx = e.pageX;
      posy = e.pageY;
     }
      else if (e.clientX || e.clientY) {
       posx = e.clientX + document.body.scrollLeft + document.documentElement.scrollLeft;
       posy = e.clientY + document.body.scrollTop  + document.documentElement.scrollTop;
      }

      return { 'x': posx, 'y': posy };

      },
      _setPos: function(e){
           var pos = $.draggable._getCursorPos(e);
           
           var spanX = (pos.x - lastMouseX);
            var spanY = (pos.y - lastMouseY);

           $self.css("top",  (lastElemTop + spanY));
           $self.css("left", (lastElemLeft + spanX));

      },
       _set: function(){ 
         // retrieve positioning properties


           if(settings.initTarget!=''){
             $(settings.initTarget).css("cursor", "move");
            $(settings.initTarget).bind('mousedown',$.draggable._mousedown);
           } else {
             $(this).css("cursor", "move");
             $self.bind('mousedown',$.draggable._mousedown);
           }
           return false;
       },
       _mousedown: function(e){
              isMouseDown = true;
              lastElemTop  = this.offsetTop;
              lastElemLeft = this.offsetLeft;
               var pos    = $.draggable._getCursorPos(e);
              lastMouseX = pos.x;
              lastMouseY = pos.y;

              lastElemTop  = $(this).offset().top;
              lastElemLeft = $(this).offset().left;

               $self.bind('mousemove',$.draggable._mousemove);
               $(this).bind('mouseup',$.draggable._mouseup);  
             
   
       },
       _mouseup: function(){
         isMouseDown=false;
         $self.unbind('mousemove',$.draggable._mousemove);
         $(this).unbind('mouseup',$.draggable._mouseup);

       },
       _mousemove: function(e){
           if(isMouseDown){
           
             $.draggable._setPos(e);
           }
         
    
       },

    }
    $.fn.draggable.defaults = {
        initTarget:'',

    }
})(jQuery);