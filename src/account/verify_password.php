<?php
  // ~ Ensure that this file is only called from the server
  if (!isset($_SERVER['HTTP_HOST'])) {
    // ~ Return a 403 Forbidden
    http_response_code(403);
    echo 'Forbidden.';
    return;
  }

  /**
   * Verify that a password is valid
   * @param {string} $password The password to verify
   */
  function verify_password($password) {
    // ~ If the password is empty, return
    if (empty($password)) {
      return false;
    }

    // ~ If the password is less than 8 characters, return
    if (strlen($password) < 8) {
      return false;
    }

    // ~ If the password does not contain a number, return
    if (!preg_match('/[0-9]/', $password)) {
      return false;
    }

    // ~ If the password does not contain a lowercase letter, return
    if (!preg_match('/[a-z]/', $password)) {
      return false;
    }

    // ~ If the password does not contain an uppercase letter, return
    if (!preg_match('/[A-Z]/', $password)) {
      return false;
    }

    // ~ If the password does not contain a special character, return
    if (!preg_match('/[!@#$%^&*()\-_=+{};:,<.>]/', $password)) {
      return false;
    }

    // ~ If the password is valid, return
    return true;
  }
?>