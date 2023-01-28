<?php
  // ~ Ensure that this file is only called from the server
  if (!isset($_SERVER['HTTP_HOST'])) {
    // ~ Return a 403 Forbidden
    http_response_code(403);
    echo 'Forbidden.';
    return;
  }

  /**
   * Password class
   */
  class Password {

    /**
     * Verify that a password is valid
     * @param {string} $password The password to verify
     */
    public static function verify($password) {
      // ~ If the password is empty, return
      if (empty($password)) {
        return false;
      }

      // ~ If the password is less than 8 characters, return
      if (strlen($password) < 8) {
        return false;
      }

      // ~ If the password is valid, return
      return true;
    }
  }
?>