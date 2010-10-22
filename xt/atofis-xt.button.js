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
	$.fn.button=function(options){
		
	    settings = $.extend({}, arguments.callee.defaults, options);
		_create(this);
		  function _create(_obj){
		     $(_obj).each(function(){
		      var _self=$(this);
		       
		     if(!$(_self).hasClass("xt-normal-button")){
		  	  $(_self).addClass("xt");
			    $(_self).addClass("xt-normal-button");
			    $(_self).css("height",settings.height);
			    $(_self).css("width",settings.width);
			    if($.trim($(_self).attr("tooltip"))!=""){
              $(_self).tooltip({text:$(_self).attr("tooltip")});
            
          } 
			    
			    if($(_self).find("ul").is("ul")){
			       $(_self).wrap("<div></div>");
			       _self=$(_self).parent();
			       $(_self).addClass("xt");
             $(_self).addClass("xt-normal-button");
                 $(_self).css("height",settings.height);
          $(_self).css("width",settings.width);
			        $(_self).find("ul").wrap("<div class='xt xt-menu'></div>");

			       $(_self).css("display","inline-block");
			       $(_self).css("*display","inline");
			       $(_self).css("margin","0px");
			       $(_self).css("padding","0px");
			       
			       var mn = $(_self).find(".xt-menu");
			       var _btn = $(_self).find("button");

			       $(_btn).css("float","left");
			       $(_btn).css("margin","0px");
			       $(_btn).css("text-align","left");
			       $(mn).css("position","absolute");
					   $(mn).css("z-index","15000");
					     
			       $(mn).appendTo("body");
			                       
			       $(mn).hide();
			   
			    
			        $(_self).append("<span style='float:right;display:inline-block;width:10px;margin:0px;' class='xt xt-normal-button xt-button-seperator-arrow'>&nbsp;</span>");
			        $(mn).find('li').css("position","relative");
			        $(mn).find('li').css("margin","0px");
			        $(mn).find('li').css("padding","3px");
			        $(mn).find("ul").css("margin","0px");
			        $(mn).find("ul").css("padding","0px");
			        $(mn).find('li').css("list-style","none");
			        $(mn).find('li').css("z-index","15001");        
			        $(mn).css("padding","0px");
			        $(mn).find('li').addClass('xt-menu-item');		        
			        $(mn).find("li").css("list-style","none");
	
         
          
          $(_self).find("span").bind("click",{mn:mn,btn:_btn},open_menu);
        
          $(mn).find("li").bind("click",{mn:mn,btn:_btn,selected:true},close_menu);
          
          var ctop =$(_self).offset().top;
          var cleft =$(_self).offset().left;

          var btnWidth = $(_self).outerWidth();
          if($(mn).width()<btnWidth){
            $(mn).width(btnWidth);
          }
               _insertIcon(_btn);  
                  
          
			    } else {
			     
                _insertIcon(_self);
                
                
          }
  
			    }
		});
          
		  }      
      function _insertIcon(owner){
             var src=$(owner).attr("icon");
            if($.trim(src)!=''){
              $(owner).prepend('<span style="display:inline-block;width:15px;margin-right:2px;">&nbsp;</span>');
               $(owner).find('span').css("background","url("+src+") 50% 50% no-repeat")
        
          }
          return false;
      }

		  function open_menu(event){
		     var menu = event.data.mn;
		     var button = event.data.btn;
     
		     $(menu).css("top",$(button).parent().offset().top+$(button).parent().innerHeight()+"px");
         $(menu).css("left",$(button).parent().offset().left+"px");

		     $(menu).fadeIn();
		     
	        $(document).bind("click",{mn:menu,btn:button},close_menu);
         return false;
		  }  
		  
		  function close_menu(event){
		    var menu = event.data.mn;
		    var button = event.data.btn;
		    if(event.data.selected){
		       var icon = $(button).find("span");
		      $(button).text($(this).text());
		      $(button).prepend(icon);
		    }
		    $(document).unbind("click",close_menu);
		    $(menu).fadeOut();
		      return false;
		  }
		  
	}
    $.fn.button.defaults = {
      height:'auto',
      width:'auto'
  };
})(jQuery);
