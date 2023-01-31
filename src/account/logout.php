<?php
    // ~ Only GET requests are allowed
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        // ~ Return a 405 Method Not Allowed
        http_response_code(405);
        echo 'Method Not Allowed';
        return;
    }

    // ~ Clear the session
    session_unset();

    // ~ Destroy the session
    session_destroy();

    // ~ Redirect to home page
    header('Location: /');

?>
