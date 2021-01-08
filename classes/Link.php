<?php


class Link {
  public $text;
  public $url;

  /**
   * Item constructor.
   * @param $text
   * @param $url
   */
  public function __construct($text, $url) {
    $this->text = $text;
    $this->url = $url;
  }

  public static function create($text, $base, $extension) {
    $url = join('&', array_merge($base, $extension));
    return new self($text, $url);
  }

  public static function withStart($text, $base, $value) {
    return self::create($text, $base, ['start=' . $value]);
  }

  public static function withRows($text, $base, $value) {
    return self::create($text, $base, ['start=0', 'rows=' . $value]);
  }

  public static function withFilter($text, $base, $value) {
    return self::create($text, $base, ['filter[]=' . $value]);
  }

  public static function withQuery($text, $base, $value) {
    return self::create($text, $base, ['query=' . urlencode($value)]);
  }
}