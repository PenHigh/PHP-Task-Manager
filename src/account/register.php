<?php 
  include_once __DIR__ . "/../lib/database.php";

  // -=- Request Verification -=-

  // ~ If the request method is not POST, return
  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // ~ Return a 405 Method Not Allowed
    http_response_code(405);
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

  // ~ Verify that the password is valid
  require_once __DIR__ . '/../account/verify_password.php';

  // ~ If the password is not valid, return
  if (!verify_password($password)) {
    // ~ Return a 400 Bad Request
    http_response_code(400);
    echo 'Password is not valid.';

    return;
  }

  // -=- User Creation -=-

  $user_creation_status = $db->register($username, $password);

  if ($user_creation_status === false) {
    // ~ Return a 400 Bad Request
    http_response_code(400);
    echo 'Username is already taken.';

    return;
  }

  // -=- Session Creation -=-

  // ~ Return a 201 Created
  http_response_code(201);
  echo 'Account created.';

  // ~ Get the user's ID
  $id = $db->get_recent_id();

  // ~ Log the user in
  session_start();

  // ~ Set the session variables
  $_SESSION['user_id'] = $id;
  $_SESSION['username'] = $username;

  // ~ Redirect to the application
  header('Location: /');
?>