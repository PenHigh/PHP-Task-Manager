<?php 
  // -=- Request Verification -=-

  // ~ If the request method is not POST, return
  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // ~ Return a 405 Method Not Allowed
    http_response_code(405);
    return;
  }

  // -=- Database Connection -=-

  // ~ Connect to the database
  $db = new mysqli(
    $_ENV['MYSQL_HOST'],
    $_ENV['MYSQL_USER'],
    $_ENV['MYSQL_PASSWORD'],
    $_ENV['MYSQL_DATABASE']
  );

  // ~ If the connection failed, return
  if ($db->connect_error) {
    // ~ Return a 500 Internal Server Error
    http_response_code(500);
    echo 'Could not connect to the database.';

    return;
  }

  // -=- User Verification -=-

  // ~ Get the username and password from the request body
  $username = $_POST['username'];
  $password = $_POST['password'];

  // ~ If the username or password is empty, return
  if (empty($username) || empty($password)) {
    // ~ Return a 400 Bad Request
    http_response_code(400);
    echo 'Username and password are required.';

    // ~ Close the database connection
    $db->close();
    return;
  }

  // -=- Password Verification -=-

  // ~ Ensure that the password is the same as the saved password
  $stmt = $db->prepare('SELECT * FROM users WHERE username = ?');
  $stmt->bind_param('s', $username);
  $stmt->execute();

  // ~ Get the result
  $result = $stmt->get_result();

  // ~ If the result is empty, return
  if ($result->num_rows === 0) {
    // ~ Return a 400 Bad Request
    http_response_code(400);
    echo 'Username or password is incorrect.';

    // ~ Close the database connection
    $db->close();
    return;
  }

  // ~ Get the user
  $user = $result->fetch_assoc();

  // ~ If the password is incorrect, return
  if (!password_verify($password, $user['password'])) {
    // ~ Return a 400 Bad Request
    http_response_code(400);
    echo 'Username or password is incorrect.';

    // ~ Close the database connection
    $db->close();
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
  
  // TODO: Redirect to the application
?>