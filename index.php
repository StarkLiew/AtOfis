<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
<head>
    <link rel="stylesheet" href="../css/outlook.css" type="text/css" media="screen" />
    <meta http-equiv="Content-Type"content="text/html;charset=utf-8">    
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8"> 
    <meta name="google-site-verification" content="8w07JkrqcthcVqNajiuLfIehzQww7Sw0Qe7Q1zJYNQc" />
    
    <meta content="en" http-equiv="Content-Language">
    <meta name="AtOfis" content="jquery,jquery extender,jquery extend,jquery plugin">
    <meta http-equiv="Content-Type"content="text/html;charset=utf-8">    
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8"> 
    <meta content="width = 780" name="viewport">
    <meta content="IE=7" http-equiv="X-UA-Compatible">
    
    
    <script type="text/javascript" src="../resources/jquery-1.4.2.min.js"></script>
    <script type="text/javascript" src="../xt/atofis-xt.draggable.js"></script>
    <script type="text/javascript" src="../xt/atofis-xt.docking.js"></script>
    <script type="text/javascript" src="../xt/atofis-xt.mdilayout.js"></script>
    <script type="text/javascript" src="../xt/atofis-xt.statusbar.js"></script>
    <script type="text/javascript" src="../xt/atofis-xt.panel.js"></script>
    <script type="text/javascript" src="../xt/atofis-xt.button.js"></script>
    <script type="text/javascript" src="../xt/atofis-xt.toolbar.js"></script>
    <script type="text/javascript" src="../xt/atofis-xt.textbox.js"></script>
    <script type="text/javascript" src="../xt/atofis-xt.tooltip.js"></script>
    <script type="text/javascript" src="../xt/atofis-xt.tab.js"></script>
    <script type="text/javascript" src="../xt/atofis-xt.accordion.js"></script>
    <script type="text/javascript" src="../xt/atofis-xt.menubar.js"></script>
    <script type="text/javascript" src="../xt/atofis-xt.dialog.js"></script>
    <script type="text/javascript" src="../xt/atofis-xt.calendar.js"></script>
    <style type="text/css">
        label{width:90px;float:left;margin:2px;}
        input[type='text']{float:left;margin:2px;}
        input[type='password']{width:150px;float:left;margin:2px;}  
        br{clear:both;}
        h1{margin:0px;margin-left:5px;}
    </style>
    
</head>

<script type="text/javascript">
    $(function(){
       $("#mainStatusbar").statusbar();
       $("#mainHeader").panel({height:45});
       $("#TopPanel").panel();
       $("#WestPanel").panel({title:'AtOfis Demo',width:200,layout:'vertical'});
       $("#EastPanel").panel({width:200});
       $("#content").panel();
        $("#menubar").menubar();  //call without data to create an emply menubar first (for Ajax call only).
        $.ajax({type:"GET",url:'../samplemenu.xml',dataType:"xml",
             success: function(xml) {
                  $("#menubar").menubar({data:xml,datatype:'xml'});    
               }
        });      
       $("button").button();
       $("#toolbarpanel").toolbar();
       $("#accordion").accordion({showOnOpen:'#a1',height:'fit'});
    	 $("input[type='text'],input[type='password']").textbox();
    	 $("#searchtext").textbox({watermark:'Search...'});
    	 $("#uid").textbox({watermark:'User Id',required:true,errormsg:{required:'Please enter your user name.'}}); //demo using custom error messages
    	 $("#pwd").textbox({watermark:'Password',required:true});
    	 $("#dropdowncalendar").textbox({date:true,datelocal:'d/m/y',watermark:'d/m/y'});
    	 //$(".textbox").textbox({number:true});
       $("#xt-tab").tab();
    
       $("body").mdilayout({
               '#mainStatusbar':{dock:'bottom'}, 
               '#TopPanel':{dock:'top'}, 
               '#WestPanel':{dock:'left'}, 
               '#EastPanel':{dock:'right'},
               '#content':{dock:'center'}
             
              });
          $("#xt-dialog").dialog({title:'AtOfis',modal:true, buttons:{
                 'Okay':function(){
                      $("#xt-dialog").dialog("close");                 
                 }
               }
          });
       $("#demoDialogShow").click(function(){
           $("#xt-dialog").dialog("show");
       });
              
       $("#xt-calendar-demo").calendar({target:'.xt-calendar-value'});       
       $("form").submit(function(){
       
       
            
       });    
    });
</script>
<body>

  <div id="TopPanel">
   <div id="mainHeader" style="background:#000;text-align:center;">  
     
      <img src='../images/xt/atofis.gif' align="absmiddle" style="height:32px;width:56px;" /><span style="color:#ffffff;text-shadow: 1px 1px 0px #bad3ed;"> Project</span></h1>

   </div>
       <div id="menubar">
          </div>

   <div id="toolbarpanel"> 
        <button id="new" icon="../images/icon/contact.gif" tooltip="Create new contact">New</button>
        <button id="print" icon="../images/icon/print.gif" tooltip="Print"></button>
        <div class="seperator"></div>
        <input id="searchtext" type="textbox"/> 

         <button style="width:85px;" icon="../images/icon/find.gif" tooltip="Find a Contact and etc..." >All
         <ul>
           <li>All</li>
           <li>Forum</li>
           <li>Tickets</li>
         </ul>
         </button>
   

     </div>
     
</div>
   <div id="WestPanel">
     
      
 <div id="accordion">
  <h3><a href="#a1">Forum Login</a></h3>
  <div id="a1">
    Sorry! Forum still under construction.
          <form method="get" action="index.php">
          <div style="padding:2px;">
            <label>Email:</label><br /><input  style="width:150px" id="uid" name="uid" type="text"  /><br />
            <label>Password:</label><br /><input style="width:150px" id="pwd" name="pwd" type="password"  /><br />
            </div><br />
             <button style="float:right;" type="submit">Login</button>
  </form> <br />
  <a>Join AtOfis Forum</a><br />
  <a>Oop! Forgot my password?</a><br />
           
  </div>
  <h3><a href="#a2">License</a></h3>
  <div id="a2">
  <div style="white-space:normal;">
   <h2>AtOfis 1.0.1</h2> <br />
   As long as the copyright header left intact, you are free to use AtOfis project for your personal  to commercial project.
    <br /> <br />
    License under: <br /> <br />
    <a href="http://github.com/jxt/jXTend/blob/master/MIT-LICENSE.txt">MIT License</a> &nbsp;<a target="_blank" href='http://en.wikipedia.org/wiki/MIT_License'>Find out...</a><br />
     <a href="http://github.com/jxt/jXTend/blob/master/GPL-LICENSE.txt">GPL License</a> &nbsp;<a target="_blank" href='http://en.wikipedia.org/wiki/GNU_General_Public_License'>Find out...</a><br />
    </div>
 </div>
</div>
     
   </div>
     <div id="EastPanel">  
             <div style="overflow:auto;background:#fff;height:100%;white-space:normal;padding:10px;margin:2px;">
                  <h1>DOWNLOAD</h1>
                  
                  <a target="_blank" href="http://github.com/jxt/jXTend/zipball/master"><button>Download AtOfis 1.0.1 - ZIP</button></a>
                  <a target="_blank" href="http://github.com/jxt/jXTend/tarball/master"><button>Download AtOfis 1.0.1 - TAR</button></a>
                 
                  <br />
                  <br />
                 Requirement: jQuery 1.4 above <br>
                  <a target="_blank" href="http://www.jquery.com"><button>Learn more...</button></a>
                  <br/>       <br/>
                 <h3>TEAM</h3>
                 AtOfis is an open source project therefore welcome anyone who wish to come in and echance it features.
                     <br/>       <br/>
                 <h3>SPONSOR AND DONATION</h3>
                   Hope for sponsor and donation. Currently I using my own saving to keep this project alive.
                      <br/>       <br/>
                       

            </div>
        
      </div>

      <div id="content" >

        <div style="overflow:auto;background:#fff;height:100%;white-space:normal;padding:10px;">
 
          <h3>Use AtOfis widgets to enrich your web app that build on top of the jQuery Library. Atofis simple and easy to use.</h3>
          
          Default Theme: OutLook [outlook.css] <br />
                 
          <h4>AtOfis 1.0.1 Beta</h4>
          
          <br />Current features (Last Updated: Sep, 23 2010):
          <ul>
            <li><a href="../xt/atofis-xt.mdi.js">Mdi Layout</a></li>
            <li><a href="../xt/atofis-xt.panel.js">Panel (Dockable)</a></li>
            <li><a href="../xt/atofis-xt.menubar.js">Menubar</a></li>
            <li><a href="../xt/atofis-xt.toolbar.js">Toolbar</a></li>
            <li><a href="../xt/atofis-xt.statusbar.js">Statusbar</a></li>
            <li><a href="../xt/atofis-xt.button.js">Button</a></li>
            <li><a href="../xt/atofis-xt.accordion.js">Accordion</a></li>
            <li><a href="../xt/atofis-xt.textbox.js">Textbox </a><ul><li>Add watermark (9/9/2010)</li><li>Update Validation Engine (9/9/2010)</li></ul></li>
            <li><a href="../xt/atofis-xt.tooltip.js">Tooltip</a></li>
            <li><a href="../xt/atofis-xt.tab.js">Tab (9/23/2010) NEW!</a><br />
                    <div id="xt-tab">
             <ul>
               <li><a href="#task"><span>Task</span></a></li>
               <li><a href="#formattext"><span>Format Text</span></a></li>
               <li><a href="#insert"><span>Insert</span></a></li>
               <li><a href="#developer"><span>Developer</span></a></li>
               <li><a href="http://www.atofis.com/ajaxtab.htm"><span>Ajax</span></a></li>
             </ul>
            <div id="task">
               Put some task here
            </div>
            <div id="formattext">
              Format text here
            </div>
            <div id="insert">
              Insert something
            </div>
            <div id="developer">
              Developer Forum
            </div>
            
          </div>
              
            </li>
            <li><a href="../xt/atofis-xt.dialog.js">Dialog Beta (9/24/2010) NEW!</a><br /> 
              <button id="demoDialogShow">Click here to Show AtOfis Dialog </button>
                    
            <div id="xt-dialog">
                <p>Choose AtOfis and you will be happy.</p>
            </div>
            </li>
      
            <li><a href="../xt/atofis-xt.calendar.js">Calendar Beta (9/28/2010) NEW!</a><br />
              <label class="xt-calendar-value" style="width:100%" >Click the calendar below to change this text and textbox value.</label><br /> 
            <input type="text" class="xt-calendar-value" ></input><br />
            
            <label style="width:100%" >Calendar in default localization m/d/y</label><br />
            <div id="xt-calendar-demo">
            </div><br />
           
            </li>
             <li><a href="../xt/atofis-xt.calendar.js">Dropdown Calendar Beta (9/28/2010) NEW!</a><br /> 
                  <input type="text" id="dropdowncalendar" ></input>
                  
            </li>
          </ul><br />
          Up Coming:
            <ul>
            <li>Resizeable layout with drag and drop feature</li>
            <li>Form Layout</li>
            <li>Treeview</li>
            <li>Listview</li>
            <li>Gridview</li>
            <li>Gridview Dropdown</li>
            <li>Numeric Keyboard Dropdown</li>
            <li>Event Calendar</li>
            <li>Slider</li>
            <li>Progress Bar</li>
            <li>Ajax File Uploader</li>
          </ul>
          
          <p>Meantime, due to time contraint I only manage to release a few features. My next release will be data gridview with scrollable and paging which is still under debuging.</p>   
          <br />
          <br />
  
        </div>
        
      </div>
     
   
   <div id="mainStatusbar">
      Copyright &copy; 2010 <a href="http://www.facebook.com/starkliew">Kuan Yaw, Liew</a>
 
   </div>
   
  

  
  
  

 
 <?php ?>
</body>


</html>