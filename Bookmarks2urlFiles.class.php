<?php

/**
 * Bookmarks2urlFiles
 *
 * @author David Wolf
 */
class Bookmarks2urlFiles
{

  public $inDir;
  public $outputDir;
  private $invalidFilenameChars;

  /**
   * @param string $inDir
   * @param string $outputDir
   */
  function __construct(string $inDir, string $outputDir)
  {
    array_map(
      function($path) {
        if (file_exists($path)) {
          return true;
        } else {
          throw new \Exception("$path doesn't exist");
        }
      },
      func_get_args()
    );

    $this->inDir = $inDir;
    $this->outputDir = $outputDir;
    $this->invalidFilenameChars = ['\\', '/', ':', '*', '?', '"', '<', '>', '|'];
  }

  /**
   * go through each files bookmarks
   */
  public function convert(): void
  {
    // go through files
    foreach ($this->getInFiles() as $file) {
      $bookmarks = $this->parse($file);

      // go through file bookmarks
      foreach ($bookmarks as $name => $url) {
        $this->writeURL($name, $url);
      }
    }
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
   * write .url files
   * @param string $name
   * @param string $url
   */
  private function writeURL(string $name, string $url): void
  {
    $contents = <<< FILE
    [InternetShortcut]
    URL=$url
    FILE;
    // IconFile=$url/favicon.ico
    // IconIndex=1

    // https://www.askingbox.com/tip/php-remove-invalid-characters-from-file-names
    $name = str_replace(
      $this->invalidFilenameChars, // search for
      '', // replace with
      $name // in subject
    );

    $bytes = file_put_contents(
      $this->outputDir.DIRECTORY_SEPARATOR."$name.url",
      $contents
    );

    echo "$name ($bytes Bytes)<br>\n";
  }

}
