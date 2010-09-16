<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
<head>
    <link rel="stylesheet" href="../css/outlook.css" type="text/css" media="screen" />
    <meta http-equiv="Content-Type"content="text/html;charset=utf-8">    
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8"> 
    <meta name="google-site-verification" content="8w07JkrqcthcVqNajiuLfIehzQww7Sw0Qe7Q1zJYNQc" />
    <script type="text/javascript" src="../resources/jquery-1.4.2.min.js"></script>
    <script type="text/javascript" src="../xt/jquery-xt.docking.js"></script>
    
    <script type="text/javascript" src="../xt/jquery-xt.mdilayout.js"></script>
    <script type="text/javascript" src="../xt/jquery-xt.statusbar.js"></script>
    <script type="text/javascript" src="../xt/jquery-xt.panel.js"></script>
    <script type="text/javascript" src="../xt/jquery-xt.button.js"></script>
    <script type="text/javascript" src="../xt/jquery-xt.toolbar.js"></script>
    <script type="text/javascript" src="../xt/jquery-xt.textbox.js"></script>
    <script type="text/javascript" src="../xt/jquery-xt.tooltip.js"></script>
    <script type="text/javascript" src="../xt/jquery-xt.accordion.js"></script>
    <script type="text/javascript" src="../xt/jquery-xt.menubar.js"></script>
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
       //$('body').mdi();
       $("#mainStatusbar").statusbar();
       $("#mainHeader").panel({height:45});
       $("#TopPanel").panel();
       $("#WestPanel").panel({title:'XT Sample',width:200,layout:'vertical'});
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
    	 $(".textbox").textbox({number:true});
       
       $("body").mdilayout({
               '#mainStatusbar':{dock:'bottom'}, 
               '#TopPanel':{dock:'top'}, 
               '#WestPanel':{dock:'left'}, 
               '#EastPanel':{dock:'right'},
               '#content':{dock:'center'}
             
              });
              
       $("form").submit(function(){
            //alert($("#uid").val());
            
       });    
    });
</script>
<body>

  <div id="TopPanel">
   <div id="mainHeader" style="background:#000;text-align:center;">  
     
      <img src='../images/jxt_logo.gif' align="absmiddle" style="height:34px;width:42px;" /><span style="color:#ffffff;text-shadow: 1px 1px 0px #bad3ed;"> Project</span></h1>

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
           <li>Inventories</li>
           <li>Customers</li>
            <li>Suppliers</li>
            <li>Bills</li>
         </ul>
         </button>
   

     </div>
     
</div>
   <div id="WestPanel">
     
      
 <div id="accordion">
  <h3><a href="#a1">Demo</a></h3>
  <div id="a1">
          <form method="get" action="index.php">
          <div style="padding:2px;">
            <label>User Name:</label><input  style="width:60px" id="uid" name="uid" type="text"  /><br />
            <label>Password:</label><input style="width:62px" id="pwd" name="pwd" type="password"  /><br />
            <label>Id:</label><input style="width:20px;" name="test" id="testTextbox" type="text" class="textbox" /><br />
            </div><br />
             <button style="float:right;" type="submit">Login</button>
        </form>
   
  </div>
  <h3><a href="#a2">License</a></h3>
  <div id="a2">
  <div style="white-space:normal;">
   <h2>jXT 1.0.1</h2> <br />
   As long as the copyright header left intact, you are free to use jXT project for your personal  to commercial project.
    <br /> <br />
    License under: <br /> <br />
    <a href="http://github.com/jxt/jXT/blob/master/MIT-LICENSE.txt">MIT License</a> &nbsp;<a target="_blank" href='http://en.wikipedia.org/wiki/MIT_License'>Find out...</a><br />
     <a href="http://github.com/jxt/jXT/blob/master/GPL-LICENSE.txt">GPL License</a> &nbsp;<a target="_blank" href='http://en.wikipedia.org/wiki/GNU_General_Public_License'>Find out...</a><br />


    </div>
 </div>
</div>
     
   </div>
     <div id="EastPanel">
             
             <div style="overflow:auto;background:#fff;height:100%;white-space:normal;padding:10px;margin:2px;">
                  <h1>DOWNLOAD</h1>
                 
                  <a target="_blank" href="http://github.com/jxt/jXT/zipball/master"><button>Download jXT 1.0.1 - ZIP</button></a>
                  <a target="_blank" href="http://github.com/jxt/jXT/tarball/master"><button>Download jXT 1.0.1 - TAR</button></a>
                 
                  <br />
                  <br />
                 Requirement: jQuery 1.4 above <br>
                  <a target="_blank" href="http://www.jquery.com"><button>Learn more...</button></a>
                  <br/>
            </div>
        
      </div>

      <div id="content" >
        
        
        <div style="overflow:auto;background:#fff;height:100%;white-space:normal;padding:10px;">
          <h3>USE jXT to develop rich web apps with amazing interfaces and controls
          that build on top of the jQuery Library.</h3>
          
          Default Theme: OutLook [outlook.css] <br />
          
          
          <h4>jXT 1.0.1 Beta</h4>
          
          <br />Current features (Last Updated: Sep, 2 2010):
          <ul>
            <li><a href="../xt/jquery-xt.mdi.js">Mdi Layout</a></li>
            <li><a href="../xt/jquery-xt.panel.js">Panel</a></li>
            <li><a href="../xt/jquery-xt.docking.js">Panel Docking</a></li>
            <li><a href="../xt/jquery-xt.menubar.js">Menubar</a></li>
            <li><a href="../xt/jquery-xt.toolbar.js">Toolbar</a></li>
            <li><a href="../xt/jquery-xt.statusbar.js">Statusbar</a></li>
            <li><a href="../xt/jquery-xt.button.js">Button</a></li>
            <li><a href="../xt/jquery-xt.accordion.js">Accordion</a></li>
            <li><a href="../xt/jquery-xt.textbox.js">Textbox </a><ul><li>Add watermark (9/9/2010)</li><li>Update Validation Engine (9/9/2010)</li></ul></li>
            <li><a href="../xt/jquery-xt.tooltip.js">Tooltip</a></li>
          </ul>
          Up Coming:
            <ul>
            <li>Tabs</li>
            <li>Form Validation</li>
            <li>Resizeable layout with drag and drop feature</li>
            <li>Form Layout</li>
            <li>Treeview</li>
            <li>Listview</li>
            <li>Dialog</li>
            <li>Gridview</li>
            <li>Gridview Dropdown</li>
            <li>Calender Dropdown</li>
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