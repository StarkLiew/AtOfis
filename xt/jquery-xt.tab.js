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
			  $(_self).find("h3").height(19);
			  var headerheight=$(_self).find("h3:first").height();  
		  	$(_self).find("h3").addClass("xt-accordion-header");
		  	var countHeader=$(_self).find("h3").size()+1;
		  	$(_self).find("h3").next().addClass("xt-accordion-content");
		  	if(settings.height=='fit'){
		  	    $(_self).find("h3").next().height($(_self).parent().height()-(headerheight*countHeader));
		  	}else $(_self).find("h3").next().height(settings.height);
			  $(_self).find("h3").bind("click",function(){_operation(this);});
			  $(_self).find("h3").next().hide();
			   var contentheight=0;
			  if(settings.showOnOpen==""){
			    $(_self).find("h3:first").next().show();
			     $(_self).find("h3:first a").addClass("open");
			     //contentheight=$(_self).find("h3:first").next().height();
			  } 
			  else{
			     $(_self).find("h3 a[href='"+settings.showOnOpen+"']").addClass("open");
			     $(_self).find("h3 a[href='"+settings.showOnOpen+"']").parent().next().show();
			     //contentheight=$(_self).find("h3 a[href='"+settings.showOnOpen+"']").parent().next().height();
			  }

			 //var headerheight=$(_self).find("h3:last").height(); 
			 //var lastindex=$(_self).find("h3:last").index();
			 
			   
			 //$(_self).css("height",(((lastindex+1)*headerheight)+contentheight));
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
      showOnOpen:"",
      height:200,

	};
})(jQuery);