<?php
define('DS', DIRECTORY_SEPARATOR);
require_once '..'.DS.'Bookmark2Shortcut.class.php';

$converter = new Bookmark2Shortcut(
  __DIR__.DS.'in', // source
  __DIR__.DS.'out', // destination
  ['url', 'webloc', 'desktop'] // formats to write
);

$converter->convert();
