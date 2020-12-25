# Bookmarks to URL-Files

Convert your browser bookmarks to .url files to be able to use them on your  desktop / in your file explorer.

## How to convert

1. download `Bookmarks2urlFiles.class.php`
2. export bookmarks from browsers bookmark manager
  - [opera://bookmarks](opera://bookmarks)
  - [chrome://bookmarks](chrome://bookmarks)
  - [edge://favorites/](edge://favorites)
3. convert bookmarks with the following snippment or see `/test/usage.php`

```
  // require downloaded class
  require 'Bookmarks2urlFiles.class.php';

  // create new class instance
  $converter = new Bookmarks2urlFiles(
    'in', // input directory
    'out' // output directory
  );

  // call convert method
  $converter->convert();
```

## Compatibility
- works with `NETSCAPE-Bookmark-file-1` exports
- tested in Chromium browsers (Opera, Chrome, Edge)
