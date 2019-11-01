{foreach $docs as $doc}
  {assign var="id" value=$doc->id|regex_replace:"/ +$/":""}
  <div class="record">
    <h2>
      {if isset($doc->{'245a_Title_mainTitle_ss'})}
        {include 'conditional-foreach.tpl' obj=$doc key='245a_Title_mainTitle_ss'}
        {include 'conditional-foreach.tpl' obj=$doc key='245b_Title_subtitle_ss'}
      {elseif isset($doc->{'773t_PartOf_title_ss'})}
        {include 'conditional-foreach.tpl' obj=$doc key='773t_PartOf_title_ss'}
        {if isset($doc->{'245n_Title_partNumber_ss'})}
          {include 'conditional-foreach.tpl' obj=$doc key='245n_Title_partNumber_ss'}
        {/if}
      {/if}
      <a href="#" class="record-details" data="details-{$id}" title="display details"><i class="fa fa-book" aria-hidden="true"></i></a>
      <a href="{opacLink($doc, $doc->id)}" target="_blank" title="Display record in the library catalogue"><i class="fa fa-external-link" aria-hidden="true"></i></a>
    </h2>
    {if isset($doc->{'245c_Title_responsibilityStatement_ss'})}
      {include 'conditional-foreach.tpl' obj=$doc key='245c_Title_responsibilityStatement_ss'
        label='<i class="fa fa-pencil" aria-hidden="true"></i>' suffix='<br/>'}
    {elseif isset($doc->{'773a_PartOf_ss'})}
      {include 'conditional-foreach.tpl' obj=$doc key='773a_PartOf_ss'
        label='<i class="fa fa-pencil" aria-hidden="true"></i>' suffix='<br/>'}
    {/if}
    {include 'conditional-foreach.tpl' obj=$doc key='250a_Edition_editionStatement_ss'}

    {if hasPublication($doc)}
      <i class="fa fa-calendar" aria-hidden="true"></i>
      Published
      {include 'conditional-foreach.tpl' obj=$doc key='260c_Publication_date_ss' label='in' tag='260c'}
      {include 'conditional-foreach.tpl' obj=$doc key='260a_Publication_place_ss' label='in' tag='260a'}
      {include 'conditional-foreach.tpl' obj=$doc key='260b_Publication_agent_ss' label='by' tag='260b'}
      <br/>
    {/if}

    {if hasPhysicalDescription($doc)}
      {include 'conditional-foreach.tpl' obj=$doc key='300a_PhysicalDescription_extent_ss' tag='300a'}
      {include 'conditional-foreach.tpl' obj=$doc key='300c_PhysicalDescription_dimensions_ss' tag='300c'}
      <br/>
    {/if}

    {if isset($doc->{'490a_SeriesStatement_ss'})}
      Series:
      {foreach $doc->{'490a_SeriesStatement_ss'} as $value}
        <a href="#" class="record-link tag-490a" data="490a_SeriesStatement_ss">{$value}</a>{if !$value@last}, {/if}
      {/foreach}
      {include 'conditional-foreach.tpl' obj=$doc key='490v_SeriesStatement_volume_ss' tag='490v'}
      <br/>
    {/if}

    {include 'conditional-foreach.tpl' obj=$doc key='520a_Summary_ss' suffix='<br/>'}
    {include 'conditional-foreach.tpl' obj=$doc key='505a_TableOfContents_ss' suffix='<br/>'}

    {if hasMainPersonalName($doc)}
      <i class="fa fa-user" aria-hidden="true" title="personal name"></i>
      {if isset($doc->{'100a_MainPersonalName_personalName_ss'})}
        {foreach $doc->{'100a_MainPersonalName_personalName_ss'} as $value}
          <a href="#" class="record-link" data="100a_MainPersonalName_personalName_ss">{$value}</a>
          {if isset($doc->{'100d_MainPersonalName_dates_ss'})}
            {$doc->{'100d_MainPersonalName_dates_ss'}[$value@index]}
          {/if}
          {if !$value@last}, {/if}
        {/foreach}
      {/if}
      <br/>
    {/if}

    {if isset($doc->{'700a_AddedPersonalName_personalName_ss'})}
      <i class="fa fa-user" aria-hidden="true" title="personal name"></i>
      {foreach $doc->{'700a_AddedPersonalName_personalName_ss'} as $value}
        <a href="#" class="record-link" data="700a_AddedPersonalName_personalName_ss">{$value}</a>
        {if isset($doc->{'700d_AddedPersonalName_dates_ss'}) && isset($doc->{'700d_AddedPersonalName_dates_ss'}[$value@index])}
          {$doc->{'700d_AddedPersonalName_dates_ss'}[$value@index]}
        {/if}
        {if !$value@last}, {/if}
      {/foreach}
      <br/>
    {/if}

    {if isset($doc->{'710a_AddedCorporateName_ss'})}
      {foreach $doc->{'710a_AddedCorporateName_ss'} as $value}
        {$value}
        {if isset($doc->{'710d_AddedCorporateName_dates'})}
          {$doc->{'710d_AddedCorporateName_dates'}[$value@index]}
        {/if}
        {if !$value@last}, {/if}
      {/foreach}
      <br/>
    {/if}

    {if isset($doc->{'650a_Topic_topicalTerm_ss'})}
      <i class="fa fa-hashtag" aria-hidden="true" title="topical term"></i>
      {foreach $doc->{'650a_Topic_topicalTerm_ss'} as $value}
        <a href="#" class="record-link" data="650a_Topic_topicalTerm_ss">{$value}</a>{if !$value@last}, {/if}
      {/foreach}
      <br/>
    {/if}

    {if isset($doc->{'650z_Topic_geographicSubdivision_ss'})}
      <i class="fa fa-map" aria-hidden="true" title="geographic subdivision"></i>
      {foreach $doc->{'650z_Topic_geographicSubdivision_ss'} as $value}
        <a href="#" class="record-link" data="650z_Topic_geographicSubdivision_ss">{$value}</a>{if !$value@last}, {/if}
      {/foreach}
      <br/>
    {/if}

    {if isset($doc->{'650v_Topic_formSubdivision_ss'})}
      <i class="fa fa-tag" aria-hidden="true" title="form"></i>
      {foreach $doc->{'650v_Topic_formSubdivision_ss'} as $value}
        <a href="#" class="record-link" data="650v_Topic_formSubdivision_ss">{$value}</a>{if !$value@last}, {/if}
      {/foreach}
      <br/>
    {/if}

    {if isset($doc->{'6500_Topic_authorityRecordControlNumber_ss'})}
      {foreach $doc->{'6500_Topic_authorityRecordControlNumber_ss'} as $value}
        <a href="#" class="record-link" data="6500_Topic_authorityRecordControlNumber_ss">{$value}</a>{if !$value@last}, {/if}
      {/foreach}
      <br/>
    {/if}

    {if isset($doc->{'6510_Geographic_authorityRecordControlNumber_ss'})}
      <i class="fa fa-map" aria-hidden="true"></i>
      {foreach $doc->{'6510_Geographic_authorityRecordControlNumber_ss'} as $value}
        <a href="#" class="record-link" data="6510_Geographic_authorityRecordControlNumber_ss">{$value}</a>{if !$value@last}, {/if}
      {/foreach}
      <br/>
    {/if}

    {if isset($doc->{'6550_GenreForm_authorityRecordControlNumber_ss'})}
      <i class="fa fa-map" aria-hidden="true"></i>
      {foreach $doc->{'6550_GenreForm_authorityRecordControlNumber_ss'} as $value}
        <a href="#" class="record-link" data="6550_GenreForm_authorityRecordControlNumber_ss">{$value}</a>{if !$value@last}, {/if}
      {/foreach}
      <br/>
    {/if}

    {if hasSimilarBooks($doc)}
      <div class="similarity">
        <i class="fa fa-search" aria-hidden="true"></i>
        Search for similar items:
        {if isset($doc->{'9129_WorkIdentifier_ss'})}
          works:
          <a href="#" class="record-link" data="9129_WorkIdentifier_ss">{$doc->{'9129_WorkIdentifier_ss'}}</a>
        {/if}
        {if isset($doc->{'9119_ManifestationIdentifier_ss'})}
          manifestations:
          <a href="#" class="record-link" data="9119_ManifestationIdentifier_ss">{$doc->{'9119_ManifestationIdentifier_ss'}}</a>
        {/if}
      </div>
    {/if}

    <div class="details" id="details-{$id}">
      <ul class="nav nav-tabs" id="record-views-{$id}">
        <li class="nav-item">
          <a class="nav-link active" data-toggle="tab" role="tab" aria-selected="true"
             id="marc-raw-tab-{$id}" href="#marc-raw-{$id}"
             aria-controls="marc-raw-tab">MARC21</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" role="tab" aria-selected="false"
             id="marc-human-tab-{$id}" href="#marc-human-{$id}"
             aria-controls="marc-human-tab">labels</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" role="tab" aria-selected="false"
             id="marc-issue-tab-{$id}" href="#marc-issue-{$id}"
             aria-controls="marc-issue-tab" data-id="{$id}">isues</a>
        </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="marc-raw-{$id}" role="tabpanel"
             aria-labelledby="data-tab">
          <div class="marc-details" id="marc-details-{$id}">
            {if isset($doc->record_sni)}
              <table>
                {foreach getMarcFields($doc) as $row}
                  <tr>
                    {foreach $row as $cell}
                      <td>{$cell}</td>
                    {/foreach}
                  </tr>
                {/foreach}
              </table>
            {/if}
          </div>
        </div>
        <div class="tab-pane" id="marc-human-{$id}" role="tabpanel"
             aria-labelledby="data-tab">
          <ul>
            {foreach getAllSolrFields($doc) as $field}
              <li>
                <span class="label">{$field->label}:</span>
                {foreach $field->value as $value}
                  {$value}{if !$value@last} &mdash; {/if}
                {/foreach}
              </li>
            {/foreach}
          </ul>
        </div>
        <div class="tab-pane" id="marc-issue-{$id}" role="tabpanel"
             aria-labelledby="data-tab">
          <p>Retrieving issues detected in this MARC record (if any). It might take for a while.</p>
        </div>
      </div>
    </div>
  </div>
{/foreach}