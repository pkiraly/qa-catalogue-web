<?php

namespace Utils;

enum SchemaType: String {
  case MARC21  = 'MARC21';
  case PICA    = 'PICA';
  case UNIMARC = 'UNIMARC';
}