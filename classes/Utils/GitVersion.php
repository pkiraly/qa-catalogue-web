<?php

namespace Utils;

class GitVersion {

  private static function extractVersion() {
    return array_filter([
      "tag" => trim(`git tag --points-at HEAD | head -1` ?? ""),
      "branch" => trim(`git rev-parse --abbrev-ref HEAD` ?? ""),
      "dirty" => trim(`git diff --quiet; echo $?` ?? ""),
      "commit" => trim(`git rev-parse` ?? ""),
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

  public static function getVersion() {
    $version = [];
    if (empty($version) && file_exists("version.ini")) {
      $version = parse_ini_file("version.ini");
    } else if (is_dir(".git")) {
      $version = self::extractVersion();
    }
    return $version;
  }

}
