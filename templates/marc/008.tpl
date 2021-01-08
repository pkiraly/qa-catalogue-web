{assign var="type" value=$record->getFirstField('type_ss')}
<p>
  008: {$record->getFirstField('008_GeneralInformation_ss', TRUE)}<br/>
  type*: {$type}<br/>
  Field 008 contains general information. It is a row of fixed-length data elements, such that
  there is no formal separators between elements, only the standard sets the boundaries
  by its positions (e.g. 00-05 means that the part of the whole string from 0th to 5th character).
  008 separates the string into three blocks: from 0 to 17th position it encodes general
  information, from 18th to 34th comes information specific to the record's type, and from 35th
  till the end of the string the general information continues.
  Some parts contain numeric values, such as length of the record, some others contain
  encoded information (e.g. in 6th position "s" means <em>Single known date/probable date</em>).
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
    <td colspan="4"><strong>General</strong></td>
  </tr>
  <tr>
    <td>00-05</td>
    <td>Date entered on file:</td>
    <td>{$record->get008ByPosition(0, 6)}</td>
    <td>{$record->formatMarcDate($record->getFirstField('008_00-05_GeneralInformation_dateEnteredOnFile_ss'))}</td>
  </tr>
  <tr>
    <td>06</td>
    <td>Type of date/Publication status:</td>
    <td>{$record->get008ByPosition(6)}</td>
    <td>{$record->getFirstField('008_06_GeneralInformation_typeOfDateOrPublicationStatus_ss')}</td>
  </tr>
  <tr>
    <td>07-10</td>
    <td>Date 1:</td>
    <td>{$record->get008ByPosition(7, 11)}</td>
    <td>{$record->getFirstField('008_07-10_GeneralInformation_date1_ss')}</td>
  </tr>
  <tr>
    <td>11-14</td>
    <td>Date 2:</td>
    <td>{$record->get008ByPosition(11, 15)}</td>
    <td>{$record->getFirstField('008_11-14_GeneralInformation_date2_ss')}</td>
  </tr>
  <tr>
    <td>15-17</td>
    <td>Place of publication, production, or execution:</td>
    <td>{$record->get008ByPosition(15, 18)}</td>
    <td>{$record->getFirstField('008_15-17_GeneralInformation_placeOfPublicationProductionOrExecution_ss')}</td>
  </tr>
  <tr>
    <td colspan="4"><strong>{$type}</strong></td>
  </tr>
{if $type == 'Books'}
  <tr>
    <td>18-21</td>
    <td>Illustrations:</td>
    <td>{$record->get008ByPosition(18, 22)}</td>
    <td>{$record->getFirstField('008_18-21_GeneralInformation_illustrations_ss')}</td>
  </tr>
  <tr>
    <td>22</td>
    <td>Target audience:</td>
    <td>{$record->get008ByPosition(22)}</td>
    <td>{$record->getFirstField('008_22_GeneralInformation_targetAudience_ss')}</td>
  </tr>
  <tr>
    <td>23</td>
    <td>Form of item:</td>
    <td>{$record->get008ByPosition(23)}</td>
    <td>{$record->getFirstField('008_23_GeneralInformation_formOfItem_ss')}</td>
  </tr>
  <tr>
    <td>24-27</td>
    <td>Nature of contents:</td>
    <td>{$record->get008ByPosition(24, 28)}</td>
    <td>{$record->getFirstField('008_24-27_GeneralInformation_natureOfContents_ss')}</td>
  </tr>
  <tr>
    <td>28</td>
    <td>Government publication:</td>
    <td>{$record->get008ByPosition(28)}</td>
    <td>{$record->getFirstField('008_28_GeneralInformation_governmentPublication_ss')}</td>
  </tr>
  <tr>
    <td>29</td>
    <td>Conference publication:</td>
    <td>{$record->get008ByPosition(29)}</td>
    <td>{$record->getFirstField('008_29_GeneralInformation_conferencePublication_ss')}</td>
  </tr>
  <tr>
    <td>30</td>
    <td>Festschrift:</td>
    <td>{$record->get008ByPosition(30)}</td>
    <td>{$record->getFirstField('008_30_GeneralInformation_festschrift_ss')}</td>
  </tr>
  <tr>
    <td>31</td>
    <td>Index:</td>
    <td>{$record->get008ByPosition(31)}</td>
    <td>{$record->getFirstField('008_31_GeneralInformation_index_ss')}</td>
  </tr>
  <tr>
    <td>33</td>
    <td>Literary form:</td>
    <td>{$record->get008ByPosition(33)}</td>
    <td>{$record->getFirstField('008_33_GeneralInformation_literaryForm_ss')}</td>
  </tr>
  <tr>
    <td>34</td>
    <td>Biography:</td>
    <td>{$record->get008ByPosition(34)}</td>
    <td>{$record->getFirstField('008_34_GeneralInformation_biography_ss')}</td>
  </tr>
{elseif $type == 'Maps'}
  <tr>
    <td>18-21</td>
    <td>Relief:</td>
    <td>{$record->get008ByPosition(18, 22)}</td>
    <td>{$record->getFirstField('008_18-21_GeneralInformation_relief_ss')}</td>
  </tr>
  <tr>
    <td>22-23</td>
    <td>Projection:</td>
    <td>{$record->get008ByPosition(22, 24)}</td>
    <td>{$record->getFirstField('008_22-23_GeneralInformation_projection_ss')}</td>
  </tr>
  <tr>
    <td>25</td>
    <td>Type of cartographic material:</td>
    <td>{$record->get008ByPosition(25)}</td>
    <td>{$record->getFirstField('008_25_GeneralInformation_typeOfCartographicMaterial_ss')}</td>
  </tr>
  <tr>
    <td>28</td>
    <td>Government publication:</td>
    <td>{$record->get008ByPosition(28)}</td>
    <td>{$record->getFirstField('008_28_GeneralInformation_governmentPublication_ss')}</td>
  </tr>
  <tr>
    <td>29</td>
    <td>Form of item:</td>
    <td>{$record->get008ByPosition(29)}</td>
    <td>{$record->getFirstField('008_29_GeneralInformation_formOfItem_ss')}</td>
  </tr>
  <tr>
    <td>31</td>
    <td>Index:</td>
    <td>{$record->get008ByPosition(31)}</td>
    <td>{$record->getFirstField('008_31_GeneralInformation_index_ss')}</td>
  </tr>
  <tr>
    <td>33-34</td>
    <td>Special format characteristics:</td>
    <td>{$record->get008ByPosition(33, 35)}</td>
    <td>{$record->getFirstField('008_33-34_GeneralInformation_specialFormatCharacteristics_ss')}</td>
  </tr>
{elseif $type == 'Computer Files'}
  <tr>
    <td>22</td>
    <td>Target audience:</td>
    <td>{$record->get008ByPosition(22)}</td>
    <td>{$record->getFirstField('008_22_GeneralInformation_targetAudience_ss')}</td>
  </tr>
  <tr>
    <td>23</td>
    <td>Form of item:</td>
    <td>{$record->get008ByPosition(23)}</td>
    <td>{$record->getFirstField('008_23_GeneralInformation_formOfItem_ss')}</td>
  </tr>
  <tr>
    <td>26</td>
    <td>Type of computer file:</td>
    <td>{$record->get008ByPosition(26)}</td>
    <td>{$record->getFirstField('008_26_GeneralInformation_typeOfComputerFile_ss')}</td>
  </tr>
  <tr>
    <td>28</td>
    <td>Government publication:</td>
    <td>{$record->get008ByPosition(28)}</td>
    <td>{$record->getFirstField('008_28_GeneralInformation_governmentPublication_ss')}</td>
  </tr>
{elseif $type == 'Music'}
  <tr>
    <td>18-19</td>
    <td>Form of composition:</td>
    <td>{$record->get008ByPosition(18, 20)}</td>
    <td>{$record->getFirstField('008_18-19_GeneralInformation_formOfComposition_ss')}</td>
  </tr>
  <tr>
    <td>20</td>
    <td>Format of music:</td>
    <td>{$record->get008ByPosition(20)}</td>
    <td>{$record->getFirstField('008_20_GeneralInformation_formatOfMusic_ss')}</td>
  </tr>
  <tr>
    <td>21</td>
    <td>Music parts:</td>
    <td>{$record->get008ByPosition(21)}</td>
    <td>{$record->getFirstField('008_21_GeneralInformation_musicParts_ss')}</td>
  </tr>
  <tr>
    <td>22</td>
    <td>Target audience:</td>
    <td>{$record->get008ByPosition(22)}</td>
    <td>{$record->getFirstField('008_22_GeneralInformation_targetAudience_ss')}</td>
  </tr>
  <tr>
    <td>23</td>
    <td>Form of item:</td>
    <td>{$record->get008ByPosition(23)}</td>
    <td>{$record->getFirstField('008_23_GeneralInformation_formOfItem_ss')}</td>
  </tr>
  <tr>
    <td>24-29</td>
    <td>Form of item:</td>
    <td>{$record->get008ByPosition(24, 30)}</td>
    <td>{$record->getFirstField('008_24-29_GeneralInformation_accompanyingMatter_ss')}</td>
  </tr>
  <tr>
    <td>30-31</td>
    <td>Literary text for sound recordings:</td>
    <td>{$record->get008ByPosition(30, 32)}</td>
    <td>{$record->getFirstField('008_30-31_GeneralInformation_literaryTextForSoundRecordings_ss')}</td>
  </tr>
  <tr>
    <td>33</td>
    <td>Transposition and arrangement:</td>
    <td>{$record->get008ByPosition(33)}</td>
    <td>{$record->getFirstField('008_33_GeneralInformation_transpositionAndArrangement_ss')}</td>
  </tr>
{elseif $type == 'Continuing Resources'}
  <tr>
    <td>18</td>
    <td>Frequency:</td>
    <td>{$record->get008ByPosition(18)}</td>
    <td>{$record->getFirstField('008_18_GeneralInformation_frequency_ss')}</td>
  </tr>
  <tr>
    <td>19</td>
    <td>Regularity:</td>
    <td>{$record->get008ByPosition(19)}</td>
    <td>{$record->getFirstField('008_19_GeneralInformation_regularity_ss')}</td>
  </tr>
  <tr>
    <td>21</td>
    <td>Type of continuing resource:</td>
    <td>{$record->get008ByPosition(21)}</td>
    <td>{$record->getFirstField('008_21_GeneralInformation_typeOfContinuingResource_ss')}</td>
  </tr>
  <tr>
    <td>22</td>
    <td>Form of original item:</td>
    <td>{$record->get008ByPosition(22)}</td>
    <td>{$record->getFirstField('008_22_GeneralInformation_formOfOriginalItem_ss')}</td>
  </tr>
  <tr>
    <td>23</td>
    <td>Form of item:</td>
    <td>{$record->get008ByPosition(23)}</td>
    <td>{$record->getFirstField('008_23_GeneralInformation_formOfItem_ss')}</td>
  </tr>
  <tr>
    <td>24</td>
    <td>Nature of entire work:</td>
    <td>{$record->get008ByPosition(24)}</td>
    <td>{$record->getFirstField('008_24_GeneralInformation_natureOfEntireWork_ss')}</td>
  </tr>
  <tr>
    <td>25-27</td>
    <td>Nature of contents:</td>
    <td>{$record->get008ByPosition(25, 28)}</td>
    <td>{$record->getFirstField('008_25-27_GeneralInformation_natureOfContents_ss')}</td>
  </tr>
  <tr>
    <td>28</td>
    <td>Government publication:</td>
    <td>{$record->get008ByPosition(28)}</td>
    <td>{$record->getFirstField('008_28_GeneralInformation_governmentPublication_ss')}</td>
  </tr>
  <tr>
    <td>29</td>
    <td>Conference publication:</td>
    <td>{$record->get008ByPosition(29)}</td>
    <td>{$record->getFirstField('008_29_GeneralInformation_conferencePublication_ss')}</td>
  </tr>
  <tr>
    <td>33</td>
    <td>Original alphabet or script of title:</td>
    <td>{$record->get008ByPosition(33)}</td>
    <td>{$record->getFirstField('008_33_GeneralInformation_originalAlphabetOrScriptOfTitle_ss')}</td>
  </tr>
  <tr>
    <td>34</td>
    <td>Entry convention:</td>
    <td>{$record->get008ByPosition(34)}</td>
    <td>{$record->getFirstField('008_34_GeneralInformation_entryConvention_ss')}</td>
  </tr>
{elseif $type == 'Visual Materials'}
  <tr>
    <td>18-20</td>
    <td>Running time for motion pictures and videorecordings:</td>
    <td>{$record->get008ByPosition(18, 21)}</td>
    <td>{$record->getFirstField('008_18-20_GeneralInformation_runningTime_ss')}</td>
  </tr>
  <tr>
    <td>22</td>
    <td>Target audience:</td>
    <td>{$record->get008ByPosition(22)}</td>
    <td>{$record->getFirstField('008_22_GeneralInformation_targetAudience_ss')}</td>
  </tr>
  <tr>
    <td>28</td>
    <td>Government publication:</td>
    <td>{$record->get008ByPosition(28)}</td>
    <td>{$record->getFirstField('008_28_GeneralInformation_governmentPublication_ss')}</td>
  </tr>
  <tr>
    <td>29</td>
    <td>Form of item:</td>
    <td>{$record->get008ByPosition(29)}</td>
    <td>{$record->getFirstField('008_29_GeneralInformation_formOfItem_ss')}</td>
  </tr>
  <tr>
    <td>33</td>
    <td>Type of visual material:</td>
    <td>{$record->get008ByPosition(33)}</td>
    <td>{$record->getFirstField('008_33_GeneralInformation_typeOfVisualMaterial_ss')}</td>
  </tr>
  <tr>
    <td>34</td>
    <td>Technique:</td>
    <td>{$record->get008ByPosition(34)}</td>
    <td>{$record->getFirstField('008_34_GeneralInformation_technique_ss')}</td>
  </tr>
{elseif $type == 'Mixed Materials'}
  <tr>
    <td>23</td>
    <td>Form of item:</td>
    <td>{$record->get008ByPosition(23)}</td>
    <td>{$record->getFirstField('008_23_GeneralInformation_formOfItem_ss')}</td>
  </tr>
{/if}
  <tr>
    <td colspan="4"><strong>General (continued)</strong></td>
  </tr>
  <tr>
    <td>35-37</td>
    <td>Language:</td>
    <td>{$record->get008ByPosition(35, 38)}</td>
    <td>{$record->getFirstField('008_35-37_GeneralInformation_language_ss')}</td>
  </tr>
  <tr>
    <td>38</td>
    <td>Modified record:</td>
    <td>{$record->get008ByPosition(38)}</td>
    <td>{$record->getFirstField('008_38_GeneralInformation_modifiedRecord_ss')}</td>
  </tr>
  <tr>
    <td>39</td>
    <td>Cataloging source:</td>
    <td>{$record->get008ByPosition(39)}</td>
    <td>{$record->getFirstField('008_39_GeneralInformation_catalogingSource_ss')}</td>
  </tr>
  </tbody>
</table>

<p>* Type comes from the combination of type of record (06) and bibliographic level (07) positions.
  See 'Dependencies' section of
  <a href="https://www.loc.gov/marc/bibliographic/bdleader.html" target="_blank">Leader</a></p>