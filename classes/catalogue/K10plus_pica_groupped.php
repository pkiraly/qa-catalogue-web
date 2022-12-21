<?php


class K10plus_pica_groupped extends Catalogue {

  protected $name = 'k10plus_pica_groupped';
  protected $label = 'K10plus-Verbundkatalog (PICA)';
  protected $url = 'https://opac.k10plus.de';
  protected $schemaType = 'PICA';
  protected $position = 4;
  public static $supportedTypes = [
    'Druckschriften (einschließlich Bildbänden)', 'Tonträger, Videodatenträger, Bildliche Darstellungen',
    'Blindenschriftträger und andere taktile Materialien', 'Mikroform', 'Handschriftliches Material',
    'Lokales Katalogisat (nur GBV)', 'Elektronische Ressource im Fernzugriff', 'Elektronische Ressource auf Datenträger',
    'Objekt', 'Medienkombination', 'Mailboxsatz'
  ];
  protected $defaultLang = 'de';

  function getOpacLink($id, $record) {
    return 'https://opac.k10plus.de/DB=2.299/PPNSET?PPN=' . trim($id) . '&PRS=HOL&HILN=888&INDEXSET=21';
  }

  public function getTag(string $input): string {
    return substr($input, 0, strpos($input, '$'));
  }

  public function getSubfield($input): string {
    return substr($input, strpos($input, '$'));
  }

}
