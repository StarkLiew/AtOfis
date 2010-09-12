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
	$.fn.panel=function(options){
		
		 
	    settings = $.extend({}, arguments.callee.defaults, options);
		  _create(this);
		  

		  function _create(_self){
		    var wrapper;
		    var content;
		    if(settings.title!=""){
		      $(_self).wrap("<div id="+$(_self).attr('id')+"></div>");
		      $(_self).attr('id','');
		         content=_self;
             wrapper=$(_self).parent();
             $(wrapper).prepend('<div style="height:22px;line-height:22px" class="xt-titlebar">'+settings.title+'</div>');
             var titlebar=$(wrapper).find('.xt-titlebar');
             $(wrapper).bind('resize',{titlebar:titlebar,content:content,layout:settings.layout},auto_resize);
		    } else wrapper=_self;
		      
           
		    $(wrapper).addClass("xt");
              $(wrapper).addClass("xt-panel");

		  
		    $(wrapper).css('z-index',"1");  
		     $(wrapper).css('overflow','hidden');
			  var height=0;
			  if(settings.height=="fit"){
   
          var bottomElemTall = 0;
          var topElemTall=40;

               
			    height=$(wrapper).parent().height();
  
			  }else height=settings.height;

        if(settings.height!='auto'){
        	 $(wrapper).css('overflow','hidden');
 		  
 		    $(wrapper).height(height);
        }
    	$(wrapper).width(settings.width);
	
        if(settings.bgcolor!=''){
          $(wrapper).css('background-color',settings.bgcolor);
        }        
		    if(settings.border!=''){
          $(wrapper).css('border',settings.border);
        }     
		    
		  	/*if(settings.docking!='none'){
		  	  $(wrapper).docking(settings.docking);
		  	 
		  	}			*/
		 //   $(_self).bind('resize',resize_lastchildren);
		  }
		/*  function resize_lastchildren(event){
		          var lastchild=$(this).find(":last-child"); 
		          lastchild.height($(this).height()-2);
		          $(this).children().width($(this).width());
		          
		  }*/
     function auto_resize(event){
       var titlebar =event.data.titlebar;
       var content = event.data.content;
       var layout = event.data.layout;
       $(content).height($(this).height()-$(titlebar).height());
       $(content).width($(this).width());

       if(layout!="") rearrange_layout(content,layout);
        $(content).triggerHandler('resize');
        return false;
     };
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
     
                $(wrapper).find("> div").width($(wrapper).width()-2);
                
                var totalHeight=0;
                $(wrapper).find("> div").each(function(){
                   totalHeight+=$(this).height();   
                   
                });
                var lastElem = $(wrapper).find("> div:last")
              
                var lastElemHeight=$(lastElem).height();
                $(lastElem).height($(wrapper).height()-(totalHeight-lastElemHeight));
                
                break;
                
                
           
         }
            return false;
       }
        
        
	}
	$.fn.panel.defaults = {
      height:'auto',
      width:'auto',
      layout:'',
      bgcolor:'',
      border:'',
      title:''
	};
})(jQuery);