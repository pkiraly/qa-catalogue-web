<?php

namespace Utils;

abstract class SchemaType {
  const MARC21  = 'MARC21';
  const PICA    = 'PICA';
  const UNIMARC = 'UNIMARC';

  public static function tryFrom(string $type): SchemaType {
    switch ($type) {
      case 'MARC21': return SchemaType::MARC21;
      case 'PICA': return SchemaType::PICA;
      case 'UNIMARC': return SchemaType::UNIMARC;
    }
    return SchemaType::MARC21;
  }
}