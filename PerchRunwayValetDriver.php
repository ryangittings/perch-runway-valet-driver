<?php

class PerchRunwayValetDriver extends BasicValetDriver
{
    /**
     * Determine if the driver serves the request.
     *
     * @param  string  $sitePath
     * @param  string  $siteName
     * @param  string  $uri
     * @return bool
     */
    public function serves($sitePath, $siteName, $uri)
    {
        if (strpos($uri, 'admin') !== false || strpos($uri, 'perch') !== false) {
          return false;
        }

        
        return is_dir($sitePath.'/admin/core/runway');
    }

    /**
     * Get the fully resolved path to the application's front controller.
     *
     * @param  string  $sitePath
     * @param  string  $siteName
     * @param  string  $uri
     * @return string
     */
    public function frontControllerPath($sitePath, $siteName, $uri)
    {
        $_SERVER['PHP_SELF']    = $uri;
        $_SERVER['SERVER_ADDR'] = '127.0.0.1';
        $_SERVER['SERVER_NAME'] = $_SERVER['HTTP_HOST'];
        
        if (strpos($uri, 'admin') !== false || strpos($uri, 'perch') !== false) {
          return parent::frontControllerPath(
            $sitePath, $siteName, $uri
          );
        }

        return parent::frontControllerPath(
          $sitePath, $siteName, '/admin/core/runway/start.php'
        );
    }
}