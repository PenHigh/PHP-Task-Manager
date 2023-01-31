<?php
    // Start the session
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
                    good morening <!--LOGIC FOR MORN/EVE --> <?php echo $_SESSION['username']; ?></p>
                </div>
                <div class="left-top-new-note-container">
                    <div class="left-top-new-note">
                        New Note
                    </div>
                    <div class="left-top-new-note-button">
    
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
    
                    </div>
                </div>
                <div class="left-top-logout-container">
                    <form action="/account/logout.php" method="GET">
                        <button type="submit">Logout.</button>
                    </form>
                </div>
            </div>
            <div class="left-bottom">
                <div class="left-bottom-title">
                </div>
                <div class="task-list-container">
                    <div class="task-list-item"></div>
                    <!-- LOGIC TO DISPLAY TASKS -->
                </div>
            </div> 
        </div>
        <div class="right-container">
            <div class="task-title-container">
                <div class="task-title">
                    Task title
                </div>
                <div class="task-title-date"><!-- LOGIC FOR DATE --></div>
            </div>
            <div class="task-content">
                <!-- LOGIC FOR TASKS (textinput?) -->
            </div>
        </div>

    </div>

</body>
</html>
