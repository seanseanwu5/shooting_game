<?php
// register.php
session_start();
require 'includes/db_connect.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $email = trim($_POST['email']);
    // 檢查是否已存在
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $error = "帳號或電子郵件已被註冊。";
    } else {
        // 密碼加密
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $hashed_password, $email);
        if ($stmt->execute()) {
            $_SESSION['user_id'] = $stmt->insert_id;
            $_SESSION['username'] = $username;
            header("Location: game.php");
            exit();
        } else {
            $error = "註冊失敗，請再試一次。";
        }
    }
    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>註冊 - 反應挑戰</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h2>註冊</h2>
    <?php if(isset($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
    <form action="register.php" method="POST">
        <label>使用者名稱：</label>
        <input type="text" name="username" required><br>
        <label>電子郵件：</label>
        <input type="email" name="email" required><br>
        <label>密碼：</label>
        <input type="password" name="password" required><br>
        <button type="submit">註冊</button>
    </form>
    <p>已有帳號？ <a href="login.php">登入</a></p>
</body>
</html>