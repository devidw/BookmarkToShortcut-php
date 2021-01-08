<?php
define('DS', DIRECTORY_SEPARATOR);
require_once '..'.DS.'BookmarkToShortcut.php';

$converter = new BookmarkToShortcut(
  __DIR__.DS.'in', // source directory
  __DIR__.DS.'out', // destination directory
  ['url', 'webloc', 'desktop'] // formats to write
);

$converter->convert();
