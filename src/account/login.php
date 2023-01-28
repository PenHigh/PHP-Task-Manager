<?php 
  include_once __DIR__ . "/../lib/database.php";

  // -=- Request Verification -=-

  // ~ If the request method is not POST, return
  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // ~ Return a 405 Method Not Allowed
    http_response_code(405);
    echo 'Method Not Allowed';
    return;
  }

  // -=- Database Connection -=-

  // ~ Connect to the database
  $db = new Database();

  // -=- User Verification -=-

  // ~ Get the username and password from the request body
  $username = $_POST['username'];
  $password = $_POST['password'];

  // ~ If the username or password is empty, return
  if (empty($username) || empty($password)) {
    // ~ Return a 400 Bad Request
    http_response_code(400);
    echo 'Username and password are required.';
  
    return;
  }

  // -=- Password Verification -=-

  $is_logged_in = $db->login($username, $password);

  if ($is_logged_in === false) {
    // ~ Return a 400 Bad Request
    http_response_code(400);
    echo 'Username or password is incorrect.';
  
    return;
  }
  
  // -=- Session Creation -=-

  // ~ Start the session
  session_start();

  // ~ Get the user from the database
  $user = $is_logged_in;

  // ~ Set the session variables
  $_SESSION['user_id'] = $user['id'];
  $_SESSION['username'] = $user['username'];

  // ~ Redirect to the dashboard
  http_response_code(302);
  header('Location: /dashboard')
?>
