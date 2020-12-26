# Bookmark to Shortcut

Convert your browser bookmarks to web shortcut files (`.url`, `.webloc`, `.desktop`) to be able to use them on your desktop and in your file explorer.

## How to convert

1. download `BookmarkToShortcut.class.php`
2. export bookmarks from browsers bookmark manager
    - [opera://bookmarks](opera://bookmarks)
    - [chrome://bookmarks](chrome://bookmarks)
    - [edge://favorites](edge://favorites)
3. convert bookmarks with the following snippet or see `/test/usage.php`

```php
  // require downloaded class
  require 'BookmarkToShortcut.class.php';

  // create new class instance
  $converter = new BookmarkToShortcut(
    'in', // source directory
    'out' // destination directory
    ['url', 'webloc', 'desktop'] // generate files in these formats
  );

  // call convert method
  $converter->convert();
```

## Compatibility
- works with `NETSCAPE-Bookmark-file-1` exports
- tested for exports from Chromium browsers (Opera, Chrome, Edge), see `/test/in`
- supported shortcut formats, see `/test/out`
    - `.url` (Windows)
    - `.webloc` (Mac OSX)
    - `.desktop` (Linux)
