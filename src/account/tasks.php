<?php
  include_once __DIR__ . "/../lib/database.php";

  $request_method = $_SERVER['REQUEST_METHOD'];

  // ~ If it's not a POST or GET request, return
  if (
    $request_method !== 'POST' ||
    $request_method !== 'GET'
  ) {
    // ~ Return a 405 Method Not Allowed
    http_response_code(405);
    return;
  }

  // ~ Connect to the database

  $db = new Database();
  
  // -=- User Verification -=-
  
  // ~ Ensure that the user is logged in
  if (!isset($_SESSION['user_id'])) {
    // ~ Return a 401 Unauthorized
    http_response_code(401);

    if ($request_method === 'GET') {
      echo 'You must be logged in to access this resource.';
    } else {
      echo 'You must be logged in to create a task.';
    }

    return;
  }

  // ~ If it's a POST request, create a new task
  if ($request_method === 'POST') {

    // ~ Get the task name and type from the request body
    $taskName = $_POST['task-name'];
    $taskType = $_POST['task-type'];

    // ~ If the task name or type is empty, return
    if (empty($taskName) || empty($taskType)) {
      // ~ Return a 400 Bad Request
      http_response_code(400);
      echo 'Task name and type are required.';
      
      return;
    }

    if ($db->create_task($_SESSION['user_id'], $taskName, $taskType)) {
      // ~ Return a 201 Created
      http_response_code(201);
      echo 'Successfully created task.';
    } else {
      // ~ Return a 400 Bad Request
      http_response_code(400);
      echo 'Failed to create task.';
    }

    return;
  }

  // ~ If it's a GET request, get all tasks

  // ~ Get all tasks from the database
  $tasks = $db->get_tasks($_SESSION['user_id']);

  // ~ Return a 200 OK
  http_response_code(200);

  // ~ Return the tasks as JSON
  echo json_encode($tasks);

  return;
?>