<a href="https://github.com/pkiraly/qa-catalogue-web" target="_blank">qa-catalogue-web</a>
{if $clientVersion.version}
  version
  <a href="https://github.com/pkiraly/qa-catalogue-web/releases/tag/{$clientVersion.version}" target="_blank">{$clientVersion.version}</a>
{elseif $clientVersion.commit}
  version
  <a href="https://github.com/pkiraly/qa-catalogue-web/commit/{$clientVersion.commit}" target="_blank">{$clientVersion.commit|substr:0:8}</a>@<a href="https://github.com/pkiraly/qa-catalogue-web/tree/{$clientVersion.branch}" target="_blank">{$clientVersion.branch}</a>
{/if}
{if !$clientVersion.clean}
  <em>+ local modifications</em>
{/if}

