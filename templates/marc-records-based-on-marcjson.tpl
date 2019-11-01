{foreach $docs as $doc}
  {assign var="record" value=getRecord($doc)}
  {assign var="id" value=$doc->id|regex_replace:"/ +$/":""}
  <div class="record">
    <h2>
      {assign var="tag245" value=getField($record, '245')}
      {assign var="tag773" value=getField($record, '773')}
      {if isset($tag245->subfields->a) || isset($tag245->subfields->b)}
        {include 'conditional-foreach.tpl' obj=$tag245->subfields key='a'}
        {include 'conditional-foreach.tpl' obj=$tag245->subfields key='b'}
      {elseif isset($tag773)}
        {include 'conditional-foreach.tpl' obj=$tag773->subfields key='t'}
        {if isset($tag245->subfields->n)}
          {include 'conditional-foreach.tpl' obj=$tag245->subfields key='n'}
        {/if}
      {/if}
      <a href="#" class="record-details" data="details-{$id}" title="display details"><i class="fa fa-book" aria-hidden="true"></i></a>
      <a href="{opacLink($doc, $doc->id)}" target="_blank" title="Display record in the library catalogue"><i class="fa fa-external-link" aria-hidden="true"></i></a>
    </h2>
    {* 245c_Title_responsibilityStatement_ss *}
    {if isset($tag245->subfields->c)}
      {include 'conditional-foreach.tpl' obj=$tag245->subfields key='c'
        label='<i class="fa fa-pencil" aria-hidden="true"></i>' suffix='<br/>'}
    {* 773a_PartOf_ss *}
    {elseif isset($tag773->subfields->a)}
      {include 'conditional-foreach.tpl' obj=$tag773->subfields key='a'
        label='<i class="fa fa-pencil" aria-hidden="true"></i>' suffix='<br/>'}
    {/if}

    {* 250a_Edition_editionStatement_ss *}
    {assign var="fieldInstances" value=getFields($record, '250')}
    {if !is_null($fieldInstances)}
      {foreach $fieldInstances as $field}
        {if isset($field->subfields->a)}
          <span class="250a_Edition_editionStatement_ss">{$field->subfields->a}</span>
        {/if}
      {/foreach}
      <br/>
    {/if}

    {if hasPublication($doc)}
      {* 250a_Edition_editionStatement_ss *}
      {assign var="tag260" value=getField($record, '260')}
      <i class="fa fa-calendar" aria-hidden="true"></i>
      Published
      {* 260c_Publication_date_ss *}
      {include 'conditional-foreach.tpl' obj=$tag260->subfields key='c' label='in' tag='260c'}
      {* 260a_Publication_place_ss *}
      {include 'conditional-foreach.tpl' obj=$tag260->subfields key='a' label='in' tag='260a'}
      {* 260b_Publication_agent_ss *}
      {include 'conditional-foreach.tpl' obj=$tag260->subfields key='b' label='by' tag='260b'}
      <br/>
    {/if}

    {if hasPhysicalDescription($doc)}
      {assign var="tag300" value=getField($record, '300')}
      {* 300a_PhysicalDescription_extent_ss *}
      {include 'conditional-foreach.tpl' obj=$tag300->subfields key='a' tag='300a'}
      {* 300c_PhysicalDescription_dimensions_ss *}
      {include 'conditional-foreach.tpl' obj=$tag300->subfields key='c' tag='300c'}
      <br/>
    {/if}

    {* TODO: iterate over each tag 490 *}
    {* 490a_SeriesStatement_ss *}
    {assign var="tag490" value=getField($record, '490')}
    {if isset($tag490->subfields->a)}
      Series:
      {foreach getSubfields($record, '490', 'a') as $value}
        <a href="#" class="record-link tag-490a" data="490a_SeriesStatement_ss">{$value}</a>{if !$value@last}, {/if}
      {/foreach}
      {* 490v_SeriesStatement_volume_ss *}
      {include 'conditional-foreach.tpl' obj=$tag490->subfields key='v' tag='490v'}
      <br/>
    {/if}

    {* 520a_Summary_ss *}
    {assign var="tag520s" value=getFields($record, '520')}
    {if !is_null($tag520s)}
      <!-- 520a_Summary_ss -->
      {foreach $tag520s as $field}
        {include 'conditional-foreach.tpl' obj=$field->subfields key='a' suffix='<br/>'}
      {/foreach}
    {/if}

    {* 505a_TableOfContents_ss *}
    {assign var="tag505s" value=getFields($record, '505')}
    {if !is_null($tag505s)}
      <!-- 505a_TableOfContents_ss -->
      {foreach $tag505s as $field}
        {include 'conditional-foreach.tpl' obj=$field->subfields key='a' suffix='<br/>'}
      {/foreach}
    {/if}

    {* 100a_MainPersonalName_personalName_ss *}
    {if hasMainPersonalName($doc)}
      {assign var="tag100s" value=getFields($record, '100')}
      {if !is_null($tag100s)}
        {foreach $tag100s as $field}
          <i class="fa fa-user" aria-hidden="true" title="personal name"></i>
          <a href="#" class="record-link" data="100a_MainPersonalName_personalName_ss">{$field->subfields->a}</a>
          {if isset($field->subfields->b)}
            <span class="numeration">{$field->subfields->b}</span>
          {/if}
          {if isset($field->subfields->c)}
            <span class="titles">{$field->subfields->c}</span>
          {/if}
          {* 100d_MainPersonalName_dates_ss *}
          {if isset($field->subfields->d)}
            <span class="dates">{$field->subfields->d}</span>
          {/if}
          <br/>
        {/foreach}
      {/if}
    {/if}

    {if isset($doc->{'700a_AddedPersonalName_personalName_ss'})}
      {assign var="tag700s" value=getFields($record, '700')}
      {foreach $tag700s as $field}
        <span class="700">
          <i class="fa fa-user" aria-hidden="true" title="personal name"></i>
          <a href="#" class="record-link" data="700a_AddedPersonalName_personalName_ss">{$field->subfields->a}</a>
          {if isset($field->subfields->b)}
            <span class="numeration">{$field->subfields->b}</span>
          {/if}
          {if isset($field->subfields->c)}
            <span class="titles">{$field->subfields->c}</span>
          {/if}
          {* 700d_AddedPersonalName_dates_ss *}
          {if isset($field->subfields->d)}
            <span class="dates">{$field->subfields->d}</span>
          {/if}
          {if isset($field->subfields->e)}
            <span class="relator">{$field->subfields->e}</span>
          {/if}
          {if isset($field->subfields->{'0'})}
            (authority: <a href="#" class="record-link" data="7000">{$field->subfields->{'0'}}</a>)
          {/if}
        </span>
        <br/>
      {/foreach}
    {/if}

    {* 710a_AddedCorporateName_ss *}
    {assign var="fieldInstances" value=getFields($record, '710')}
    {if !is_null($fieldInstances)}
      {foreach $fieldInstances as $field}
        <span class="710">
          {$field->subfields->a}
          {* 710d_AddedCorporateName_dates *}
          {if isset($field->subfields->d)}
            <span class="dates">{$field->subfields->d}</span>
          {/if}
          {if isset($field->subfields->e)}
            <span class="relator">{$field->subfields->e}</span>
          {/if}
        </span>
        <br/>
      {/foreach}
    {/if}

    {assign var="fieldInstances" value=getFields($record, '650')}
    {if !is_null($fieldInstances)}
      {foreach $fieldInstances as $field}
        {* 650a_Topic_topicalTerm_ss *}
        <span class="650">
          {if isset($field->subfields->a)}
            <i class="fa fa-hashtag" aria-hidden="true" title="topical term"></i>
            <a href="#" class="record-link" data="650a_Topic_topicalTerm_ss">{$field->subfields->a}</a>
          {/if}

          {* 650z_Topic_geographicSubdivision_ss *}
          {if isset($field->subfields->z)}
            geo:
            <i class="fa fa-map" aria-hidden="true" title="geographic subdivision"></i>
            <a href="#" class="record-link" data="650z_Topic_geographicSubdivision_ss">{$field->subfields->z}</a>
          {/if}

          {* 650v_Topic_formSubdivision_ss *}
          {if isset($field->subfields->v)}
            form:
            <i class="fa fa-tag" aria-hidden="true" title="form"></i>
            <a href="#" class="record-link" data="650v_Topic_formSubdivision_ss">{$field->subfields->v}</a>
          {/if}

          {if isset($field->subfields->{'2'})}
            vocabulary: {$field->subfields->{'2'}}</a>
          {/if}

          {* 6500_Topic_authorityRecordControlNumber_ss *}
          {if isset($field->subfields->{'0'})}
            (authority: <a href="#" class="record-link" data="650v_Topic_formSubdivision_ss">{$field->subfields->{'0'}}</a>)
          {/if}
        </span>
        <br/>
      {/foreach}
    {/if}

    {* 6510_Geographic_authorityRecordControlNumber_ss *}
    {assign var="fieldInstances" value=getFields($record, '651')}
    {if !is_null($fieldInstances)}
      {foreach $fieldInstances as $field}
        <span class="651">
          {if isset($field->subfields->a)}
            <i class="fa fa-map" aria-hidden="true" title="geographic term"></i>
            <a href="#" class="record-link" data="650a">{$field->subfields->a}</a>
          {/if}

          {if isset($field->subfields->{'2'})}
            vocabulary: {$field->subfields->{'2'}}</a>
          {/if}

          {if isset($field->subfields->{'0'})}
            (authority: <a href="#" class="record-link" data="6510_Geographic_authorityRecordControlNumber_ss">{$field->subfields->{'0'}}</a>)
          {/if}
        </span>
        <br/>
      {/foreach}
    {/if}

    {* 6550_GenreForm_authorityRecordControlNumber_ss *}
    {assign var="fieldInstances" value=getFields($record, '655')}
    {if !is_null($fieldInstances)}
      {foreach $fieldInstances as $field}
        <span class="655">
          {if isset($field->subfields->a)}
            <a href="#" class="record-link" data="655a">{$field->subfields->a}</a>
          {/if}

          {if isset($field->subfields->{'2'})}
            vocabulary: {$field->subfields->{'2'}}</a>
          {/if}

          {if isset($field->subfields->{'0'})}
            (<a href="#" class="record-link" data="6550_GenreForm_authorityRecordControlNumber_ss">{$field->subfields->{'0'}}</a>)
          {/if}
        </span>
        <br/>
      {/foreach}
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