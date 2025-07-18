<?php
// Database connection
include "../../connections/dbname.php";

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ref_num = $_POST['ref_num'];
    $tab = $_POST['tab'];

    $tablename = "";

    switch ($tab) {
        case 1:
            $tablename = $database . ".`wt_course_learning_goals`";
            break;
        case 2:
            $tablename = $database . ".`wt_course_activities`";
            break;
        case 3:
            $tablename = $database . ".`wt_course_features`";
            break;
        case 4:
            $tablename = $database . ".`wt_course_materials`";
            break;
        case 5:
            $tablename = $database . ".`wt_course_teachers`";
            break;
    }

    $sql = "DELETE FROM $tablename WHERE `ref_num` = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $ref_num);

    if ($stmt->execute()) {
        echo "success|$ref_num";
    } else {
        echo "error|Execution failed: " . $stmt->error;
    }
}

// Close connection
mysqli_close($conn);
?>