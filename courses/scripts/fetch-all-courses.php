<?php
if (!isset($_SESSION)) {
    session_start();
    ob_start();
}
?>

<?php
include "../../connections/dbname.php";

$language = $_POST['language']; //  _en, _cn, _kr, _jp
$filter = $_POST['filter'] ?? '';

$course_short_title = "course_short_title" . $language;
$course_description = "course_description" . $language;
$thumbnail_tag = "thumbnail_tag" . $language;
$course_type = "course_type" . $language;

$tablename = $database . ".`wt_courses`";
$sql = "SELECT 
            `ref_num`, 
            `course_img`, 
            `course_list_img`, 
            `$course_short_title` AS `course_short_title`, 
            `$thumbnail_tag` AS `thumbnail_tag`, 
            `$course_description` AS `course_description`, 
            `language`,
            `age_group`,
            `$course_type` AS `course_type` 
        FROM $tablename";

$conditions = [];
$params = [];
$types = "";

switch ($filter) {
    case 'English Programs':
        $conditions[] = "language = ?";
        $params[] = "English";
        $types .= "s";
        break;
    case 'Chinese Programs':
        $conditions[] = "language = ?";
        $params[] = "Chinese";
        $types .= "s";
        break;
    case 'Family Package':
        $conditions[] = "course_package = ?";
        $params[] = "Family";
        $types .= "s";
        break;
    case 'School Package':
        $conditions[] = "course_package = ?";
        $params[] = "School";
        $types .= "s";
        break;
    case 'Kids Courses':
        $conditions[] = "age_group = ?";
        $params[] = "Kids";
        $types .= "s";
        break;
    case 'Adult Courses':
        $conditions[] = "age_group = ?";
        $params[] = "Adults";
        $types .= "s";
        break;
    case 'Teens/Youth Courses':
        $conditions[] = "age_group = ?";
        $params[] = "Teens";
        $types .= "s";
        break;
    default:
        $query = '%' . $filter . '%';
        $conditions[] = "$course_short_title LIKE ?";
        $params[] = $query;
        $types .= "s";
        $conditions[] = "$course_description LIKE ?";
        $params[] = $query;
        $types .= "s";
        $conditions[] = "$thumbnail_tag LIKE ?";
        $params[] = $query;
        $types .= "s";
        $conditions[] = "$course_type LIKE ?";
        $params[] = $query;
        $types .= "s";
        $conditions[] = "age_group LIKE ?";
        $params[] = $query;
        $types .= "s";
        $conditions[] = "course_package LIKE ?";
        $params[] = $query;
        $types .= "s";
        $conditions[] = "language LIKE ?";
        $params[] = $query;
        $types .= "s";
        break;
}

if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" OR ", $conditions);
}

$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

$courses = [];
while ($row = $result->fetch_assoc()) {
    $courses[] = $row;
}
echo json_encode($courses);
?>