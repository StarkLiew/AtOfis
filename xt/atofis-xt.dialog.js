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
    $.fn.dialog=function(options){
        
        if(options=="show"){
           $.dialog._show(this); 
           return false;
         }
         if(options=="close"){
            $.dialog._hide(this); 
           return false;
         }
        
        settings = $.extend({}, arguments.callee.defaults, options);
        $.dialog._create(this);
         
    }
    $.dialog={
       _create:function(_self){
        
          
          $(_self).addClass('xt');
          $(_self).addClass('xt-dialog');
          
          $(_self).css('padding','0px');
          $(_self).height(settings.height);
          $(_self).width(settings.width);
          if (settings.modal && !$(".xt-overlay").is("div")){
            var $modal = $("<div class='xt-overlay'></div>").appendTo("body");
            $modal.height($("body").height());
            $modal.width($("body").width());
            $modal.css('position','absolute');
            $modal.css('top','0');
            $modal.css('left','0');   
            $modal.css('z-index','15999');
            $modal.hide();     
          }
          var _content = $(_self).html();
          $(_self).html("");
          var $titlebar=$("<div class='titlebar'><div class='topleft'><div class='topright'><div class='top'></div></div></div></div>").appendTo(_self);
          $titlebar.height(31);
          $titlebar.width(settings.width);
          $titlebar.find('div').css('display','inline-block');
          //$titlebar.find('div').css('line-height','30px');
          $titlebar.find('div').css('vertical-align','top');
          $titlebar.find('div').css('margin','0px');
          $titlebar.find('.top').width(settings.width-13);

          $titlebar.find('div').height(31);
          $titlebar.find('.top').html(settings.title);
          $titlebar.find('.top').css('margin-left','7px');
          $titlebar.find('.top').css('margin-right','7px');
          $titlebar.find('.top').css('padding-top','8px');
          var $titlebutton = $("<button class='titlebutton'></button>").appendTo($titlebar.find('.top'));
          
          $titlebutton.css("float","right");
          $titlebutton.css("cursor","pointer");
       
          $titlebutton.click(function(){
              $.dialog._hide(_self);
          });
          $titlebutton.width(12);
          $titlebutton.height(12);
          
          
          var $content = $("<div class='content'><div class='inner'>"+_content+"</div></div>").appendTo(_self);
          $content.find(".inner").css("padding","2px");
          $content.css("padding","0px");
          $content.height(settings.height-32);
          $content.width(settings.width-2);
          $content.find(".inner").width($content.width()-7);
          $content.find(".inner").height($content.height()-7);
          $(_self).appendTo('body');
          $(_self).css("position","absolute");
          $(_self).css("z-index","16000");
          var $buttoncontainer = $("<div></div>").appendTo($content.find(".inner"));
          $buttoncontainer.css("text-align","center");
          $.each(settings.buttons,function(name,fn){
               var $button = $("<button></button>").appendTo($buttoncontainer);
               $button.button();
               $button.height(21);
               $button.text(name); 
               $button.bind("click",fn);
          });

          $(_self).hide();
          $(_self).draggable({initTarget:$titlebar});
          
   
          return $(_self);              
        
       },
       _show:function(_self){  
          $(_self).css("top", ( $(window).height() - $(_self).height() ) / 2+$(window).scrollTop() + "px");
          $(_self).css("left", ( $(window).width() - $(_self).width() ) / 2+$(window).scrollLeft() + "px");
          $(".xt-overlay").show();
          $(_self).show();
       },
       _hide:function(_self){
         $(".xt-overlay").hide();
         $(_self).hide();
       },
     }
    $.fn.dialog.defaults = {
      width:300,
      height:150,
      modal:false,
      title:'',
      buttons:{}     
    };
 })(jQuery);
