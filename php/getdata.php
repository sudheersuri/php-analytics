<?php
require 'db.php';

//dont do the obvious testing
//get the total number of rows 

if($_REQUEST["type"]==1)
{

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

    echo json_encode(array("status"=>200,"content"=>calcAgePercentage($rowcount,$dataarr)));

}

if($_REQUEST["type"]==2)
{

    $sql = "SELECT count(*) as rowcount FROM travelfeedback";
    $result = $conn->query($sql);
    $row = $result -> fetch_assoc();
    //store it in a variable 
    $rowcount = $row["rowcount"];

    //calculate the percentages 
    $sql = "select bookingsource,count(bookingsource) as groupcount from travelfeedback GROUP by bookingsource";
    $result = $conn->query($sql);
    $dataarr = array();
    while($row = $result->fetch_assoc()) $dataarr[]=$row;

    echo json_encode(array("status"=>200,"content"=>calcBookingSrcPercentage($rowcount,$dataarr)));

}
if($_REQUEST["type"]==3)
{

    $sql = "SELECT count(*) as rowcount FROM demographics";
    $result = $conn->query($sql);
    $row = $result -> fetch_assoc();
    //store it in a variable 
    $rowcount = $row["rowcount"];


    //calculate the percentages 
    $sql = "select gender,count(gender) as groupcount from demographics GROUP by gender";
    $result = $conn->query($sql);
    $dataarr = array();
    while($row = $result->fetch_assoc()) $dataarr[]=$row;

    echo json_encode(array("status"=>200,"content"=>calcGenderPercentage($rowcount,$dataarr)));

}

    function calcAgePercentage($rowcount,$dataarr)
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


    function calcGenderPercentage($rowcount,$dataarr)
    {
        $responsearr = array();
        $i=0;
        while($i<count($dataarr))
        {  
            if($dataarr[$i]["gender"]=="M")
            $responsearr["Male"]=strval($dataarr[$i]["groupcount"]*100)/strval($rowcount);
            elseif($dataarr[$i]["gender"]=="F")
            $responsearr["Female"]=strval($dataarr[$i]["groupcount"]*100)/strval($rowcount);
            elseif($dataarr[$i]["gender"]=="NA")
            $responsearr["NA"]=strval($dataarr[$i]["groupcount"]*100)/strval($rowcount);
        
            $i=$i+1;
        }
        return $responsearr;
    }

    function calcBookingSrcPercentage($rowcount,$dataarr)
    {
        $responsearr = array();
        $i=0;
        while($i<count($dataarr))
        {   if($dataarr[$i]["bookingsource"]=="10")
            $responsearr["Online"]=strval($dataarr[$i]["groupcount"]*100)/strval($rowcount);
            elseif($dataarr[$i]["bookingsource"]=="20")
            $responsearr["Over The Phone"]=strval($dataarr[$i]["groupcount"]*100)/strval($rowcount);
            elseif($dataarr[$i]["bookingsource"]=="30")
            $responsearr["In Person"]=strval($dataarr[$i]["groupcount"]*100)/strval($rowcount);
            else
            $responsearr["Travel Warrant/Company"]=strval($dataarr[$i]["groupcount"]*100)/strval($rowcount);
            $i=$i+1;
        }
        return $responsearr;
    }

$conn->close();
?>