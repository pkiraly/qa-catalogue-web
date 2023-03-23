{assign var=file value="config/footer.$lang.tpl"}
{if file_exists($file)}{include $file}{/if}
</body>
</html>
