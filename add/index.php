
<?php

session_start();

$nl = "<br>";
$dbconn = pg_connect("host=localhost dbname=project user=rishabh password=arbit")
        or die("Could not connect" . pg_last_error());
        
        
$query = "SELECT title, courseno, cid FROM Course_offering NATURAL JOIN Course_name";

//echo $query.$nl;
$result = pg_query($query);
$result1 = $result;
if($_GET["submit"])
{
//         if(isset($_GET["CS315"]))
//                 echo "set";
//         else
//                 echo "not set";
//         if(isset($_GET["CS\ 350"]))
//                 echo "set";
//         else
//                 echo "not set";
        while($row = pg_fetch_assoc($result1))
        {
                if(isset($_GET[$row['courseno']]))
                {
                        echo "done".$nl ;
                        // insert in the Registration table
                        //var_dump($_COOKIE);
                        $sname  = $_COOKIE["user"];
                        //echo $sname;
                        $cid = $row['cid'];
                        $query1 = "INSERT into Registration VALUES ('$sname','$cid');";
                        pg_query($query1);
                        //echo $query1.$nl;
                }
                //echo $row['courseno'].$_GET["CS 315"];
        }
}
echo "<form action = \"index.php\" method = \"GET\">";
$result = pg_query($query);
while($row = pg_fetch_assoc($result))
{               
        echo "<input type = \"checkbox\" name = \"".$row['courseno']."\" value = \"YES\" >". $row['courseno']. $row['title'].$nl;        
}
echo "<input type = \"submit\" name = \"submit\" value = \"Add Courses to your template\">"; 
echo "</form>"
?>