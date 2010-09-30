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
  var isNumberOnly;
  var isDateOnly;
  var isRequired;
  var settings;
	$.fn.textbox=function(options){
		
		 
	    settings = $.extend({}, $.fn.textbox.defaults, options);
	    //$.data(this,'watermark',settings.watermark);
	    isNumberOnly=settings.number;
	    isDateOnly=settings.date;
	    isRequired=settings.required;
	    //$.data($(this),'errormsg',settings.errormsg);
	     
	   	$.textbox._create(this);
		}
		
  $.textbox={
		  _create: function (_self){
		    
		  if(!$(_self).hasClass("xt"))$(_self).addClass("xt");
			if(!$(_self).hasClass("xt-textbox")) $(_self).addClass("xt-textbox");
      
      var   _pass = $(_self);
			if(settings.watermark!=''){
			      if($(_self).attr('type')=='password'){
	                 //tranform my self to become text
			        $(_self).before("<input id='decoy' value='"+settings.watermark+"' style='"+$(_self).attr('style')+"' class='"+$(_self).attr('class')+" xt-watermark' haspassword='true' readonly='true' />");
			        var _decoy = $(_self).prev();
			        $(_decoy).css('margin','2px');
			        $(_decoy).bind('focus',$.textbox.watermark_focus);
              $(_self).bind('blur',{watermark:settings.watermark},$.textbox.watermark_blur);
 
			         //_self=$(_decoy);
			         
			         $(_pass).hide();     
			      }else{
			        $(_self).addClass('xt-watermark');
              $(_self).val(settings.watermark); 
                  
              $(_self).bind('focus',$.textbox.watermark_focus);
              $(_self).bind('blur',{watermark:settings.watermark},$.textbox.watermark_blur);
              
			      }
			    
		        
			}
			
	   if(isDateOnly){
         $dropdown=$("<div></div>").appendTo("body");
         $wrapper=$("<div></div>");
        

         $wrapper.addClass('xt');
         $wrapper.addClass('xt-textbox');
         $wrapper.height($(_self).innerHeight());
        
         $wrapper.css('display','inline-block');
         $wrapper.attr('style',$(_self).attr('style'));
         $wrapper.css('padding','0px');
         $(_self).wrap($wrapper);
         $(_self).attr('style','none');
         $(_self).css('background','');
         $(_self).css('margin','0px');
         $(_self).css('background-color','transparent');
         $(_self).css('border','none');
         
         
         $dropdown.calendar({showtodaybutton:true,local:settings.datelocal,type:'dropdown',target:$(_self)});
         
         $(_self).attr('localdate',settings.datelocal);
         $select = $("<button><span style='width:9px;height:6px;display:inline-block'>&nbsp;</span></button>");
         $select.button();
         $select.height($(_self).outerHeight());
         $select.css("margin","0px");
         $(_self).after($select);
         $(_self).css("margin-right","0px");
         $select.css("margin-left","0px");
         $select.bind("click",{dropdown:$dropdown,target:_self},$.textbox._dropdownCalendar);
         
      }

			  if(isNumberOnly || isRequired || isDateOnly){
			     $(_self).bind("change blur",{setting:settings},$.textbox._validate);
			     if(isNumberOnly) $(_self).css("text-align","right");
		    }
		    
			  $(_self).parents("form").bind('submit',$.textbox.custom_submit);
			   
		  },
	
		   _validate:function(event){
		    var _self=$(this);
		    var hasError = false;  
		    var setting = event.data.setting;
		    var errormsg = event.data.setting.errormsg;
        isNumberOnly=setting.number;
        isDateOnly=setting.date;
        isRequired=setting.required;
		   
		   if(isDateOnly){
		      var val = "";
          if(!$(_self).hasClass('xt-watermark'))  val =$(_self).val();
    
            if(val!=""){
                 if (!$.calendar.isdate(val, $(_self).attr('localdate'))) {
              
              hasError=true;
              $.textbox._showerror($(this).parent(),errormsg.date);
             }
          }
         }  
       if(isNumberOnly){
			   	
			   	if (!$.textbox._isnumber($(_self).val(), _self)) {
			   		hasError=true;
			   	   
				 		$.textbox._showerror(this,errormsg.number);
    				 }

			   }	
			 
       if(isRequired){ 
         var val = "";
         if(!$(_self).hasClass('xt-watermark'))  val =$(_self).val();
         if (val=="" ) {
          hasError=true;
       
        $.textbox._showerror(this, errormsg.required);
         }
       }    
		 	if(hasError) return false;
		 	if(isDateOnly) _self=$(_self).parent();
		 	if($(_self).hasClass("error")){
		 	    
			    $(_self).removeClass("error");
			    var err=$(_self).next('.xt-error-img');
			    if($(_self).attr('type')=='password') $(_self).prev('.xt-watermark').removeClass("error");
			    $(err).tooltip("destroy");
			    $(err).remove();
		 	}
	
		  },
     watermark_focus: function(event){
               
               $.textbox._clearWatermark(this);
               return false;
      },

     watermark_blur:function(event){
         
          if($(this).val()==""){
                     if($(this).attr("type")=="password"){
                 
                $(this).prev().show();
                $(this).hide();
                  return false;
              }  
             $(this).addClass('xt-watermark');
             $(this).val(event.data.watermark);
          }
           
          return false;
      },
  	 custom_submit:function(event){
  		  
		 //revalidate all input
  	 $(this).find('input').trigger('change');
		 if($(this).find('.error').size() > 0) return false;
		 
		 $(this).find('.xt-watermark').each(function(){
			 $(this).val('');
		 });

	  },
	  _showerror:function(elem,text,decoy){
	    if($(elem).hasClass("error")) return false;	//Get out if you have error
		$(elem).addClass("error");
		if($(elem).attr('type')=='password') $(elem).prev('.xt-watermark').addClass("error");
		$(elem).after("<span style='width:18px;display:inline-block;' class='xt-error-img'>&nbsp;</span>");
		$(elem).next().css("margin",$(elem).css("margin"));
		$(elem).next().css("margin-left","1px");
		$(elem).next().css("padding",$(elem).css("padding"));
		$(elem).next().height($(elem).height());
		$(elem).next().tooltip({text:text});
	},
	  _isnumber: function(value, elemen){return /^-?(?:\d+|\d{1,3}(?:,\d{3})+)(?:\.\d+)?$/.test(value);},
	  
	  _clearWatermark:function(elem){
	        if($(elem).hasClass('xt-watermark')){
	          if($(elem).attr("haspassword")){     
                $(elem).next().show();
                $(elem).next().focus();
                $(elem).hide();
	          }else{
	            $(elem).removeClass('xt-watermark');
                $(elem).val("");  
	          }
            
          }
	  },
	  _dropdownCalendar:function(event){
	    var $dropdown = $(event.data.dropdown);
	    var $target = $(event.data.target);
	   
	    $dropdown.show();
	  
	    	    if($(window).height()<($target.offset().top+$dropdown.height())){
	       $dropdown.css("top",$target.offset().top-$dropdown.outerHeight()); 
	    }else{
	       $dropdown.css("top",$target.offset().top+$target.outerHeight());
	    }    
	    $dropdown.css("left",$target.offset().left);
	      $dropdown.hide();
	     $dropdown.calendar("show");
	    return false;
	  },
	}
	$.fn.textbox.defaults = {
	     watermark:'',
	     number:false,
	     date:false,
	     datelocal:'m/d/y',
	     required:false,
	     errormsg:{required:'Input value required.',number:'Only numeric is accepted.',date:'Invalid! Date.'},
	};
})(jQuery);