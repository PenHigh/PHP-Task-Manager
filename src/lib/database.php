<?php

    // ~ Ensure that this file is only called from the server
    if (!isset($_SERVER['HTTP_HOST'])) {
        // ~ Return a 403 Forbidden
        http_response_code(403);
        echo 'Forbidden.';
        return;
    }

    /**
     * Database class
     */
    class Database {

        private $db;

        public function __construct() {
            // ~ Connect to the database
            $this->$db = new mysqli(
                $_ENV['MYSQL_HOST'],
                $_ENV['MYSQL_USER'],
                $_ENV['MYSQL_PASSWORD'],
                $_ENV['MYSQL_DATABASE']
            );

            // ~ If the connection failed, return
            if ($this->$db->connect_error) {
                // ~ Return a 500 Internal Server Error
                http_response_code(500);
                echo 'Could not connect to the database.';
                return;
            }

            // ~ Setup the database
            $this->setup();
        }

        /**
         * Setup the database
         */
        private function setup() {
            // ~ Create the users table if it does not exist
            $this->$db->query('CREATE TABLE IF NOT EXISTS users (
                id INT NOT NULL AUTO_INCREMENT,
                username VARCHAR(255) NOT NULL,
                password VARCHAR(255) NOT NULL,
                PRIMARY KEY (id)
            )');

            // ~ Create the tasks table if it does not exist
            $this->$db->query('CREATE TABLE IF NOT EXISTS tasks (
                id INT NOT NULL AUTO_INCREMENT,
                user_id INT NOT NULL,
                name VARCHAR(255) NOT NULL,
                type VARCHAR(255) NOT NULL,
                PRIMARY KEY (id),
                FOREIGN KEY (user_id) REFERENCES users(id)
            )');
        }

        /**
         * Check if the user with the given username exists
         * @param {string} $username The username
         * @return {boolean} Whether the user exists
         */
        public function username_exists($username) {
           // ~ Verify that the username is not already taken
           $stmt = $this->$db->prepare('SELECT * FROM users WHERE username = ?');
           $stmt->bind_param('s', $username);
           $stmt->execute();

           // ~ Get the result
           $result = $stmt->get_result();

           // ~ If the result is not empty, return false
           if ($result->num_rows > 0) {
               // ~ Return a 400 Bad Request
               http_response_code(400);
               echo 'Username is already taken.';

               return false;
           }
           return true;
        }

        /**
         * Register a user
         * @param {string} $username The username
         * @param {string} $password The password
         * @return {boolean} Whether the user was registered
         */
        public function register($username, $password) {
            // ~ If the username is already taken, return
            if (!self::username_exists($username)) {
                return false;
            }

            // ~ Hash the password
            $password = password_hash($password, PASSWORD_DEFAULT);

            // ~ Insert the user into the database
            $stmt = $this->$db->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
            $stmt->bind_param('ss', $username, $password);
            $stmt->execute();

            // ~ Return whether the user was registered
            return true;
        }

        /**
         * Login a user
         * @param {string} $username The username
         * @param {string} $password The password
         * @return {boolean} Whether the user was logged in
         */
        public function login($username, $password) {
            // ~ If the username does not exist, return
            if (!self::username_exists($username)) {
                return false;
            }

            // ~ Get the user from the database
            $stmt = $this->$db->prepare('SELECT * FROM users WHERE username = ?');
            $stmt->bind_param('s', $username);
            $stmt->execute();

            // ~ Get the result
            $result = $stmt->get_result();

            // ~ Get the user
            $user = $result->fetch_assoc();

            // ~ If the password does not match, return
            if (!password_verify($password, $user['password'])) {
                return false;
            }

            // ~ Set the session
            $_SESSION['user_id'] = $user['id'];

            // ~ Return whether the user was logged in
            return true;
        }

        /**
         * Create a task
         * @param {integer} $name The task name
         * @param {string} $name The task name
         * @param {string} $type The task type
         * @return {boolean} Whether the task was created
         */
        public function create_task($user_id, $name, $type) {
            // ~ Insert the task into the database
            $stmt = $this->$db->prepare('INSERT INTO tasks (user_id, name, type) VALUES (?, ?, ?)');
            $stmt->bind_param('iss', $user_id, $name, $type);
            $stmt->execute();

            // ~ Return whether the task was created
            return true;
        }

        /**
         * Get all tasks
         * @param {integer} $user_id The user id
         * @return {array} The tasks
         */
        public function get_tasks($user_id) {
            // ~ Get the tasks from the database
            $stmt = $this->$db->prepare('SELECT * FROM tasks WHERE user_id = ?');
            $stmt->bind_param('i', $user_id);
            $stmt->execute();

            // ~ Get the result
            $result = $stmt->get_result();

            // ~ Get the tasks
            $tasks = $result->fetch_all(MYSQLI_ASSOC);

            // ~ Return the tasks
            return $tasks;
        }
    }

?>