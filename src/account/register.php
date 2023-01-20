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

  // ~ Verify that the username is not already taken
  $stmt = $db->prepare('SELECT * FROM users WHERE username = ?');
  $stmt->bind_param('s', $username);
  $stmt->execute();

  // ~ Get the result
  $result = $stmt->get_result();

  // ~ If the result is not empty, return
  if ($result->num_rows > 0) {
    // ~ Return a 400 Bad Request
    http_response_code(400);
    echo 'Username is already taken.';

    // ~ Close the database connection
    $db->close();
    return;
  }

  // -=- Password Verification -=-

  // ~ Verify that the password is valid
  require_once __DIR__ . '/account/verify_password.php';

  // ~ If the password is not valid, return
  if (!verify_password($password)) {
    // ~ Return a 400 Bad Request
    http_response_code(400);
    echo 'Password is not valid.';

    // ~ Close the database connection
    $db->close();
    return;
  }

  // -=- User Creation -=-

  // ~ Hash the password
  $password = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);

  // ~ Insert the user into the database
  $stmt = $db->prepare('INSERT INTO users (username, password, id) VALUES (?, ?, UUID())');
  $stmt->bind_param('ss', $username, $password);
  $stmt->execute();

  // -=- Session Creation -=-

  // ~ Return a 201 Created
  http_response_code(201);
  echo 'Account created.';

  // ~ Get the user's ID
  $id = $db->insert_id;

  // ~ Log the user in
  session_start();

  // ~ Set the session variables
  $_SESSION['user_id'] = $id;
  $_SESSION['username'] = $username;

  // ~ Close the database connection
  $db->close();

  // TODO: Redirect to the application
?>