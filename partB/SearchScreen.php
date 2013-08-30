
<!doctype html>
<html>
<head>



<?php

$connect=mysql_connect("localhost","webadmin","password");
mysql_select_db("winestore",$connect) or die("Error selecting db");

#selecting regions
$query1="select distinct region_name from region order by region_name";
$result1=mysql_query($query1);

#selecting grape variety
$query2="select distinct variety from grape_variety order by variety";
$result2=mysql_query($query2);

#selecting years
$query3="select distinct year from wine order by year";
$result3=mysql_query($query3); 

#selecting years
$query4="select distinct year from wine order by year";
$result4=mysql_query($query4);


//validation

$errYear='';
$errCost='';
$errMinCost='';
$errMaxCost='';
$errWineName='';
$errWineryName='';
$errWinesStock='';
$errWinesOrdered='';



 if(isset($_GET['search_wine']))
 {

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
    $errYear='Enter valid year range';
   }

  if(($MinCost>=$MaxCost) && ($MinCost!='' && $MaxCost!=''))
  {
     $errCost='Enter valid cost range';
  }
 if(!eregi("^[a-z]*$",$WineName))
  {
     $errWineName='Wine name must contain alphabetic characters';
  }
 if(!eregi("^[a-z]*$",$WineryName))
  {
     $errWineryName='Winery name must contain alphabetic characters';

 }
 if(!eregi("^[0-9]*$",$WinesStock))
  {
     $errWinesStock='Wines stock  must contain numeric characters';
  }
 if(!eregi("^[0-9]*$",$WinesOrdered))
  {
     $errWinesOrdered='Wines ordered  must contain numeric characters';
  }
 if(!eregi("^[0-9]*$",$MinCost))
  {
     $errMinCot='Min cost  must contain numeric characters';
  }
 if(!eregi("^[0-9]*$",$MaxCost))
  {
     $errMaxCost='Max Cost  must contain numeric characters';
  }

  else
  {
    
    header("Location:http://54.252.201.226/assign1/partB/AnswerModule.php?txtWineName=$WineName&txtWineryName=$WineryName&ddlRegionList=$Region&ddlVarietyList=$GrapeVariety&ddlMinYear=$MinYear&ddlMaxYear=$MaxYear&txtWinesStock=$WinesStock&txtWinesOrdered=$WinesOrdered&txtMinCostRange=$MinCost&txtMaxCostRange=$MaxCost&search_wine=Search");
  }
}


?>


<title>Untitled Document</title>


<h1><center><font color="#990000">Search Wine!</font></center></h1>
</head>

<body bgcolor="#339966">

<form method="get" name="WineSearch" id="form1" title="Search" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
  <p>&nbsp;</p>
  <table width="30%" border="1" align="center" cellpadding="5" cellspacing="5">
    <tr>
      <td width="45%">Wine name:</td>
      <td width="55%"><input type="text" name="txtWineName" id="txtWineName">
<?php  echo "<font color='red'> $errWineName"; ?>    
</td>
    </tr>
    <tr>
      <td>Winery name:</td>
      <td><input type="text" name="txtWineryName" id="txtWineryName">
   <?php echo "<font color='red'> $errWineryName"; ?>
</td>
    </tr>
   

    <tr>
      <td>Region:</td>
      <td>

<?php
echo '<select name="ddlRegionList" id="ddlRegionList">';
while($row=mysql_fetch_assoc($result1))
{
 echo '<option value="'.$row['region_name'].'">'.$row['region_name'].
 '</option>';
}
echo '</select>';

?>

</td>

    </tr>
<tr>
      <td>Grape Variety:</td>
<td>
<?php
echo '<select name="ddlVarietyList" id="ddlVarietyList">';
echo '<option value="Select">'.'Select';

while($row=mysql_fetch_assoc($result2))
{
 echo '<option value="'.$row['variety'].'">'.$row['variety'].
 '</option>';
}
echo '</select>';
?>

</td>
    </tr>

 <tr>
      <td>Range Of Years:</td>
      <td>
<?php
echo '<select name="ddlMinYear" id="ddlMinYear">';
echo '<option value="Select">'.'Select';
while($row=mysql_fetch_assoc($result3))
{
 echo '<option value="'.$row['year'].'">'.$row['year'].
 '</option>';
}
echo '</select>';
?>
<?php
echo 'To';
echo '<select name="ddlMaxYear" id="ddlMaxYear">';
echo '<option value="Select">'.'Select';
while($row=mysql_fetch_assoc($result4))
{
 echo '<option value="'.$row['year'].'">'.$row['year'].
 '</option>';
}
echo '</select>';
echo "<font color='red'> $errYear"; 

?>
</td>
    </tr>

     <tr>
      <td>Minimum no. of wines in stock:</td>
    <td>
       <input type="text" name="txtWinesStock" id="txtWinesStock">
     <?php echo "<font color='red'> $errWinesStock"; ?>
</td>
    </tr>
    <tr>
      <td>Minimum no. of wines ordered:</td>
      <td>
       <input type="text" name="txtWinesOrdered" id="txtWinesOrdered">
<?php echo "<font color='red'> $errWinesOrdered"; ?>
</td>
    </tr>
    
    <tr>
      <td>Dollar Cost Range:</td>
      <td>Min.<input type="text" name="txtMinCostRange" id="txtMinCostRange">
Max.<input type="text" name="txtMaxCostRange" id="txtMaxCostRange"></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" name="search_wine" id="submit" value="Search">
<?php echo "<font color='red'> $errCost"; ?>
<?php echo "<font color='red'> $errMinCost"; ?>
 <?php echo "<font color='red'> $errMaxCost";  ?>

</td>
    </tr>
</form>
</body>
</html>
