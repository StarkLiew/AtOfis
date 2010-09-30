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
  
  var thisdate = {}; 
  $.fn.calendar=function(options){
  	  if(options=="show"){
  	    $.calendar.show(this);
  	    return false;
  	  }
  	  if(options=="hide"){
  	    $.calendar.hide(this);
        return false;
      } 	
       settings = $.extend({},$.fn.calendar.defaults, options);
    
       if(settings.date=='')
          thisdate=$.calendar._today();  
       else thisdate= $.calendar._setDate(settings.date, settings.local);
       $.calendar._create(this);
  }
 
  $.calendar={
    me:{},
    _create: function(_self){
       $this=$(_self);
       $.calendar.me=$(_self);
       $this.width(settings.width);
       //$this.height(settings.height);
       $.data($this, "settings", settings); 
       $this.addClass("xt");
       $this.addClass("xt-calendar");
       $this.css("padding-left","10px");
       $this.css("padding-right","10px");
       $this.css("padding-top","3px");
       $this.css("padding-bottom","5px");
       $this.attr('local',settings.local);

       if(settings.type=='dropdown'){
         $this.appendTo("body");
         $this.css("z-index","15001");
         $this.css("position","absolute");
         $("body").bind("click",{me:$this},function(event){
            $(event.data.me).hide();
         });
         $("div").bind("scroll",{me:$this},function(event){
            $(event.data.me).hide();
         });
         $this.hide();
       }
       $title = $("<div></div>").appendTo($this);
       $title.addClass("title");
       $title.css("text-align","center");
       $week = $("<div></div>").appendTo($this);
       $week.css("text-align","center");
       $daycontainer = $("<div></div>").appendTo($this);
       $daycontainer.css("text-align","center");
       $daycontainer.css("margin-bottom","2px");
       $daycontainer.addClass("daycontainer");
       if(settings.showtodaybutton){
         $footer = $("<div></div>").appendTo($this);
         $footer.css("text-align","center");
         $("<button>Today</button>").appendTo($footer)
         .bind("click",{me:$this,type:settings.type,target:settings.target,local:settings.local},$.calendar.todayClick);
         
       } 


   
       
       for(var i=1;i<=7;i++){
          $("<div>"+$.calendar._getdayprefix(i)+"</div>").appendTo($week)
          .width(20)
          .height(17)
          .addClass("dayprefix")
          .css("display","inline-block");
       } 
       $.calendar._build();
        
    },
    _getMonthName:function(month){
       var mth;
       switch(parseInt(month)){
         case 1:
             mth="January";
             break;
         case 2:
             mth="February";
             break;
         case 3:
             mth="March";
             break;
        case 4:
             mth="April";
             break;
        case 5:
             mth="May";
             break;
        case 6:
             mth="Jun";
             break;
        case 7:
             mth="July";
             break;
        case 8:
             mth="August";
             break;
        case 9:
             mth="September";
             break;
        case 10:
             mth="October";
             break;
       case 11:
             mth="November";
             break;
       case 12:
             mth="December";
             break;
                                             
       }
       return mth;
    },
    _getdateDay:function(userdate){
       var current = new Date($.calendar._getMonthName(userdate.month)+" "+userdate.date+","+userdate.year);
       var day=current.getDay();
       if(day==0) day = 7;
       return day;
    },
    _getdayprefix:function(day){
       var  prefix;
       switch(day){
         case 1:
             prefix = "M";
             break;
         case 2:
             prefix = "T";
             break;
         case 3:
             prefix = "W";
             break;
          case 4:
             prefix = "T";
             break;
         case 5:
             prefix = "F";
             break;
         case 6:
             prefix = "S";
             break;
          case 7:
             prefix = "S";
             break;
       }
       return prefix;
    },
    _leapyear:function(year){
      if(year%4==0 &&  year%100!=0) return true;
      if(year%100==0 && year%400==0) return true;
      if(year%400==0) return true;
        return false;
    },
    _days:function(month,year){
      if(month==1) return 31;
      if(month==2){
        var leap = $.calendar._leapyear(year);
        if(leap) return 29; else return 28; 
      }
      if(month==3) return 31;
      if(month==4) return 30;
      if(month==5) return 31;
      if(month==6) return 30;
      if(month==7) return 31;  
      if(month==8) return 31;
      if(month==9) return 30;
      if(month==10) return 31;
      if(month==11) return 30;
      if(month==12) return 31;

    },
    _build:function(){

      var $daycontainer = $this.find(".daycontainer");
      var $title = $this.find(".title");
      $title.html("");
      $daycontainer.html("");
      var dayinMonth = $.calendar._days(thisdate.month,thisdate.year);
  
      var lastmonth;
      if(thisdate.month == 1) lastmonth=$.calendar._days(12,thisdate.year-1);
      else lastmonth=$.calendar._days(thisdate.month-1,thisdate.year);
     
      var firstDay=$.calendar._getdateDay({date:1,month:thisdate.month,year:thisdate.year});
      var getTodate=$.calendar._today().date;

      var startlastmonth=lastmonth-firstDay+1;
      var dt=startlastmonth;
      
      var classStatus="inactiveday";
      var setToday="";
      var $buttonprev =$("<button style='width:12px;height:12px'></button>").appendTo($title);
      $buttonprev.addClass("prev");
      $buttonprev.css("cursor","pointer");
      $buttonprev.css("float","left");
    
      $("<span>"+$.calendar._getMonthName(thisdate.month)+" "+thisdate.year+"</span>").appendTo($title);
      var $buttonnext =$("<button style='width:12px;height:12px'></button>").appendTo($title);
      $buttonnext.css("float","right");
      $buttonnext.css("cursor","pointer");
      $buttonnext.addClass("next");
      
      var prevmonth;
      var nextmonth;
      if(thisdate.month == 1) prevmonth={date:1,month:12,year:thisdate.year-1};
      else prevmonth={date:1,month:thisdate.month-1,year:thisdate.year};
      if(thisdate.month == 12) nextmonth={date:1,month:1,year:thisdate.year+1};
      else nextmonth={date:1,month:thisdate.month+1,year:thisdate.year};
  
      $buttonprev.bind("click",{me:$this,date:prevmonth},$.calendar.prevClick);
      $buttonnext.bind("click",{me:$this,date:nextmonth},$.calendar.nextClick);
      
      var today =$.calendar._today(); 
      $title.css("padding","2px");
      var days =lastmonth;  
      var isprevmonth=true;
      var iscurrentmonth=false;
      var isnextmonth=false;
      var yr=prevmonth.year;
      var mth=prevmonth.month;
      
      for(var row=1;row<=6;row++){
        for(var col=1;col<=7;col++){   
          if(dt==days){
            classStatus="inactiveday";
          if(iscurrentmonth)isnextmonth=true;
            iscurrentmonth=false;
            days=dayinMonth;
            yr=nextmonth.year;
            mth=nextmonth.month;        
            dt=0;
          } 
          if(firstDay==col && isprevmonth){
            iscurrentmonth=true;
            isprevmonth=false;
            mth=thisdate.month;
            yr=thisdate.year;
            classStatus="activeday";
          }
          dt+=1; 
          
          if(getTodate==dt && thisdate.month==today.month && thisdate.year==today.year && iscurrentmonth) setToday = "today";
          var $box=$("<div>"+dt+"</div>").appendTo($daycontainer)
          .width(20)
          .height(17)
          .addClass(classStatus)
          .css("cursor","pointer")
          .addClass("activeday")
          .addClass(setToday)
          .css("line-height","17px")
          .css("vertical-align","middle")
          .css("display","inline-block");
          
          $($.data($this, "settings").target).bind("change",{me:$this,target:$.data($this, "settings").target, local:$.data($this, "settings").local},$.calendar.targetChange);
          
          if($.data($this, "settings").type=="dropdown"){
            $box.bind("click",{me:$this,value:{date:dt,month:mth,year:yr},target:$.data($this, "settings").target, local:$.data($this, "settings").local},function(event){
               $(event.data.target).trigger("focus");
               $.calendar._setValue(event.data.target,event.data.value,event.data.local);
               $(event.data.target).trigger("change");              
               $.calendar.hide($(event.data.me));
           });
          } else {
             $box.bind("click",{me:$this,value:{date:dt,month:mth,year:yr},target:$.data($this, "settings").target, local:$.data($this, "settings").local},function(event){
                $(event.data.target).trigger("focus");
                $(event.data.target).trigger("change");    
                $.calendar._setValue(event.data.target,event.data.value,event.data.local);
            });
          }

           setToday="";
         }
         
         $("<br />").appendTo($daycontainer);
      }  

    },
    isdate:function(datestring, localize){
       var ok = /^\d{1,2}[\/]\d{1,2}[\/]\d{4}$/.test(datestring);
       
       if(ok){
          var userdate=$.calendar._setDate(datestring, localize);
          if(userdate.date > $.calendar._days(userdate.month,userdate.year)) return false;
          return !/Invalid|NaN/.test(new Date($.calendar._getMonthName(userdate.month)+" "+userdate.date+","+userdate.year));   
       } return false; 
        
    },
    _today:function(){
       var today = new Date();
       var year = today.getFullYear();
       var month = today.getMonth() + 1; // +1, we do NOT want zero-based month index
       var date = today.getDate();
       var day = today.getDay();
       return {date:date,month:month,year:year};
    },
    _setDate:function(userdate,local){
      
         var dt;
         var mth;
         var yr;
         
         var dd=userdate.split("/");
         var lc=local.split("/");        
          
         $.each(lc,function(i,val){
            switch(val){
              case "m":
                  mth = parseInt(dd[i]);
                  break;
              case "d":
                  dt = parseInt(dd[i]);
                  break;
              case "y":
                  yr = parseInt(dd[i]);
                  break;      
         }    
       });
      return {date:dt,month:mth,year:yr};
    },
    prevClick:function(event){
      thisdate=event.data.date;
      $this=event.data.me;
      $.calendar._build();
      return false;
    },
    nextClick: function(event){
      thisdate=event.data.date;
      $this=event.data.me;
      $.calendar._build();
      return false;
    },
    targetChange: function(event){
      $this=event.data.me;
      var userdate =$(this).val();
      var local =$this.attr('local');
      if(!$.calendar.isdate(userdate,local)) thisdate=$.calendar._today();
      else thisdate=$.calendar._setDate(userdate,local);
       
    },
    todayClick: function(event){
       var me = event.data.me;
       var type = event.data.type;
       var target = event.data.target;
       var today = $.calendar._today();
       var local = event.data.local;
       $.calendar._setValue(target,today,local);
       if(type=="dropdown"){
           $(target).trigger("change");
          $.calendar.hide(me);
       }
      
    },
    formatDate:function(date,format){
        var ft=settings.date.local("/");
         $.each(ft,function(i,val){
            switch(val){
              case "m":
                  month = date.month;
                  break;
              case "d":
                  day = date.day;
                  break;
              case "y":
                  year = date.year;
                  break;
                }
         });
        
    },
     _setValue:function(target,value,local){
        if(local=="undefined" || local=="") local="m/d/y";
        var lc=local.split("/");
        var localizedDate="";
        $.each(lc,function(i,v){
             switch(v){
               case 'd':
                  localizedDate += value.date;
                  break;
               case 'm':
                  localizedDate += value.month;
                  break;
               case 'y':
                  localizedDate += value.year;
                  break;
             }
             
             if(($(lc).size()-1) > i) localizedDate+="/";
        }); 
       $(target).each(function(){
        if($(this).is("label"))  $(this).text(localizedDate);
        if($(this).is("input"))  $(this).val(localizedDate);
        else $(this).html(localizedDate);        
       }); 

            
    },
    show:function(self){    
       $.calendar._build();
      $(self).fadeIn();
      
    },
    hide:function(self){
      $(self).fadeOut();
    },
  }    
  $.fn.calendar.defaults = {
      date:'',
      local:'m/d/y',
      format:'mm/dd/yyyy',    
      width:200,
      type:'fix',
      target:'',
      height:160,   
      showtodaybutton:false,
              
  };
})(jQuery);
