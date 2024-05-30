<?php

namespace Utils;

class GitVersion {

  private static function extractVersion() {
    return array_filter([
      "version" => trim(`git tag --points-at HEAD 2>/dev/null | head -1` ?? ""),
      "branch" => trim(`git rev-parse --abbrev-ref HEAD 2>/dev/null` ?? ""),
      "clean" => trim(`git diff --quiet 2>/dev/null && echo true` ?? ""),
      "commit" => trim(`git rev-parse HEAD 2>/dev/null` ?? ""),
    ]);
  }

  /**
   * @api
   */
  public static function saveVersion() {
    $ini = "";
    foreach (self::extractVersion() as $key => $value) {
      $ini .= "$key = \"$value\"\n";
    }
    file_put_contents("version.ini", $ini);
  }

  public static function getVersion(bool $extractGitVersion = true) {
    $version = [];
    if (is_dir(".git") && $extractGitVersion) {
      $version = self::extractVersion();
    }
    if (empty($version) && file_exists("version.ini")) {
      $version = parse_ini_file("version.ini");
    }
    return $version;
  }

}
