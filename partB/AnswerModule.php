 <!doctype html>
<html>
<head>
<?php


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
             inventory.on_hand,inventory.cost,wine.year,sum(items.qty),sum(items.qty)*items.price
         from wine,winery,grape_variety,region,wine_variety,inventory,items
         where wine.winery_id=winery.winery_id and wine.wine_id=inventory.wine_id 
         and region.region_id=winery.region_id and grape_variety.variety_id=wine_variety.variety_id and 
    wine_variety.wine_id =wine.wine_id and items.wine_id=wine.wine_id ";

//Add wine name criteria
if($WineName!="")
{
 $query1.="and wine.wine_name='{$WineName}'";
}

//Add wineryname criteria
if($WineryName!="")
{
 $query1.="and winery.winery_name='{$WineryName}'";
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
if($WinesOrdered!="")
{
 $query1.="and items.qty>='{$WinesOrdered}'";
}
	
//Add Min and Max cost criteria	  
if($MinCost!="" && $MaxCost!="")
{
 $query1.="and inventory.cost between '{$MinCost}' and '{$MaxCost}'";
}


//Add grouping and sorting criteria
 $query1.=" group by items.wine_id,wine.year";

$result1=mysql_query($query1);
$num_rows=mysql_num_rows($result1);
echo $num_rows;
?>
<meta charset="utf-8">
<title>Answer Of Search</title>
<h1><center><font color="#990000">Result:</font></center></h1>
</head>

<body bgcolor="#339966">


<?php
if($num_rows==0)
{
 echo '<h1><center>No records found';
}

else
{
?>


  <table width="98%" border="1" align="center" cellpadding="5" cellspacing="5">


    <tr>
      <th>Wine name:</th>
       <th>Winery name:</th>
       <th>Grape Variety:</th>
       <th> Region:</th>
       <th> Year:</th>
        <th>Cost Of Wine In the Inventory</th>
       <th>Total no.of bottles available:</th>
       
 <th>Total stock sold:</th>
          <th>Total Sales Revenue: </th>


    </tr>

   <?php
     while($row=mysql_fetch_array($result1))
     {
           $winename=$row['wine_name'];
	   $wineryname=$row['winery_name'];
	   $grapevariety=$row['variety'];
	   $region=$row['region_name'];
	   $year=$row['year'];
           $cost=$row['cost'];
          $quantity=$row['on_hand'];
          $stocksold=$row['sum(items.qty)'];
          $SalesRevenue=$row['sum(items.qty)*items.price'];
    
	   echo "<tr>";

      echo "<td>";
      echo $winename;
      echo "</td>";

      echo "<td>";
      echo $wineryname;
      echo "</td>";
	  
      echo "<td>";
      echo $grapevariety;
      echo "</td>";

      echo "<td>";
      echo $region;
      echo "</td>";

      echo "<td>";
      echo $year;
      echo "</td>";

       echo "<td>";
      echo $cost;
      echo "</td>";

     echo "<td>";
      echo $quantity;
      echo "</td>";

     echo "<td>";
      echo $stocksold;
      echo "</td>";

      echo "<td>";
      echo $SalesRevenue;
      echo "</td>";



      echo "</tr>";
     }
?>
 </table>
<?php
}
?>


</body>
</html>

