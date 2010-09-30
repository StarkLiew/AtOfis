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
	$.fn.statusbar=function(options){
		
		 
	    settings = $.extend({}, arguments.callee.defaults, options);
		  _create(this);
		  

		  function _create(_self){
		    $(_self).addClass('xt');
		    $(_self).addClass('xt-statusbar');
		    $(_self).height(22);
		    $(_self).css({'line-height':'22px'})
		 		 if(settings.width=='auto'){
		 		   $(_self).width($("body").innerWidth()*99.9/100);
		 		   
		 		 }	 
		 		 $(_self).css('position','absolute');
		 	   //$(_self).docking('bottom');
		 		 
		  }
		  
        
	}
	$.fn.statusbar.defaults = {
      width:'auto',
      docking:'bottom',
     
	};
})(jQuery);