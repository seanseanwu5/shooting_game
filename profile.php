<?php
// profile.php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}
require 'includes/db_connect.php';
$user_id = $_SESSION['user_id'];
// 取得使用者分數紀錄
$stmt = $conn->prepare("SELECT score, created_at FROM scores WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// 計算最高分和平均分
$stmt_avg = $conn->prepare("SELECT MAX(score) AS max_score, AVG(score) AS avg_score, COUNT(*) AS total_games FROM scores WHERE user_id = ?");
$stmt_avg->bind_param("i", $user_id);
$stmt_avg->execute();
$stats = $stmt_avg->get_result()->fetch_assoc();

$stmt->close();
$stmt_avg->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>個人資料 - 射擊挑戰</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #000;
            text-align: center;
        }
        th {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <h2><?php echo htmlspecialchars($_SESSION['username']); ?> 的個人資料</h2>
    <div style="width:80%; margin: 0 auto;">
        <p>最高分：<?php echo $stats['max_score'] ?? 0; ?></p>
        <p>平均分：<?php echo number_format($stats['avg_score'] ?? 0, 2); ?></p>
        <p>總遊玩次數：<?php echo $stats['total_games'] ?? 0; ?></p>
    </div>
    <h3>分數紀錄</h3>
    <table>
        <tr>
            <th>分數</th>
            <th>日期</th>
        </tr>
        <?php
        if ($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo "<tr>
                        <td>{$row['score']}</td>
                        <td>{$row['created_at']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='2'>尚無分數紀錄。</td></tr>";
        }
        ?>
    </table>
    <div style="text-align:center;">
        <a href="game.php">回到遊戲</a> | 
        <a href="scores.php">記分榜</a> |
        <a href="logout.php">登出</a>
    </div>
</body>
</html>