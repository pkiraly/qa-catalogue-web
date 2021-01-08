<p>Each record get a score based on a number of criteria. Each criteria results in a
  positive score. The final (rounded) score is the summary of these criteria scores.</p>

{foreach $fields as $index => $field}
  <h3>{$field->tag} ({$field->count|number_format})</h3>
  <table>
    <tbody>
      <tr>
        <td>{if $field->components_histogram->exists}<img src="{$field->components_histogram->url}" width="250" />{/if}</td>
        <td>{if $field->components_sorted->exists}<img src="{$field->components_sorted->url}" width="250" />{/if}</td>
        <td>{if $field->pagerank->exists}<img src="{$field->pagerank->url}" width="250" />{/if}</td>
        <td>{if $field->degrees->exists}<img src="{$field->degrees->url}" width="250" />{/if}</td>
      </tr>
    </tbody>
  </table>
{/foreach}
