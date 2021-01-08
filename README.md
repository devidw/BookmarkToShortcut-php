# Bookmark to Shortcut

Convert your browser bookmarks to web shortcut files (`.url`, `.webloc`, `.desktop`) to be able to use them on your desktop and in your file explorer.

## How to convert
First you have to export your bookmarks from your browsers, use the following links to navigate directly to your browsers bookmark manager.
  - [opera://bookmarks](opera://bookmarks)
  - [chrome://bookmarks](chrome://bookmarks)
  - [edge://favorites](edge://favorites)

### Using Python
Download `/python/BookmarkToShortcut.py`

```python
  from BookmarkToShortcut import BookmarkToShortcut

  converter = BookmarkToShortcut(
      './in', # input directory
      './out', # output directory
      {'url', 'desktop', 'webloc'} # formats to write
  )

  converter.convert()
```

### Using PHP
Download `/php/BookmarkToShortcut.php`

```php
require_once 'BookmarkToShortcut.php';

$converter = new BookmarkToShortcut(
  './in', // input directory
  './out', // output directory
  ['url', 'webloc', 'desktop'] // formats to write
);

$converter->convert();
```

## Compatibility
- works with `NETSCAPE-Bookmark-file-1` exports
- tested for exports from Chromium browsers (Opera, Chrome, Edge)
- supported shortcut formats
    - `.url` (Windows)
    - `.webloc` (Mac OSX)
    - `.desktop` (Linux)
