<?php
// index.php
session_start();
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>反應挑戰 - 首頁</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>歡迎來到反應挑戰</h1>
    <?php if(isset($_SESSION['username'])): ?>
        <p>你好，<?php echo htmlspecialchars($_SESSION['username']); ?>！</p>
        <a href="game.php">開始遊戲</a> | 
        <a href="scores.php">記分榜</a> | 
        <a href="profile.php">個人資料</a> | 
        <a href="logout.php">登出</a>
    <?php else: ?>
        <a href="login.php">登入</a> | 
        <a href="register.php">註冊</a>
    <?php endif; ?>
</body>
</html>