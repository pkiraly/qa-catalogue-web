{assign var=file value="$templates/footer.$lang.tpl"}
{if file_exists($file)}{include $file}{/if}
</body>
</html>
