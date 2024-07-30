<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>QA catalogue for analysing library data</title>
  <link rel="shortcut icon" type="image/x-icon" href="./favicon.ico">
  <!-- Bootstrap CSS -->
  <!-- link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" -->
  <link rel="stylesheet" href="./styles/external-libs/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

  <!-- https://code.jquery.com/jquery-3.7.1.min.js -->
  <script src="./js/external-libs/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <!-- https://code.jquery.com/ui/1.13.3/jquery-ui.min.js -->
  <script src="./js/external-libs/jquery-ui.1.13.3.min.js" integrity="sha256-sw0iNNXmOJbQhYFuC9OF2kOlD5KQKe1y5lfBn4C9Sjg=" crossorigin="anonymous"></script>
  <!-- script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script -->
  <script src="./js/external-libs/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <!-- script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script -->
  <script src="./js/external-libs/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <!-- fontawesome
  <script src="//use.fontawesome.com/feff23b961.js"></script>
  <script src="js/feff23b961.js"></script>
   -->
  <!-- script src="https://kit.fontawesome.com/2f4e00a49c.js" crossorigin="anonymous"></script -->
  <script src="./js/external-libs/2f4e00a49c.js" crossorigin="anonymous"></script>
  <!-- script src="//code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script -->
  <link rel="stylesheet" href="styles/metadata-qa.css">
  <script type="text/javascript">
    var marcBaseUrl = 'https://www.loc.gov/marc/bibliographic/';
    function showMarcUrl(link) {
      return marcBaseUrl + link;
    }
  </script>
  <!-- script src="https://d3js.org/d3.v5.min.js"></script -->
  <script src="./js/external-libs/d3.v5.min.js"></script>
</head>
<body>
{if isset($error)}
<div class="container" style="color:#f00;background:#fcc;padding:1em;">
  <b>ERROR:</b> {$error}
</div>
{/if}
{assign var=file value="$templates/header.$lang.tpl"}
{if file_exists($file)}{include $file}{/if}
