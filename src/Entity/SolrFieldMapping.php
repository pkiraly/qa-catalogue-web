<?php


namespace App\Entity;


class SolrFieldMapping
{

  private static $map = [
    '100a' => '100a_MainPersonalName_personalName_ss',
    '100d' => '100d_MainPersonalName_dates_ss',
    '260a' => '260a_Publication_place_ss',
    '260b' => '260b_Publication_agent_ss',
    '260c' => '260c_Publication_date_ss',
    '300a' => '300a_PhysicalDescription_extent_ss',
    '300c' => '300c_PhysicalDescription_dimensions_ss',
    '490a' => '490a_SeriesStatement_ss',
    '520a' => '520a_Summary_ss',
    '650a' => '650a_Topic_topicalTerm_ss',
    '650b' => '650b_Topic_topicalTerm_ss',
    '650v' => '650v_Topic_formSubdivision_ss',
    '650x' => '650x_Topic_generalSubdivision_ss',
    '650y' => '650y_Topic_chronologicalSubdivision_ss',
    '650z' => '650z_Topic_geographicSubdivision_ss',
    '6500' => '6500_Topic_authorityRecordControlNumber_ss',
    '651a' => '651a_Geographic_ss',
    '651v' => '651v_Geographic_formSubdivision_ss',
    '651x' => '651x_Geographic_generalSubdivision_ss',
    '651y' => '651y_Geographic_chronologicalSubdivision_ss',
    '651z' => '651z_Geographic_geographicSubdivision_ss',
    '6510' => '6510_Geographic_authorityRecordControlNumber_ss',
    '9129' => '9129_WorkIdentifier_ss',
    '9119' => '9119_ManifestationIdentifier_ss',
    // '' => '',
    '700a' => '700a_AddedPersonalName_personalName_ss',
    '700d' => '700d_AddedPersonalName_dates_ss',
    '710a' => '710a_AddedCorporateName_ss',
    '710d' => '710d_AddedCorporateName_dates_ss',
  ];

  public static function getSolrField($marc) {
    if (isset(self::$map[$marc]))
      return self::$map[$marc];
    return null;
  }
}