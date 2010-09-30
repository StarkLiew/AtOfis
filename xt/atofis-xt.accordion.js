/*!
 * AtOfis 1.0.1
 *
 * Copyright (c) 2010 Kuan Yaw, Liew (http://www.atofis.com/)
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 *
 * http://www.atofis.com/
 */

(function($){
	$.fn.accordion=function(options){
		
		 
	    settings = $.extend({}, arguments.callee.defaults, options);
		_create(this);
		

		  function _create(_self){
		  	$(_self).addClass("xt");
			  $(_self).addClass("xt-accordion");
			  $(_self).find("h3").height(19);
			  $(_self).find("h3").css("margin-top","0px");
			  $(_self).find("h3").css("margin-bottom","0px");
			  $(_self).find("h3").css("line-height","19px");
			  (_self).find("h3").next().css("margin-top","0px");
        $(_self).find("h3").next().css("margin-bottom","0px");
        $(_self).find("h3").next().css("padding","1px");
               
			  $(_self).css('z-index',"10000"); 
			  //$(_self).parent().bind("resize",{elem: $(_self)},autofit);
			  $(_self).addClass("xt-resizable");
			  var headerheight=$(_self).find("h3:first").height()+4;  
		  	$(_self).find("h3").addClass("xt-accordion-header");
		  	var countHeader=$(_self).find("h3").size()+1;
		  	$(_self).find("h3").next().addClass("xt-accordion-content");
		  	if(settings.height=='fit'){
		  	      $(_self).parent().bind("resize",{elem:$(_self).find("h3").next()},auto_resize_content);  		
	      	}else {
	      	  $(_self).find("h3").next().height(settings.height);
	      	}
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
       
			 /*var headerheight=$(_self).find("h3:last").height(); 
			 var lastindex=$(_self).find("h3:last").index();   
			 $(_self).height(((lastindex+1)*headerheight)+contentheight);*/
			 
		  }
      function auto_resize_content(event){
            var elem = event.data.elem;
            var headerheight=$(elem).parent().find("h3:first").height();  
            var countHeader=$(elem).parent().find("h3").size()+1;
        	  $(elem).height($(elem).parent().height()-(headerheight*countHeader)+10);
       
        	 }
		  function _operation(_self){
		           if(!$(_self).find("a").hasClass("open")){
                 $("h3 a").removeClass("open");
                 $("h3").next().slideUp();
                  auto_resize_content($(_self).next());
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