<?php
define('DS', DIRECTORY_SEPARATOR);
require_once '..'.DS.'Bookmarks2urlFiles.class.php';

$converter = new Bookmarks2urlFiles(
  __DIR__.DS.'in', // input directory
  __DIR__.DS.'out' // output destination
);

$converter->convert();
