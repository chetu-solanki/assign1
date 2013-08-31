<?php
//$t->setVariable("$connect","mysql_connect($url,$user,$password,$database)");
$connect=mysql_connect("localhost","webadmin","password");
mysql_select_db("winestore",$connect) or die("Error selecting db");

require_once("MiniTemplator.class.php");

$t=new MiniTemplator;

$t->readTemplateFromFile("TemplateSearchScreen.html");
//$t->setVariable("$url","localhost");
//$t->setVariable("$user","webadmin");
//$t->setVariable("$pwd","password");
//$t->setVariable("$database","winstore");

//$t->setVariable("$connect","mysql_connect($url,$user,$password,$database)");
//$connect=mysql_connect("localhost","webadmin","password");
//mysql_select_db("winestore",$connect) or die("Error selecting db");

//selecting regions
//$t->setVariable("$query1","select distinct region_name from region order by region_name");
//$t->setVariable("$result1","mysql_query($query1)");
$query1="select distinct region_name from region order by region_name";
$result1=mysql_query($query1);

//selecting grape variety
//$t->setVariable("$query2","select distinct variety from grape_variety order by variety");
//$t->setVariable("$result2","mysql_query($query2)");

$query2="select distinct variety from grape_variety order by variety";
$result2=mysql_query($query2);

//selecting years
//$t->setVariable("$query3","select distinct year from wine order by year");
//$t->setVariable("$result3","mysql_query($query3)");

$query3="select distinct year from wine order by year";
$result3=mysql_query($query3);

//selecting years
//$t->setVariable("$query4","select distinct year from wine order by year");
//$t->setVariable("$result4","mysql_query($query4)");

$query4="select distinct year from wine order by year";
$result4=mysql_query($query4);


//$t->setVariable("txtWineName","$WineName");
//$t->setVariable("txtWineryName","$WineryName");
//$t->setVariable("SelectMinYear","Select");
$regionValue='';
while($row=mysql_fetch_assoc($result1))
{
  $a=$row['region_name'];
 $regionValue.= "<option value=$a>$a</option>";
// $t->setVariable("optRegionValue",$row['region_name']);
}
$t->setVariable("optRegionValue",$regionValue);

$varietyValue='';
while($row=mysql_fetch_assoc($result2))
{
  $a=$row['variety'];
  $varietyValue.= "<option value=$a>$a</option>";
 // $t->setVariable("optVarietyValue",$row['variety']);
}
 $t->setVariable("optVarietyValue",$varietyValue);

$YearValue='';
while($row=mysql_fetch_assoc($result3))
{
  $a=$row['year'];
  $YearValue.= "<option value=$a>$a</option>";
//  $t->setVariable("optMinYearValue",$row['year']);
}
 $t->setVariable("optMinYearValue",$YearValue);

/*$maxYearValue='';
while($row=mysql_fetch_assoc($result3))
{
  $a=$row['year'];
  $maxYearValue.= "<option value=$a>$a</option>";
//  $t->setVariable("optMinYearValue",$row['year']);
}*/
 $t->setVariable("optMaxYearValue",$YearValue);



//$t->setVariable("txtWinesStock",$WinesStock);
//$t->setVariable("txtWinesOrdered",$WinesOrdered);

//$t->setVariable("txtMaxCostRange",$MaxCost);
//$t->setVariable("txtMinCostRange",$MinCost);


//validation
/*$t->setVariable("errYear","");
$t->setVariable("errCost","");
$t->setVariable("errMinCost","");
$t->setVariable("errMaxCost","");
$t->setVariable("errWineName","");
$t->setVariable("errWineryName","");
$t->setVariable("errWinesStock","");
$t->setVariable("errWinesOrdered","");
*/

//$t->addBlock("Wine");
$check=0;
 if(isset($_GET['search_wine']))
 {
  //print_r($_GET);exit;
  $WineName=$_GET['txtWineName'];
  $WineryName=$_GET['txtWineryName'];
  $GrapeVariety=$_GET['ddlVarietyList'];
  $Region=$_GET['ddlRegionList'];
  $MinYear=$_GET['ddlMinYear'];
  $MaxYear=$_GET['ddlMaxYear'];
  $WinesStock=$_GET['txtWinesStock'];
  $WinesOrdered=$_GET['txtWinesOrdered'];
  $MinCost=$_GET['txtMinCostRange'];
  $MaxCost=$_GET['txtMaxCostRange'];



   if(($MinYear>=$MaxYear) && ($MinYear!='Select' && $MaxYear!='Select'))
   {
    $check=1;
    $t->setVariable("errYear","Enter valid year range");
   }

  if(($MinCost>=$MaxCost) && ($MinCost!='' && $MaxCost!=''))
  { 
    $check=1;
    $t->setVariable("errCost","Enter valid cost range");
  }
  if(!eregi("^[a-z]*$",$WineName))
  {
     $check=1;
     $m='wine name only contains alphabetic characters.';
     $t->setVariable("errWineName",$m);
  }
 if(!eregi("^[a-z]*$",$WineryName))
  {
       $check=1;
      $t->setVariable("errWineryName","Winery name only contains alphabetic characters.");
 }
 if(!eregi("^[0-9]*$",$WinesStock))
  {
       $check=1;
      $t->setVariable("errWineStock","wine stock only contains numeric characters.");
  }
 if(!eregi("^[0-9]*$",$WinesOrdered))

  {
       $check=1;
      $t->setVariable("errWinesOrdered","wine orders only contains numeric characters.");
  }
 if(!eregi("^[0-9]*$",$MinCost))
  {
      $check=1;
     $t->setVariable("errMinCost","Min cost  only contains numeric characters.");
  }
 if(!eregi("^[0-9]*$",$MaxCost))
  {
       $check=1;
      $t->setVariable("errMaxCost","Max Cost only contains alphabetic characters.");
  }


  
   if($check!=1) 
   {
   header("Location:http://54.252.201.226/assign1/partC/AnswerModuleClass.php?txtWineName=$WineName&txtWineryName=$WineryName&ddlRegionList=$Region&ddlVarietyList=$GrapeVariety&ddlMinYear=$MinYear&ddlMaxYear=$MaxYear&txtWinesStock=$WinesStock&txtWinesOrdered=$WinesOrdered&txtMinCostRange=$MinCost&txtMaxCostRange=$MaxCost&
   search_wine=Search");
  }

}
$t->addBlock("Wine");

$t->generateOutput();

?>


