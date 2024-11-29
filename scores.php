<?php
// scores.php
session_start();
require 'includes/db_connect.php';
// 取得最高分排名
$sql = "SELECT users.username, scores.score, scores.created_at 
        FROM scores 
        JOIN users ON scores.user_id = users.id 
        ORDER BY scores.score DESC, scores.created_at ASC 
        LIMIT 100";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>記分榜 - 反應挑戰</title>
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
    <h2>記分榜</h2>
    <table>
        <tr>
            <th>排名</th>
            <th>使用者名稱</th>
            <th>分數</th>
            <th>日期</th>
        </tr>
        <?php
        if ($result->num_rows > 0){
            $rank = 1;
            while($row = $result->fetch_assoc()){
                echo "<tr>
                        <td>{$rank}</td>
                        <td>".htmlspecialchars($row['username'])."</td>
                        <td>{$row['score']}</td>
                        <td>{$row['created_at']}</td>
                      </tr>";
                $rank++;
            }
        } else {
            echo "<tr><td colspan='4'>目前沒有任何分數紀錄。</td></tr>";
        }
        ?>
    </table>
    <div style="text-align:center;">
        <a href="game.php">回到遊戲</a> | 
        <a href="profile.php">個人資料</a> |
        <a href="logout.php">登出</a>
    </div>
</body>
</html>
