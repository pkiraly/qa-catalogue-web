<a href="https://github.com/pkiraly/qa-catalogue-web" target="_blank">qa-catalogue-web</a>
{if isset($clientVersion.tag)}
  version
  <a href="https://github.com/pkiraly/qa-catalogue-web/releases/tag/{$clientVersion.tag}" target="_blank">{$clientVersion.tag}</a>
{elseif isset($clientVersion.commit)}
  version
  <a href="https://github.com/pkiraly/qa-catalogue-web/commit/{$clientVersion.commit}" target="_blank">{$clientVersion.commit|substr:0:8}</a>@<a href="https://github.com/pkiraly/qa-catalogue-web/tree/{$clientVersion.branch}" target="_blank">{$clientVersion.branch}</a>
{elseif isset($clientVersion.branch)}
  branch
  <a href="https://github.com/pkiraly/qa-catalogue-web/tree/{$clientVersion.branch}" target="_blank">{$clientVersion.branch}</a>
{/if}
{if isset($clientVersion.dirty) && $clientVersion.dirty}
  <em>+ local modifications</em>
{/if}
