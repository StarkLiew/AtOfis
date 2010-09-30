<?php 
header('Content-type: text/plain');

include "base2.php";
$sql="SELECT userid, username,MAX(ao_memo.createdate) AS cdate,ao_users.createdate AS udate  FROM ao_users LEFT JOIN ao_memo ON userid=fromuid WHERE activated=1 AND DATEDIFF(CURDATE(),ao_users.createdate)<60  GROUP BY userid,username,udate";
$result= mysql_query($sql);
function varUrl($string){
$html['string']="";
$html['string']=strip_tags(preg_replace('#[^A-Za-z0-9- ]#', '', $string));
$html['string']=strtolower($html['string']);
$reWriteStr = ereg_replace(" ","-",$html['string']);
return $reWriteStr;
}
echo "<?xml version='1.0' encoding='UTF-8'?>\r\n";
echo "<urlset\r\n";
echo "xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'\r\n";
echo "xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance'\r\n";
echo "xsi:schemaLocation='http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd'>\r\n";
echo "<url>\r\n<loc>http://www.atofis.com/</loc>\r\n<lastmod>2010-03-27</lastmod>\r\n<changefreq>never</changefreq>\r\n  <priority>0.80</priority>\r\n</url>\r\n";
echo "<url>\r\n<loc>http://www.atofis.com/index.php?rel=search</loc>\r\n<lastmod>2010-03-27</lastmod>\r\n<changefreq>never</changefreq>\r\n  <priority>0.50</priority>\r\n</url>\r\n";
echo "<url>\r\n<loc>http://www.atofis.com/privacy.php</loc>\r\n<lastmod>2010-03-27</lastmod>\r\n<changefreq>never</changefreq>\r\n  <priority>0.50</priority>\r\n</url>\r\n";
while($row=mysql_fetch_array($result))
{
	if (empty($row['username'])){
      $map="http://www.atofis.com/index.php?rel=profiles&uid=".varUrl($row['userid']);
	}else{
      $map="http://www.atofis.com/".varUrl($row['username'])."";
	}  
	if(!empty($row['cdate'])){
	    $modidate= date('Y-m-d\TH:i:sP', strtotime($row['cdate']));
     echo "<url>\r\n<loc>".$map."</loc>\r\n<lastmod>".$modidate."</lastmod>\r\n<changefreq>always</changefreq>\r\n  <priority>1.0</priority>\r\n</url>\r\n";}    
	    else{
	   	$modidate=date('Y-m-d', strtotime($row['udate']));
	  }
	
}
echo "</urlset>";
?> 

