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
	$.fn.mdi=function(options){
		
		 
	    settings = $.extend({}, arguments.callee.defaults, options);
		  _create(this);
		  

		  function _create(_self){
        $(_self).css("overflow","hidden");
		    $(_self).height($(window).height());

		    $(_self).css("width","100%");
		         
		    $(_self).css("margin","0px");
		    $(_self).css("padding","0px");
	
		    $(_self).css("position","absolute");

		    //$(_self).css("background","#638ec9");
          $(_self).css("background","#bfdbff");
  		  }
		  
        
	}
	$.fn.mdi.defaults = {
      height:'auto',
      width:'auto',
      resizeable:true
	};
})(jQuery);