<?php

class PerchRunwayValetDriver extends BasicValetDriver
{
    private $folders = ['admin', 'perch', 'site_admin'];

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
      $folder = $this->getFolder($sitePath); 

      if ($folder && strpos($uri, $folder) === false) {
        return is_dir($sitePath. '/' . $folder . '/core/runway'); 
      }

      return false;
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

      $folder = $this->getFolder($sitePath);
      
      if (strpos($uri, $folder) !== false) {
        return parent::frontControllerPath(
          $sitePath, $siteName, $uri
        );
      }

      return parent::frontControllerPath(
        $sitePath, $siteName, '/' . $folder . '/core/runway/start.php'
      );
    }

    /**
     * Get active folder of project
     *
     * @param  string  $sitePath
     * @return string
     */
    protected function getFolder($sitePath) {
      $activeFolder = false;

      foreach ($this->folders as $folder) {
        $isDirectory = is_dir($sitePath. '/' . $folder . '/core/runway'); ;
        if ($isDirectory) {
          $activeFolder = $folder;
          break;
        }
      }

      return $activeFolder;
    }
}