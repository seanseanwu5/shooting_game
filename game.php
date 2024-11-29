<?php
// game.php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>遊戲 - 反應挑戰</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        /* 遊戲區域樣式 */
        #game-area {
            position: relative;
            width: 600px;
            height: 600px;
            border: 2px solid #000;
            background-color: #f0f0f0;
            margin: 20px auto;
            overflow: hidden;
        }
        #target {
            position: absolute;
            width: 50px;
            height: 50px;
            background-color: red;
            border-radius: 50%;
            cursor: pointer;
        }
        #score-board {
            text-align: center;
            margin-top: 10px;
        }
        #timer {
            font-size: 20px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h2>反應挑戰遊戲</h2>
    <div id="score-board">分數: <span id="score">0</span></div>
    <div id="timer">剩餘時間: <span id="time-left">30</span> 秒</div>
    <div id="game-area">
        <div id="target"></div>
    </div>
    <div style="text-align:center;">
        <button id="start-btn">開始遊戲</button>
        <a href="scores.php">查看記分榜</a> |
        <a href="profile.php">個人資料</a> |
        <a href="logout.php">登出</a>
    </div>

    <script src="js/game.js"></script>
</body>
</html>