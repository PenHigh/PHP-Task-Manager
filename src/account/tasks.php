<?php
  // ~ If it's not a POST or GET request, return
  if ($_SERVER['REQUEST_METHOD'] !== 'POST' && $_SERVER['REQUEST_METHOD'] !== 'GET') {
    // ~ Return a 405 Method Not Allowed
    http_response_code(405);
    return;
  }

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
  
  // ~ Ensure that the user is logged in
  if (!isset($_SESSION['user_id'])) {
    // ~ Return a 401 Unauthorized
    http_response_code(401);

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      echo 'You must be logged in to access this resource.';
    } else {
      echo 'You must be logged in to create a task.';
    }

    // ~ Close the database connection
    $db->close();
    return;
  }

  // ~ If it's a POST request, create a new task
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ~ Get the task name from the request body
    $taskName = $_POST['task-name'];

    // ~ Get the task type from the request body
    $taskType = $_POST['task-type'];

    // ~ If the task name is empty, return
    if (empty($taskName) || empty($taskType)) {
      // ~ Return a 400 Bad Request
      http_response_code(400);
      
      // ~ Close the database connection
      $db->close();
      
      if (empty($taskName)) {
        echo 'Task name is required.';
        return;
      }

      echo 'Task type is required.';
      return;
    }

    // ~ Insert the task into the database
    $stmt = $db->prepare('INSERT INTO tasks (user_id, name, type) VALUES (?, ?, ?)');

    $stmt->bind_param('iss', $_SESSION['user_id'], $taskName, $taskType);
    $stmt->execute();

    // ~ Return a 201 Created
    http_response_code(201);

    // ~ Close the database connection
    $db->close();

    return;
  }

  // ~ If it's a GET request, get all tasks

  // ~ Get all tasks from the database
  $stmt = $db->prepare('SELECT * FROM tasks WHERE user_id = ?');
  $stmt->bind_param('i', $_SESSION['user_id']);
  $stmt->execute();

  // ~ Get the result
  $result = $stmt->get_result();

  // ~ Return a 200 OK
  http_response_code(200);

  // ~ Return the tasks as JSON
  echo json_encode($result->fetch_all(MYSQLI_ASSOC));

  // ~ Close the database connection
  $db->close();

  return;
?>