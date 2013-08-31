
<?php

require_once("MiniTemplator.class.php");

$te = new MiniTemplator; 

$te->readTemplateFromFile ("TemplateAnswer.html"); 

$WineName=$_GET['txtWineName'];
$WineryName=$_GET['txtWineryName'];
$GrapeVariety=$_GET['ddlVarietyList'];
$Region=$_GET['ddlRegionList'];
$MinYear=$_GET['ddlMinYear'];
$MaxYear=$_GET['ddlMaxYear'];
$WinesQty=$_GET['txtWinesStock'];
$WinesOrdered=$_GET['txtWinesOrdered'];
$MinCost=$_GET['txtMinCostRange'];
$MaxCost=$_GET['txtMaxCostRange'];

$connect=mysql_connect("localhost","webadmin","password");
mysql_select_db("winestore",$connect) or die("Error selecting db");

//checking for existence
$query1="select distinct wine.wine_name,winery.winery_name,grape_variety.variety,region.region_name,
             inventory.on_hand,inventory.cost,wine.year,sum(items.qty),sum(items.price)
         from wine,winery,grape_variety,region,wine_variety,inventory,items
         where wine.winery_id=winery.winery_id and wine.wine_id=inventory.wine_id 
         and region.region_id=winery.region_id and grape_variety.variety_id=wine_variety.variety_id and 
    wine_variety.wine_id =wine.wine_id and items.wine_id=wine.wine_id ";

//Add wine name criteria
if($WineName!="")
{
 $query1.="and wine.wine_name like '$WineName%'";
}

//Add wineryname criteria
if($WineryName!="")
{
 $query1.="and winery.winery_name like '$WineryName%'";
}

//Add variety criteria
if($GrapeVariety!="Select")
{
 $query1.="and grape_variety.variety='{$GrapeVariety}'";
}

//Add region criteria
if($Region!="All")
{
 $query1.="and region.region_name='{$Region}'";
}

//Add year criteria
if($MinYear!="Select" && $MaxYear!="Select")
{
 $query1.="and wine.year between '{$MinYear}' and '{$MaxYear}'";
}

//Add  Stock Criteria		  
if($WinesQty!="")
{
 $query1.="and inventory.on_hand>='{$WinesQty}'";
}

//Add wines ordered criteria
/*if($WinesOrdered!="")
{
 $query1.="and sum(items.qty)>='{$WinesOrdered}'";
}*/
	
//Add Min and Max cost criteria	  
if($MinCost!="" && $MaxCost!="")
{
 $query1.="and inventory.cost between '{$MinCost}' and '{$MaxCost}'";
}


//Add grouping and sorting criteria
 $query1.=" group by items.wine_id,wine.year";

if($WinesQty!=0)
{
 $query1.=" having sum(items.qty)>=$Winesqty";

}
           $query1.=" order by wine.wine_name,wine.year";

$result1=mysql_query($query1);
$num_rows=mysql_num_rows($result1);
echo $num_rows;



if($num_rows==0)
{
 $te->setVariable("Records","No Records Found");
}

/*$varietyValue='';
while($row=mysql_fetch_assoc($result2))
{
  $a=$row['variety'];
  $varietyValue.= "<option value=$a>$a</option>";
 // $t->setVariable("optVarietyValue",$row['variety']);
}
 $t->setVariable("optVarietyValue",$varietyValue);
*/
else
{

     while($row=mysql_fetch_array($result1))
     {
            
         $te->setVariable("winename",$row[0]);
         $te->setVariable("wineryname",$row[1]);
         $te->setVariable("grapevariety",$row[2]);
         $te->setVariable("region",$row[3]);
         $te->setVariable("year",$row[4]);
         $te->setVariable("cost",$row[5]);
         $te->setVariable("quantity",$row[6]);
         $te->setVariable("stocksold",$row[7]);
         $te->setVariable("SalesRevenue",$row[8]);

$te->addblock("data");

}

}

$te->addBlock("Answer");
$te->generateOutput();
?>
