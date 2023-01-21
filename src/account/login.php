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
  $db = Database::connect();

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

  $result = Database::login($db, $username, $password);

  if ($result === false) {
    // ~ Return a 400 Bad Request
    http_response_code(400);
    echo 'Username or password is incorrect.';
    return;
  }
  
  // -=- Session Creation -=-

  // ~ Start the session
  session_start();

  // ~ Set the session variables
  $_SESSION['user_id'] = $user['id'];
  $_SESSION['username'] = $user['username'];

  // ~ Return a 200 OK
  http_response_code(200);
  echo 'Successfully logged in.';

  // ~ Close the database connection
  $db->close();
  
  // ~ Redirect to the home page
  header('Location: /');
  
?>