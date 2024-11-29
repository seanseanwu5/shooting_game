<?php
// login.php
session_start();
require 'includes/db_connect.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    // 查詢使用者
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($id, $hashed_password);
    if ($stmt->fetch()) {
        if (password_verify($password, $hashed_password)) {
            // 登入成功
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            header("Location: game.php");
            exit();
        } else {
            $error = "密碼錯誤。";
        }
    } else {
        $error = "使用者不存在。";
    }
    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>登入 - 反應挑戰</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h2>登入</h2>
    <?php if(isset($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
    <form action="login.php" method="POST">
        <label>使用者名稱：</label>
        <input type="text" name="username" required><br>
        <label>密碼：</label>
        <input type="password" name="password" required><br>
        <button type="submit">登入</button>
    </form>
    <p>還沒有帳號？ <a href="register.php">註冊</a></p>
</body>
</html>