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
	$.fn.tooltip=function(options){
		
		if(options=="destroy"){
		  _destory(this);
		  return false;
		}
		
	   settings = $.extend({}, arguments.callee.defaults, options);
     
     
          
		_create(this);

		  function _create(_self){
		   var tip=$("<div class='xt xt-tooltip' style='position:absolute;z-index:50000;'>"+settings.text+"</div>").appendTo("body");

			 $(_self).bind("mouseover",{tip:tip,owner:_self},_showTooltip);
       $(_self).bind("mouseout",{tip:tip,owner:_self},_closeTooltip);
   
	
		  }
		  function _destory(_self){
  
         $(_self).trigger("mouseout",[true]);
         return false;
		    
		  }
		  function _showTooltip(event){
		       var _tip =event.data.tip;
		       var _owner = event.data.owner;
	         var ctop = $(_owner).offset().top;
           var cheight = $(_owner).height();
           var cwidth = $(_owner).width();
           var cleft = $(_owner).offset().left;
      
             $(_tip).css("top",ctop+cheight+16+"px");
             $(_tip).css("left",cleft+cwidth+"px");
           	            
             $(_tip).show();
             return false;         		  	       
		  }
		  function _closeTooltip(event,calldestroy){
          
		         if(calldestroy){
		          var _tip =event.data.tip;
		          var _owner = event.data.owner;
		          $(_tip).remove();
		           $(_owner).unbind("mouseover",_showTooltip);
               $(_owner).unbind("mouseout",_closeTooltip);   
		           return false;
		         }
             $(event.data.tip).hide();    
             return false;     		  	       
		  }
	}

	$.fn.tooltip.defaults = {
	     text:""
	};
})(jQuery);