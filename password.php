<?php
// check_url.php
include 'db.php';

$url = $_POST['url'];
$pass = $_POST['pass'];
$result = $conn->query("SELECT * FROM notes_url WHERE url = '$url'");
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if($row['pass'] == ''){
        $pass = password_hash($pass,PASSWORD_DEFAULT);
        $conn->query("UPDATE notes_url SET pass='".$pass."' WHERE url = '$url'");
        echo json_encode(["response" => true]); exit();
    } else {
        if (password_verify($pass,$row['pass'])){
            echo json_encode(["response" => true]); exit();
        }else {
            echo json_encode(["response" => false]); exit();
        }
    }
} else {
    echo json_encode(["response" => false]); exit();
}
?>