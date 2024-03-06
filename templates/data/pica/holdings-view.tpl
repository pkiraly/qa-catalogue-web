{if $grouped and !empty($groupBy->tag)}
  <h4>{_('Libraries holding this document')}</h4>
  {assign var="fieldInstances" value=$record->getFields($groupBy->tag)}
  {if !is_null($fieldInstances)}
    <ul style="list-style-type: square; padding-left: 15px;">
      {foreach from=$record->getAllSubfields($groupBy->tag, $groupBy->subfield) item=subfield}
        {foreach from=explode(',', $subfield) item=libId}
          <li>{$controller->getLibraryById($libId)}</li>
        {/foreach}
      {/foreach}
    </ul>
  {/if}
{/if}