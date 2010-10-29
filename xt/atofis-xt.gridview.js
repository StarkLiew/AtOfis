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
	$.fn.gridview=function(options){	
       settings = $.extend({}, $.fn.gridview.defaults, options);

       $.gridview.create(this,settings);
  }
  var $me; 
  var $gridwrapper;
  var gridsettings;
  var $columnWrapper; 
  var $gridcontent;
  $.gridview={
    create: function(_self,settings){
       $me = $(_self);
       $headerWrapper = $("<div></div>").appendTo($me);
       $headerWrapper.addClass('xt-gridview-header');
       $columnWrapper = $("<div></div>").appendTo($headerWrapper);
       $gridwrapper=$('<div></div>').appendTo($me);
 
       $me.css('overflow','hidden');


       $columnWrapper.css('overflow','hidden');
       $gridwrapper.css('overflow','auto');

  
       $gridcontent=$('<div></div>').appendTo($gridwrapper);
       
       gridsettings = settings;
       $me.addClass('xt xt-gridview');
       
       $me.width(settings.width);  
       $me.height(settings.height);
       $gridwrapper.width($me.innerWidth());
       
       $.gridview.makeColumn();
       $gridwrapper.height($me.innerHeight()-2-$columnWrapper.innerHeight());
       
       
      
       scrollbarWidth = $.gridview.getScrollbarSize();
       
       
       $columnWrapper.width($me.innerWidth()-scrollbarWidth);
     
       $gridwrapper.scroll(function(){
           $columnWrapper.scrollLeft($gridwrapper.scrollLeft());
       });
       

    },
    makeColumn:function(){
       
       var columnWidth = 0;
       
       var idx=0;
       var $column = $("<div></div>").appendTo($columnWrapper);
       //empty column
       
       $column.css('display','inline-block');
       $column.addClass('col'+idx);
       $column.css('cursor','pointer');
       $column.css('padding','1px');
       $column.css('vertical-align','middle');
       $column.addClass('xt-gridview-column');
       $column.css('overflow','hidden');
       $column.width(18);
       columnWidth+=$column.outerWidth();
       $column.height(gridsettings.headerHeight);
       idx = 1;
       $.each(gridsettings.header,function(i,n){
          var $column = $("<div></div>").appendTo($columnWrapper);
          $column.addClass('xt-gridview-column');
          $column.width(n.width);
          $column.height(gridsettings.headerHeight);
          $column.css('line-height',gridsettings.headerHeight+'px');
          $column.css('vertical-align','middle');
          $column.addClass('col'+idx);
          $column.html(i);
          $column.css('display','inline-block');
          $column.css('padding','1px');
          $column.css('margin','0px');
          $column.css('cursor','pointer');
          $column.css('overflow','hidden');
          if(n.align!='') $column.css('text-align',n.align);
          columnWidth+=$column.outerWidth();
          idx+=1;
       });
       $gridcontent.width(columnWidth);
           

       $.gridview.loadData();
       
    },
    loadData:function(){
         
         $gridwrapper.addClass('xt-loading');
         $gridcontent.html("");
        $.ajax({ 
           type: gridsettings.calltype, 
           dataType:gridsettings.datatype,
           url: gridsettings.url, 
           data: gridsettings.data, 
           success: function(datas){ 
             $.gridview.insertData(datas);},
           error: function(){
             $gridwrapper.html('Data fetching error!');
             $gridwrapper.removeClass('xt-loading');            
         } 
       });
    },
    
    insertData: function(datas){
      
       
       var $data = $(datas).find(':first');
       var row_idx = 0;
       var col_idx = 0;
             
            $data.find("> *").each(function(){
                var $row =$('<div></div>').appendTo($gridcontent);
                 
                $row.addClass('xt-gridview-row');
                
                $row.addClass('row'+row_idx);
                $row.css('padding','0px');
                $row.css('m','0px');
                $row.height(gridsettings.rowHeight);
                $row.width($gridcontent.innerWidth());
                $row.bind('click',{grid:$gridcontent},$.gridview.rowClick);
                //first row empty cell
                var $cell =$('<div></div>').appendTo($row); 
                $cell.addClass('xt-gridview-row-cell');
                $cell.addClass('col'+col_idx);    
                $cell.css('margin','0px');
                $cell.css('display','inline-block');
                $cell.css('padding','1px');
                $cell.height(gridsettings.rowHeight);
                $cell.width(18);
                col_idx=1;
                $item = $(this)
             
               $.each(gridsettings.header,function(i,n){
                    $found=$item.find(n.bind);
   
                   if($found.size()>-1){
                    var $cell =$('<div></div>').appendTo($row);
                    $cell.html($found.text());
                    $cell.addClass('xt-gridview-cell');
                    $cell.addClass('col'+col_idx);
                    $cell.height(gridsettings.headerHeight);
                    $cell.css('line-height',gridsettings.rowHeight+'px');
                    $cell.css('vertical-align','middle');
                    $cell.css('margin','0px');    
                    $cell.css('padding','1px');
                    $cell.css('display','inline-block');
                    $row.bind('click',{grid:$gridcontent},$.gridview.cellClick);
                    if(n.align!='') $cell.css('text-align',n.align); 
                    $cell.height(gridsettings.rowHeight);
                    $cell.width(n.width);
                    col_idx+=1;  
                   }
                  });

           
               row_idx+=1;
               col_idx=0;
            });
     $gridcontent.keydown(function(event){
          var $grid= $(this);
            
          if(event.which==40){
            var $current=$grid.find('.xt-gridview-row.selected');
            if($current.index()==$grid.children().size()-1) return false;
            $current.removeClass('selected');
            $current=$current.next().addClass('selected');
            if($current.index()==$grid.children().size()-1)
              $gridwrapper.scrollTop($current.position().top);
            
          }
         if(event.which==38){
            
            var $current=$grid.find('.xt-gridview-row.selected');
            var $first = $grid.find('.xt-gridview-row:first');
            if($current.index()==0) return false;
            $current.removeClass('selected');
            $current=$current.prev().addClass('selected');
            if($current.index()==0)
             $gridwrapper.scrollTop(0);
          }
       });
             $gridwrapper.removeClass('xt-loading'); 
    
    },
    setColumWidth: function($col, maxColWidth, textLength){
          if(maxColWidth<=textLength){
            $col.width(textLength+2);
          }else $col.width(maxColWidth+2);
          return $col;
    },
   cellClick: function(event){
         var $grid= $(event.data.grid);
         $grid.find('.xt-gridview-row').removeClass('selected');
         $(this).addClass('selected');
         return false;      
    },
    rowClick: function(event){
         var $grid= $(event.data.grid);
         $grid.find('.xt-gridview-row').removeClass('selected');
         $(this).addClass('selected');
         return false;      
    },
    getScrollbarSize: function(){
        var $inner = $('<p></p>').css({width:'100%',height:'100%'});
        var $outer = $('<div></div>')
          .css({
            position:'absolute',
            top: '0px',
            left: '0px',
            visibility: 'hidden',
            width: '200px',
            height: '150px',
            overflow: 'hidden'
          })
          .append($inner)
          .appendTo('body');
        
        var w1 = $inner.innerWidth();
        $outer.css('overflow','scroll');
        var w2 = $inner.innerWidth();
        if (w1 == w2) w2 = $outer.innerWidth();
        $outer.remove();
        return(w1 - w2);
    }
    
  }    
  $.fn.gridview.defaults = {
      url:'',
      calltype:'post',
      data:'',    
      datatype:'xml',
      maxColWidth:50,
      headerHeight:19,
      rowHeight:18,
      header:{},
      width:300,
      height:100,    
      docking:'none',         
  };
})(jQuery);
