<?php
define('DS', DIRECTORY_SEPARATOR);
require_once '..'.DS.'BookmarkToShortcut.class.php';

$converter = new BookmarkToShortcut(
  __DIR__.DS.'in', // source
  __DIR__.DS.'out', // destination
  ['url', 'webloc', 'desktop'] // formats to write
);

$converter->convert();
