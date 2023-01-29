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
        <div class="left-container">
            <div class="left-top">
                <div class="left-top-title">
                    Good <!-- LOGIC FOR MORNING/EVENING --!> eve/morn? <?php echo $_SESSION['username']; ?></p>
                </div>
                <div class="left-top-new-note-container">
                    <div class="left-top-new-note">
                    </div>
                    <div class="left-top-new-note-button">
                    </div>
                </div>
                <div class="left-top-logout-container">
                    <form action="/account/logout.php" method="POST">
                        <button type="submit">Logout.</button>
                    </form>
                </div>
            </div>
            <div class="left-bottom">
                <div class="left-bottom-title">
                </div>
                <div class="task-list-container">
                    <div class="task-list-item"></div>
                    <!-- LOGIC TO DISPLAY TASKS --!>
                </div>
            </div> 
        </div>
        <div class="left-container">
            <div class="task-title-container">
                <div class="task-title"></div>
                <div class="task-title-date"><!-- LOGIC FOR DATE --!></div>
            </div>
            <div class="task-content">
                <!-- LOGIC FOR TASKS (textinput?) --!>
            </div>
        </div>
    </div>
</body>
</html>
