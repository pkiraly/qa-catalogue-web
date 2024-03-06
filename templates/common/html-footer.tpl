{assign var=file value="$templates/footer.$lang.tpl"}
{if file_exists($file)}{include $file}!!{else}
<footer class="container" style="padding-bottom: 1em">
<hr>
<div>
{include "common/version.tpl"}
</div>
</footer>
{/if}
</body>
</html>
