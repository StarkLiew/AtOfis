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
	$.fn.tab=function(options){
		
		 
	  settings = $.extend({}, arguments.callee.defaults, options);
		_create(this);
		

		  function _create(_self){
		  	$(_self).addClass("xt");
			  $(_self).addClass("xt-tab");
			  $(_self).width(settings.width);
			  $(_self).height(settings.height);
			  $(_self).css("padding","3px");
			  $(_self).find("ul").height(22);
			  $(_self).find("ul").css("margin","0px");
			  $(_self).find("ul").css("margin-left","5px");
			  $(_self).find("ul").css("padding","0px");

			  $(_self).find("li").css("display","inline-block");
			  $(_self).find("li").css("padding","0px");
			  $(_self).find("li a").css("margin","0px");
			  $(_self).find("li span").css("margin","0px");
			  $(_self).find("li span").css("margin-left","6px");
			  $(_self).find("li span").css("margin-right","6px");
			  $(_self).find("li span").css("line-height","23px");
			  $(_self).find("li span").css("vertical-align","middle");
			  $(_self).find("li").height(23);
			  $(_self).find("li a").css("display","inline-block");
			  $(_self).find("li span").css("display","inline-block");
			  $(_self).find("li a").height(23);
        $(_self).find("li span").height(23);
			  $(_self).find("li").each(function(e){
			       var _tablength=$(this).find("span").width()+6;
			       $(this).width(_tablength);
			  });
			   $(_self).find("li").css("margin-left","1px");
			   $(_self).find("li:eq("+settings.showTab+")").addClass("active");
			   $(_self).find("div").addClass("xt-tab-content");
			   var _ajaxTab=$("<div id='xt-ajaxTab' class='xt-tab-content'></div>").appendTo(_self);
			   $(_ajaxTab).hide();
			   $(_self).find("div").hide();
			   $(_self).find("div").css("margin-top","0.9px");
			   $(_self).find("div").css("padding","5px");
			   $(_self).find("div").width(settings.width-12);
			   $(_self).find("div").height(settings.height-34);
			   $(_self).find("div:eq("+settings.showTab+")").show();
			   $(_self).find("li").bind("click",tab_click);
        
	 }
	 function tab_click(){
	   	if(!$(this).hasClass("active")){
	   	   $(this).parent().find(".active").removeClass("active");
	   	   $(this).addClass("active");
	   	   $(this).parents(".xt-tab").find("div").hide();
	   	   if ($($(this).find("a").attr("href")).is("div")) $(this).parents(".xt-tab").find($(this).find("a").attr("href")).show();
	   	   else{
	   	       $("#xt-ajaxTab").show();
	   	       var callback = $(this).find("a").attr("href");
	   	      $("#xt-ajaxTab").load(callback);

	   	   }
	   	   
	   	  
	   	}   
	   	 return false;
	 }
	}
	
	$.fn.tab.defaults = {
      showTab:1,
      width:300,
      height:100
	};
})(jQuery);
