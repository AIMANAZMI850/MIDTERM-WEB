<?php

include_once("dbconnect.php");

$results_per_page = 10;
if (isset($_GET['pageno'])) {
    $pageno = (int)$_GET['pageno'];
    $page_first_result = ($pageno - 1) * $results_per_page;
} else {
    $pageno = 1;
    $page_first_result = 0;
}
    

    
if (!isset($sqlsubjects)) {
    $sqlsubjects = "SELECT * FROM tbl_subjects";
    
}
$stmt = $conn->prepare($sqlsubjects);
$stmt->execute();
$number_of_result = $stmt->rowCount();
$number_of_page = ceil($number_of_result / $results_per_page);
$sqlsubjects = $sqlsubjects . " LIMIT $page_first_result , $results_per_page";
$stmt = $conn->prepare($sqlsubjects);
$stmt->execute();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$rows = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="../js/menu.js" defer></script>
    <title>Welcome to My Tutor</title>
</head>

<body s>
    <!-- Sidebar -->
     <div class="w3-sidebar w3-bar-block" style="display:none" id="mySidebar">
        <button onclick="w3_close()" class="w3-bar-item w3-button w3-large">Close &times;</button>
        <a href="#" class="w3-bar-item w3-button">Profile</a>
        <a href="index.php" class="w3-bar-item w3-button">Dashboard</a>
        <a href="subjects.php" class="w3-bar-item w3-button">Subjects</a>
        <a href="tutor.php" class="w3-bar-item w3-button">Tutors</a>
        <a href="#" class="w3-bar-item w3-button">Subscriptions</a>
        <a href="login.php" class="w3-bar-item w3-button">Logout</a>
     </div>
     
        <div class="w3-purple">
            <button class="w3-button w3-purple w3-xlarge" onclick="w3_open()">☰</button>
            <div class="w3-container">
                <h3>Dashboard</h3>
            </div>
        </div>
    
    <div class="w3-grid-template" >
        <?php
            $i = 0;
            foreach ($rows as $subjects) 
            {
                $i++;
                $subjectid = $subjects['subject_id'];
                $subjectname = $subjects['subject_name'];
                $subjectdescription = $subjects['subject_description'];
                $subjectprice = $subjects['subject_price'];
                $tutorid = $subjects['tutor_id'];
                $subjectsession= $subjects['subject_sessions'];
                $subjectrating= $subjects['subject_rating'];
                
                echo "<a href='index.php?subject_id=$subjectid' style='text-decoration: none;'> <div class='w3-card-4 w3-round' >
                <header class='w3-container w3-light-blue'><h4><b>$subjectname</b></h4></header>";
                echo "<img class='w3-image' src=../res/images/coursesimage/$subjectid.png"
                    . " style='width:50%;height:250px'><hr>";
            }   
        ?>
    </div>
    
    <br>
    <?php
        $num = 1;
        if ($pageno == 1) {
            $num = 1;
        } else if ($pageno == 2) {
            $num = ($num) + 10;
        } else {
            $num = $pageno * 10 - 9;
        }
        echo "<div class='w3-container w3-row'>";
        echo "<center>";
        for ($page = 1; $page <= $number_of_page; $page++) {
            echo '<a href = "index.php?pageno=' . $page . '" style=
            "text-decoration: none">&nbsp&nbsp' . $page . ' </a>';
        }
        echo " ( " . $pageno . " )";
        echo "</center>";
        echo "</div>";
    ?>
    </br>
    <footer class="w3-footer w3-center w3-bottom w3-purple">MY TUTOR COPYRIGHT</footer>

</body>

</html>