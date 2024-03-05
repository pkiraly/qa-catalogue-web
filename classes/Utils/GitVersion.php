<?php

namespace Utils;

class GitVersion {

  public static function extractVersion() {
    return array_filter([
      "version" => trim(`git tag --points-at HEAD | head -1` ?? ""),
      "branch" => trim(`git rev-parse --abbrev-ref HEAD` ?? ""),
      "clean" => trim(`git diff --quiet && echo true` ?? ""),
      "commit" => trim(`git rev-parse HEAD` ?? ""),
    ]);
  }

  public static function saveVersion() {
    $ini = "";
    foreach (self::extractVersion() as $key => $value) {
      $ini .= "$key = \"$value\"\n";
    }
    file_put_contents("version.ini", $ini);
  }

  public static function getVersion() {
    $version = [];
    if (is_dir(".git")) {
      $version = self::extractVersion();
    }
    if (empty($version) && file_exists("version.ini")) {
      $version = parse_ini_file("version.ini");
    }
    return $version;
  }

}
