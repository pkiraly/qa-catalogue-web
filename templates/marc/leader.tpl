<p>
  Leader: {$record->getFirstField('Leader_ss', TRUE)}<br/>
  type*: {$record->getFirstField('type_ss')}<br>
  Leader contains general information. It is a row of fixed-length data elements, such that
  there is no formal separators between elements, only the standard sets the boundaries
  by its positions (e.g. 00-04 means that the part of the whole string from 0th to 4th character).
  Some parts contain numeric values, such as lenght of the record, some others contain
  encoded information (e.g. in 6th position "a" means <em>Language material</em>).
</p>
<table>
  <thead>
  <tr>
    <th>pos.</th>
    <th>field</th>
    <th>value</th>
    <th>meaning</th>
  </tr>
  </thead>
  <tbody>
  <tr>
    <td>00-04</td>
    <td>length:</td>
    <td>{$record->getLeaderByPosition(0, 4)}</td>
    <td>{* $record->getFirstField('Leader_00-04_recordLength_ss') *}</td>
  </tr>
  <tr>
    <td>05</td>
    <td>record status:</td>
    <td>{$record->getLeaderByPosition(5)}</td>
    <td>{$record->getFirstField('Leader_05_recordStatus_ss')}</td>
  </tr>
  <tr>
    <td>06</td>
    <td>type of record:</td>
    <td>{$record->getLeaderByPosition(6)}</td>
    <td>{$record->getFirstField('Leader_06_typeOfRecord_ss')}</td>
  </tr>
  <tr>
    <td>07</td>
    <td>bibliographic level:</td>
    <td>{$record->getLeaderByPosition(7)}</td>
    <td>{$record->getFirstField('Leader_07_bibliographicLevel_ss')}</td>
  </tr>
  <tr>
    <td>08</td>
    <td>type of control:</td>
    <td>{$record->getLeaderByPosition(8)}</td>
    <td>{$record->getFirstField('Leader_08_typeOfControl_ss')}</td>
  </tr>
  <tr>
    <td>09</td>
    <td>character coding scheme:</td>
    <td>{$record->getLeaderByPosition(9)}</td>
    <td>{$record->getFirstField('Leader_09_characterCodingScheme_ss')}</td>
  </tr>
  <tr>
    <td>10</td>
    <td>indicator count:</td>
    <td>{$record->getLeaderByPosition(10)}</td>
    <td>{* $record->getFirstField('Leader_10_indicatorCount_ss') *}</td>
  </tr>
  <tr>
    <td>11</td>
    <td>subfield code count:</td>
    <td>{$record->getLeaderByPosition(11)}</td>
    <td>{* $record->getFirstField('Leader_11_subfieldCodeCount_ss') *}</td>
  </tr>
  <tr>
    <td>12-16</td>
    <td>base address of data:</td>
    <td>{$record->getLeaderByPosition(12, 16)}</td>
    <td>{* $record->getFirstField('Leader_12-16_baseAddressOfData_ss') *}</td>
  </tr>
  <tr>
    <td>17</td>
    <td>encoding level:</td>
    <td>{$record->getLeaderByPosition(17)}</td>
    <td>{$record->getFirstField('Leader_17_encodingLevel_ss')}</td>
  </tr>
  <tr>
    <td>18</td>
    <td>descriptive cataloging form:</td>
    <td>{$record->getLeaderByPosition(18)}</td>
    <td>{$record->getFirstField('Leader_18_descriptiveCatalogingForm_ss')}</td>
  </tr>
  <tr>
    <td>19</td>
    <td>multipart resource record level:</td>
    <td>{$record->getLeaderByPosition(19)}</td>
    <td>{$record->getFirstField('Leader_19_multipartResourceRecordLevel_ss')}</td>
  </tr>
  <tr>
    <td>20</td>
    <td>length of field portion:</td>
    <td>{$record->getLeaderByPosition(20)}</td>
    <td>{* $record->getFirstField('Leader_20_lengthOfTheLengthOfFieldPortion_ss') *}</td>
  </tr>
  <tr>
    <td>21</td>
    <td>length of the starting character position portion:</td>
    <td>{$record->getLeaderByPosition(21)}</td>
    <td>{* $record->getFirstField('Leader_21_lengthOfTheStartingCharacterPositionPortion_ss') *}</td>
  </tr>
  <tr>
    <td>22</td>
    <td>length of the implementation defined portion:</td>
    <td>{$record->getLeaderByPosition(22)}</td>
    <td>{* $record->getFirstField('Leader_22_lengthOfTheImplementationDefinedPortion_ss') *}</td>
  </tr>
  <tr>
    <td>23</td>
    <td>undefined</td>
    <td>0</td>
    <td></td>
  </tr>
  </tbody>
</table>

<p>* Type comes from the combination of type of record (06) and bibliographic level (07) positions.
  See 'Dependencies' section of
  <a href="https://www.loc.gov/marc/bibliographic/bdleader.html" target="_blank">Leader</a></p>