<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
Design by Free CSS Templates
http://www.freecsstemplates.org
Released for free under a Creative Commons Attribution 2.5 License

Name       : Mini-Break    
Description: A two-column, fixed-width design with dark color scheme.
Version    : 1.0
Released   : 20131203

-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Student Faculty Feedback</title>
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700" rel="stylesheet" type="text/css">
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>
        <div id="menu-wrapper">
                <div id="menu">
                        <ul>
                                <li ><a href="index.php">Home</a></li>
                                <li class="current_page_item"><a href="add.php">Add your courses here</a></li>
                                <li><a href="feed.php">Give Feedback</a></li>   
                                 <li>
                                <?php
                                session_start();
                                if(isset($_POST["logout"]))
                                {
                                        //echo "here";
                                        session_unset(); 
                                        session_destroy(); 
                                }
                                if(!empty($_SESSION['user']))
                                        echo "
                                        <form method = \"POST\" action=\"index.php\">
                                        <input type = \"submit\" value=\"Logout\" class=\"button\" name=\"logout\" style=\"position:absolute;right:50px;top:10px\"> 
                                        </form>
                                        
                                        ";
                                ?>
                                </li>
                                <li>
                                <?php                                
                                
                                if(!empty($_SESSION['user']))
                                        echo "<span style = \"position:absolute;font-size:150%;color:#ffffff; left:50px;top:14px;\"> ". $_SESSION['user'] ." </span>";
                                ?>
                                </li>
                        </ul>
                </div>
                <!-- end #menu -->
        </div>

<div id="wrapper">
        <div id="header-wrapper">
                <div id="header">
                        <div id="logo">
                                <h1><a href="#"> Course Feedback </a></h1>
                                <p>- by Rishabh Nigam</a></p>
                        </div>
                </div>
        </div>
        <!-- end #header -->
        <div id="page">
                <div id="page-bgtop">
                        <div id="page-bgbtm">
                                <div id="content">
                                        <div class="post">
                                                <h2 class="title"><a href="#">Welcome to the site  </a></h2>
                                                
                                                <div class="entry">
                                                
                                                <?php

session_start();

$nl = "<br>";
$dbconn = pg_connect("host=localhost dbname=project user=rishabh password=arbit")
        or die("Could not connect" . pg_last_error());
        
if(isset($_POST["logout"]))
{
        //echo "here";
        session_unset(); 
        session_destroy(); 
}
if(empty($_SESSION['user']))
{
        echo "Please login to continue";
        goto end;
}        
$sname = $_SESSION['user'];


        
$query = "SELECT cid,courseno, title FROM Course_offering NATURAL JOIN Course_name except select cid, courseno, title from Registration NATURAL JOIN Course_name NATURAL JOIN Course_offering where sname = '$sname'";
//echo $query.$nl;

//echo $query.$nl;
$result = pg_query($query);
$result1 = $result;


if($_POST["submit"])
{
//         if(isset($_POST["CS315"]))
//                 echo "set";
//         else
//                 echo "not set";
//         if(isset($_POST["CS\ 350"]))
//                 echo "set";
//         else
//                 echo "not set";
        //echo  "here";
        while($row = pg_fetch_assoc($result1))
        {
                //echo $row['courseno'];
                if(isset($_POST[$row['courseno']]))
                {
                        //echo "done".$nl ;
                        // insert in the Registration table
                        //var_dump($_COOKIE);
                        $sname  = $_SESSION['user'];
                        //echo $sname;
                        $cid = $row['cid'];
                        $query1 = "INSERT into Registration VALUES ('$sname','$cid');";
                        pg_query($query1);
                        $check = "SELECT * from feedback where sname = '$sname' and cid = '$cid'";
                        //echo $check;
                        $res = pg_query($check);
                        if(!pg_fetch_assoc($res))
                        {
                                echo "set";                                                                                
                                $query1 = "INSERT into feedback VALUES ('$sname','$cid');";
                                pg_query($query1);
                        }
                        
                        //echo $query1.$nl;
                }
                //echo $row['courseno'].$_POST["CS 315"];
        }
}
echo "Select courses from the list below to add <br>".$nl;
echo "<form action = \"add.php\" method = \"POST\">";
$result = pg_query($query);
echo "<div style=\"overflow:scroll; height:150px;width:80%\">";
echo "<table>
<col width=\"7%\">
<col width=\"15%\">
<col width=\"75%\">
";
while($row = pg_fetch_assoc($result))   
{               
        echo "<tr> <td> <input type = \"checkbox\" name = \"".$row['courseno']."\" value = \"YES\" >". "</td><td>". $row['courseno']. "</td><td>". $row['title']."</td></tr>";        
}
echo "</table>";
echo "</div> <br><br>";
echo "<input type = \"submit\" name = \"submit\" class = \"button\" value = \"Add Courses to your template\">"; 
echo "</form>";
echo "<br><br>You are registered for the following courses <br>";
$query = "select cid, courseno, title from Registration NATURAL JOIN Course_name NATURAL JOIN Course_offering where sname = '$sname'";
$result = pg_query($query);
echo "<table>
<col width=\"20%\">
<col width=\"80%\">
";
while($row = pg_fetch_assoc($result))
{
        echo "<tr><td>".$row['courseno']."</td><td>".$row['title']."</td></tr>";
}
echo "</table>";
//echo $query;
end:
                                                ?>
                                                </div>
                                        </div>
                                        
                                        <div style="clear: both;">&nbsp;</div>
                                </div>
                                <!-- end #content -->
                                <div id="sidebar">
                                        <ul>
                                                <li>
                                                        <h2>About the site</h2>
                                                        <p>This is an online course feedback system developed to eliminate the manual work involved in the process. </p>
                                                </li>
                                                <li>
                                                        <h2>Categories</h2>
                                                        <ul>
                                                                <li><a href="index.php">Home</a></li>
                                                                <li><a href="add.php">Add courses here</a></li>
                                                                <li><a href="feed.php">Give the feedback</a></li>
                                                        </ul>
                                                </li>
                                                
                                        </ul>
                                </div>
                                <!-- end #sidebar -->
                                <div style="clear: both;">&nbsp;</div>
                        </div>
                </div>
        </div>
        <!-- end #page -->
</div>
<div id="footer">
        <p>Copyright (c) 2013 @rishabh. All rights reserved. Source code available <a href= "">here</a></p>
</div>
<!-- end #footer -->
</body>
</html>




