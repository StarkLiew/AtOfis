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
	$.fn.toolbar=function(options){
		
	    settings = $.extend({}, arguments.callee.defaults, options);
	   	_create(this);
		  function _create(_self){
	  	   $(_self).addClass("xt");
			  $(_self).addClass("xt-toolbar");
			  $(_self).height(21);
        $(_self).css('line-height','16px');
        $(_self).css('vertical-align','middle');
        $(_self).css('white-space','nowrap');
        $(_self).css("margin","2px");
        $(_self).find(".xt-normal-button").addClass("xt-tool-button");
        $(_self).find(".xt-normal-button").css("height","18px");          
        $(_self).children().css("float","left");
        
			  $(_self).find("button").addClass("xt-tool-button");
			  $(_self).find("button").css("height","18px");  
			  (_self).find("input").height(14);  
			  $(_self).find(".seperator").addClass('xt-seperator');
        $(_self).find(".seperator").css("float",'left');
			  $(_self).find(".seperator").html("&nbsp;");
			  $(_self).find(".seperator").height(20);
			  
			  /* if(settings.docking!='none'){
		      $(_self).docking(settings.docking);
         
          if(settings.width=='auto'){
             
             $(_self).width($('body').innerWidth()*99.4/100);
          
          }
        }   */
        
          $(_self).parent().triggerHandler('resize');
		  }
         
	}
  $.fn.toolbar.defaults = {
      width:'auto',
      docking:'none'
  };
})(jQuery);
