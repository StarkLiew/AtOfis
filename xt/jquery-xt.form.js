/*!
 * jXT 1.0.1
 *
 * Copyright (c) 2010 Kuan Yaw Liew (http://xt.atofis.com/)
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 *
 * http://xt.atofis.com/
 */


(function($){
	$.fn.accordion=function(options){
		
		 
	    settings = $.extend({}, arguments.callee.defaults, options);
		_create(this);
		

		  function _create(_self){
		  	$(_self).addClass("xt");
			  $(_self).addClass("xt-accordion");
		  	$(_self).find("h3").addClass("xt-accordion-header");
		  	$(_self).find("h3").next().addClass("xt-accordion-content");
			  $(_self).find("h3").bind("click",function(){_operation(this);});
			  $(_self).find("h3").next().hide();
			  if(settings.showOnOpen==""){
			    $(_self).find("h3:first").next().show();
			     $(_self).find("h3:first a").addClass("open");
			  } 
			  else{
			     $(_self).find("h3 a[href='"+settings.showOnOpen+"']").addClass("open");
			     $(_self).find("h3 a[href='"+settings.showOnOpen+"']").parent().next().show();
			  }
			
		  }
		  
		  function _operation(_self){
		   
               if(!$(_self).find("a").hasClass("open")){
                 $("h3 a").removeClass("open");
                 $("h3").next().slideUp();
                 $(_self).next().slideDown();
                 $(_self).find("a").addClass("open");
                 
               }		  	       
		  }

        
	}
	$.fn.accordion.defaults = {
      showOnOpen:""
      
	};
})(jQuery);