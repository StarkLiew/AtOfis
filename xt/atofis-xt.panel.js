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

	$.fn.panel=function(options){
		
		 
	    settings = $.extend({}, arguments.callee.defaults, options);
		  _create(this);
		  

		  function _create(_self){
		    var wrapper;
		    var content;
		    if(settings.title!=""){
		      wrapper =$('<div dock="top" style="margin:0px;padding:2px;height:22px;line-height:22px" class="xt-titlebar">'+settings.title+'</div>');
		      $(_self).prepend(wrapper);
           wrapper = _self;
		    } else wrapper=_self;	       
           
		    $(wrapper).addClass("xt");
              $(wrapper).addClass("xt-panel");

		  
		    $(wrapper).css('z-index',"1");  
		     $(wrapper).css('overflow',settings.overflow);
			  var height=0;
			  if(settings.height=="fit"){
   
          var bottomElemTall = 0;
          var topElemTall=40;

               
			    height=$(wrapper).parent().innerHeight();
        
			  }else height=settings.height;

        if(settings.height!='auto'){
        	// $(wrapper).css('overflow','hidden');
 		    $(wrapper).height(height);
        }
    	 $(wrapper).width(settings.width);
	 
        if(settings.bgcolor!=''){
          $(wrapper).css('background-color',settings.bgcolor);
        }        
		    if(settings.border!=''){
          $(wrapper).css('border',settings.border);
        }     
		     //Dock all children
	       $(wrapper).dock();
	       
	       $(wrapper).bind('resize',function(event){
	          
	            var resizeTimeout=false;
	            var $parent = $(this);
	         
	            var whenResize = function(){
	             
	                  $parent.dock(); 
	                   if(resizeTimeout){
                        clearTimeout(resizeTimeout);
                        resizeTimeout=false;
                }
	                  
	            }
	           
	           resizeTimeout=setTimeout(whenResize,10);
	            
	       });
	       if($(wrapper).css('height')=='auto'){
	         $(wrapper).css('overflow','hidden');
	         $.dock.setParentHeight(wrapper);   
	       }
        
         $(wrapper).parent().triggerHandler('resize');   
        
	          
		  }
		  

		 function whenResize(){
		   
		 }
    
     function rearrange_layout(wrapper,layout){
          switch(layout){
           case 'horizontal':
               $(wrapper).find("> div").height($(wrapper).height());
                 var totalWidth=0;
                $(wrapper).find("> div").each(function(){
                   totalWidth+=$(this).width();   
                });
                var lastElem = $(wrapper).find("> div:last")
                var lastElemWidth=$(lastElem).width();
                $(lastElem).width($(wrapper).width()-(totalWidth-lastElemWidth));
                
                break;
           case 'vertical':
     
                $(wrapper).find("> div").width($(wrapper).innerWidth());
                
                var totalHeight=0;
                $(wrapper).find("> div").each(function(){
                   totalHeight+=$(this).height();   
                   
                });
                var lastElem = $(wrapper).find("> div:last")
              
                var lastElemHeight=$(lastElem).height();
                $(lastElem).height($(wrapper).innerHeight()-(totalHeight-lastElemHeight));
                
                break;
                
                
           
         }
            return false;
       }
        
        
	}
	$.fn.panel.defaults = {
      height:'auto',
      width:'auto',
      layout:'',
      overflow:'hidden',
      bgcolor:'',
      border:'',
      title:''
	};
})(jQuery);