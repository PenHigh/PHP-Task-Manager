<?php
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header('Location: /auth/login');
        return;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Dashboard</h1>
        </div>
        <div class="content">
            <div class="user">
                <p>Hi <?php echo $_SESSION['username']; ?>!</p>
            </div>
            <div class="logout">
                <h2>Logout</h2>
                <form action="/account/logout.php" method="POST">
                    <button type="submit">Logout</button>
                </form>
            </div>
        </div>
</body>
</html>
