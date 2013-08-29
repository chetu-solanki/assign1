
<!doctype html>
<html>
<head>

<!--validation-->
<script language="Javascript" type="text/Javascript">
function processForm()
{
  if(myform.txtMinCostRange.value > myform.txtMaxCostRange.value)
  {
   alert("Please Enter valid cost range");
   myform.txtMinCostRange.focus();
  }


}

</script>

<?php

$connect=mysql_connect("localhost","webadmin","password");
mysql_select_db("winestore",$connect) or die("Error selecting db");

#selecting regions
$query1="select region_name from region";
$result1=mysql_query($query1);

#selecting grape variety
$query2="select variety from grape_variety";
$result2=mysql_query($query2);

#selecting years
$query3="select year from wine";
$result3=mysql_query($query3); 

#selecting years
$query4="select year from wine";
$result4=mysql_query($query4);

?>



<meta charset="utf-8">
<title>Untitled Document</title>


<h1><center><font color="#990000">Search Wine!</font></center></h1>
</head>

<body bgcolor="#339966">

<form method="get" name="WineSearch" id="form1" title="Search" action="AnswerModule.php" onSubmit="return processForm()">
  <p>&nbsp;</p>
  <table width="30%" border="1" align="center" cellpadding="5" cellspacing="5">
    <tr>
      <td width="45%">Wine name:</td>
      <td width="55%"><input type="text" name="txtWineName" id="txtWineName"></td>
    </tr>
    <tr>
      <td>Winery name:</td>
      <td><input type="text" name="txtWineryName" id="txtWineryName"></td>
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
?>
</td>
    </tr>

     <tr>
      <td>Minimum no. of wines in stock:</td>
      <td>
       <input type="text" name="txtWinesStock" id="txtWinesStock"></td>
    </tr>
    <tr>
      <td>Minimum no. of wines ordered:</td>
      <td>
       <input type="text" name="txtWinesOrdered" id="txtWinesOrdered"></td>
    </tr>
    
    <tr>
      <td>Dollar Cost Range:</td>
      <td>Min.<input type="text" name="txtMinCostRange" id="txtMinCostRange">
Max.<input type="text" name="txtMaxCostRange" id="txtMaxCostRange"></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" name="search_wine" id="submit" value="Search"></td>
    </tr>
</form>
</body>
</html>
