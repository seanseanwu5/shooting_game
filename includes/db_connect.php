<?php
// db_connect.php
$servername = "localhost";
$username = "root";
$password = ""; // 預設密碼為空，依實際設定調整
$dbname = "shooting_game";

// 建立連接
$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查連接
if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}
?>
