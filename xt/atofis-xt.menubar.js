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
	$.fn.menubar=function(options){	
	    settings = $.extend({}, arguments.callee.defaults, options);
	   	_create(this);
		  function _create(_self){
		    	    
		    var _menu = $(_self);
		    $(_menu).addClass("xt");
        $(_menu).addClass("xt-menubar");
        $(_menu).height(15);
        $(_menu).css("padding","2px");
        $(_menu).css("margin","2px");
          if(settings.docking!='none')
          $(_menu).docking(settings.docking);
        
     switch (settings.datatype){
       case 'xml':

              _createMenubar(_menu,settings.data);
                break;

       case 'json':
             break;
              //_createMenubar(_menu,settings.data,data);
       
       case 'html':
            //_createMenubar(_menu,settings.data);
            break;
     }
     
    
  

		  } 

	}
	  function _createMenubar(_menu,data){
	               var menus = $(data).find("menus");
                 $(menus).find("> *").each(function(){
                        var menuitem=$("<div id='"+$(this).attr("id")+"' style='display:inline' class='xt-menu-item'>"+$(this).attr("title")+"</div>").appendTo(_menu);
                        $(menuitem).css("padding","2px");
                     
                        $(menuitem).css("margin","1px");
                        if($(this).attr("disabled")) $(menuitem).addClass("disabled");
                       if($(this).attr("title")=="-"){
                         $(menuitem).addClass("seperator");
                         $(menuitem).html("");
                       } 
               
                      if($(this).contents().size()>0){
                        var submenu=$("<div id='submenu_"+$(this).attr("id")+"' style='width:130px;padding:0px;position:absolute;z-index:15001' class='xt xt-menu'></div>").appendTo("body");
                        $(menuitem).bind("click",{sub:submenu},open_submenu);
                        
                        $(submenu).css("top",$(menuitem).offset().top+$(menuitem).height()+5+"px");
                        $(submenu).css("left",$(menuitem).offset().left+"px");
                        _createSubMenu(submenu,$(this));
                        $(submenu).hide();
                     }    
                 });
                 return false;
	    
	  }
	  function _createSubMenu(menu,data,nohoverclose){
	      $(data).find("> *").each(function(){
	      
           var menuitem=$("<div class='xt-menu-item'>"+$(this).attr("title")+"</div>").appendTo(menu);
           $(menuitem).css("padding","2px");
           $(menuitem).css("margin","0px");
              $(menuitem).css("padding-left","16px");
           if($(this).attr("disabled")) $(menuitem).addClass("disabled");
          if($(this).attr("title")=="-"){
                         $(menuitem).addClass("seperator");
                         $(menuitem).html("");
                       } 
           
           if($(this).contents().size()>0){
               
             var submenu=$("<div style='width:130px;padding:0px;position:absolute;z-index:15001' class='xt xt-menu'></div>").appendTo("body");
             $(menuitem).addClass("arrow");
             $(menuitem).bind("mouseover",{sub:submenu,parentvisbile:true},open_submenu);
             $(menuitem).bind("click",{sub:submenu,parentvisbile:true},open_submenu);
             
             $(submenu).css("top",$(menuitem).parent().offset().top+"px");
             $(submenu).css("left",$(menuitem).parent().offset().left+$(menuitem).parent().width()+2+"px");
             $(submenu).hide();
             _createSubMenu(submenu,$(this),true);
              
           }else{
             if(!nohoverclose){
               $(menuitem).bind("mouseover",hover_close_submenu);
             }
           } 
           
           
           
        });
	  }
	  function open_submenu(event){
	       //Close other manual except myself or my parent
       if(!event.data.parentvisbile){
         var cidx=$(this).parent().attr('id');
         $(".xt-menu").each(function(){
            var idx=$(this).attr('id');
            if(idx!=cidx) $(this).fadeOut();
         });
	      }
	       $(document).bind("click",close_submenu);
         var submenu = event.data.sub;
         $(submenu).fadeIn();
        
         return false;
      }  
     function hover_close_submenu(event){

         var cidx=$(this).parent().attr('id');
         $(".xt-menu").each(function(){
            var idx=$(this).attr('id');
            if(idx!=cidx) $(this).fadeOut();
         });
          return false;
      }
      
      function close_submenu(event){
        $(document).unbind("click",close_submenu);
        $(".xt-menu").fadeOut();
          return false;
      }
  $.fn.menubar.defaults = {
      width:'auto',
      docking:'none',
      data:{},datatype:'html'
      
  };
})(jQuery);
