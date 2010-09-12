/*!
 * jXT 1.0.1
 *
 * Copyright (c) 2010 Kuan Yaw, Liew (http://xt.atofis.com/)
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 *
 * http://xt.atofis.com/
 */

(function($){
	$.fn.textbox=function(options){
		
		 
	    settings = $.extend({}, arguments.callee.defaults, options);
	    $.data(this,'watermark',settings.watermark);
	    var isNumberOnly=settings.number;
	    var isRequired=settings.required;
	    $.data(this,'errormsg',settings.errormsg);
	    
		_create(this);
		

		  function _create(_self){
		    
		  if(!$(_self).hasClass("xt"))$(_self).addClass("xt");
			if(!$(_self).hasClass("xt-textbox")) $(_self).addClass("xt-textbox");
      
      var   _pass = $(_self);
			if(settings.watermark!=''){
			      if($(_self).attr('type')=='password'){
	                 //tranform my self to become text
			        $(_self).before("<input id='decoy' value='"+settings.watermark+"' style='"+$(_self).attr('style')+"' class='"+$(_self).attr('class')+" xt-watermark' haspassword='true' readonly='true' />");
			        var _decoy = $(_self).prev();
			        $(_decoy).css('margin','2px');
			        $(_decoy).bind('focus',watermark_focus);
              $(_self).bind('blur',{watermark:settings.watermark},watermark_blur);
 
			         //_self=$(_decoy);
			         
			         $(_pass).hide();     
			      }else{
			        $(_self).addClass('xt-watermark');
              $(_self).val(settings.watermark); 
                  
              $(_self).bind('focus',watermark_focus);
              $(_self).bind('blur',{watermark:settings.watermark},watermark_blur);
              
			      }
			    
		        
			}
			

			if(isNumberOnly || isRequired){
			  $(_self).bind("change blur",{errormsg: settings.errormsg},_validate);
			  
			  if(isNumberOnly) $(_self).css("text-align","right");
		    }
			$(_self).parents("form").bind('submit',custom_submit); 
		  }
	
		  function _validate(event){
		       var _self=$(this);
		        var hasError = false;  
		       var errormsg = event.data.errormsg;
		   if(isRequired){ 
			   var val = "";
			   if(!$(_self).hasClass('xt-watermark'))  val =$(_self).val();
			   if (val=="" ) {
			    hasError=true;
			 
		 		$.textbox._showerror(this, errormsg.required);
			   }
		   }    
           if(isNumberOnly){
			   	
			   	if (!$.textbox._isnumber($(_self).val(), _self)) {
			   		hasError=true;
			   	   
				 		$.textbox._showerror(this,errormsg.number);
    				 }

			   }	
		 	if(hasError) return false;
		 	if($(_self).hasClass("error")){
			    $(_self).removeClass("error");
			    var err=$(_self).next('.xt-error-img');
			    if($(_self).attr('type')=='password') $(_self).prev('.xt-watermark').removeClass("error");
			    $(err).tooltip("destroy");
			    $(err).remove();
		 	}
	
		  }
        function watermark_focus(event){
               
               $.textbox._clearWatermark(this);
               return false;
        }

        function watermark_blur(event){
         
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
        }
  	  function custom_submit(event){
  		  
		 //revalidate all input
  		  $(this).find('input').trigger('change');
		 if($(this).find('.error').size() > 0) return false;
		 
		 $(this).find('.xt-watermark').each(function(){
			 $(this).val('');
		 });

	  }

	}
	$.textbox={
	  version:'1.0.1',
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
	  }
	}
	$.fn.textbox.defaults = {
	     watermark:'',
	     number:false,
	     required:false,
	     errormsg:{required:'Input value required.',number:'Only numeric is accepted.'}
	};
})(jQuery);