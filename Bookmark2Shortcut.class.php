<?php

/**
 * Bookmark2Shortcut
 *
 * @author David Wolf
 */
class Bookmark2Shortcut
{

  public $inDir;
  public $outDir;
  public $formats;
  public $supportedFormats;

  /**
   * @param string $inDir
   * @param string $outDir
   * @param array $formats
   */
  function __construct(
    string $inDir,
    string $outDir,
    array $formats
  ) {
    // file paths
    foreach ([$inDir, $outDir] as $dir) {
      if (!file_exists($dir)) {
        throw new \Exception("directory $dir doesn't exist");
      }
    }
    $this->inDir = $inDir;
    $this->outDir = $outDir;

    // formats
    $this->supportedFormats = ['url', 'webloc', 'desktop'];
    foreach ($formats as $format) {
      if (!in_array($format, $formats)) {
        throw new \Exception("format $format isn't supported");
      }
    }
    $this->formats = $formats;
  }

  /**
   * get array of files inside input directory
   * @return array
   */
  private function getInFiles(): array
  {
    $htmlFiles = glob(
      $this->inDir.DIRECTORY_SEPARATOR.'*.{html, htm}',
      GLOB_BRACE
    );

    $validFiles = array_filter($htmlFiles, 'is_file');

    if (!empty($validFiles)) {
      return $validFiles;
    } else {
      throw new \Exception("No valid file in $this->inDir");
    }
  }

  /**
   * parse bookmarks file to get all bookmarks
   * @param string $file
   * @return array
   */
  private function parse(string $file): array
  {
    $out = [];
    $dom = DOMDocument::loadHTMLFile($file);
    $anchors = $dom->getElementsByTagName('a');
    // print_r($a);
    foreach ($anchors as $a) {
      $out[$a->textContent] = $a->getAttribute('href');
    }
    // print_r($out);
    return $out;
  }

 /**
  * generate .url file contents
  * @param string $url
  * @return string
  */
  private function urlContents(string $url): string
  {
    return <<<FILE
    [InternetShortcut]
    URL=$url
    FILE;
    // IconFile=$url/favicon.ico
    // IconIndex=1
  }

 /**
  * generate .webloc file contents
  * @param string $url
  * @return string
  */
  private function weblocContents(string $url): string
  {
    return <<<XML
    <?xml version="1.0" encoding="UTF-8"?>
    <!DOCTYPE plist PUBLIC "-//Apple//DTD PLIST 1.0//EN" "http://www.apple.com/DTDs/PropertyList-1.0.dtd">
    <plist version="1.0">
      <dict>
      	<key>URL</key>
      	<string>$url</string>
      </dict>
    </plist>
    XML;
  }

 /**
  * generate .desktop file contents
  * @param string $name
  * @param string $url
  * @return string
  */
  private function desktopContents(string $name, string $url): string
  {
    return <<<FILE
    [Desktop Entry]
    Encoding=UTF-8
    Icon=text-html
    Type=Link
    Name=$name
    URL=$url
    FILE;
  }

  /**
   * write files
   * @param string $name
   * @param string $contents
   * @return void
   */
  private function writeFile(
    string $name,
    string $format,
    string $contents
  ): void {
    // https://www.askingbox.com/tip/php-remove-invalid-characters-from-file-names
    $name = str_replace(
      ['\\', '/', ':', '*', '?', '"', '<', '>', '|'], // search for
      '', // replace with
      $name // in subject
    );

    $bytes = file_put_contents(
      $this->outDir.DIRECTORY_SEPARATOR."$name.$format",
      $contents
    );

    echo "$name ($format, $bytes Bytes)<br>\n";
  }

  /**
   * go through each files bookmarks
   * @return void
   */
  public function convert(): void
  {
    // go through files
    foreach ($this->getInFiles() as $file) {
      $bookmarks = $this->parse($file);
      // go through bookmarks
      foreach ($bookmarks as $name => $url) {
        // go through formats
        foreach ($this->formats as $format) {
          switch ($format) {
            case 'url':
              $contents = $this->urlContents($url);
              break;
            case 'webloc':
              $contents = $this->weblocContents($url);
              break;
            case 'desktop':
              $contents = $this->desktopContents($name, $url);
              break;
            default:
              // shouldn't be a case because of constructor validation
              break;
          }
          $this->writeFile($name, $format, $contents);
        }
      }
    }
  }

}
