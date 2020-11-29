<?php
require 'db.php';

//dont do the obvious testing
//get the total number of rows 
$sql = "SELECT count(*) as rowcount FROM demographics";
$result = $conn->query($sql);
$row = $result -> fetch_assoc();
//store it in a variable 
$rowcount = $row["rowcount"];


//calculate the percentages 
$sql = "select agegroup,count(agegroup) as groupcount from demographics GROUP by agegroup";
$result = $conn->query($sql);
$dataarr = array();
while($row = $result->fetch_assoc()) $dataarr[]=$row;

echo json_encode(array("status"=>200,"content"=>calcPercentage($rowcount,$dataarr)));

function calcPercentage($rowcount,$dataarr)
{
    $responsearr = array();
    $i=0;
    while($i<count($dataarr))
    {    
        $responsearr[$dataarr[$i]["agegroup"]]=strval($dataarr[$i]["groupcount"]*100)/strval($rowcount);
        $i=$i+1;
    }
    return $responsearr;
}
$conn->close();
?>