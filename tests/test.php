<?php

require_once dirname(__DIR__) . '/src/BookmarkToShortcut.php';

use Devidw\BookmarkToShortcut\BookmarkToShortcut;

$converter = new BookmarkToShortcut(
  __DIR__ . '/in', // source directory
  __DIR__ . '/out', // destination directory
  ['url', 'webloc', 'desktop'] // formats to write
);

$converter->convert();
