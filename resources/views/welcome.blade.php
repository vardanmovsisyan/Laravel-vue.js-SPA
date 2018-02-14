<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>ContactStore</title>
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="vue2-autocomplete-js/dist/style/vue2-autocomplete.css">
  </head>
  <body>

    <div class="container">
      <div id="app">
        <contacts></contacts>
      </div>
    </div>

    <script src="/js/app.js"></script>
    <script src="./dist/vue2-autocomplete.js"></script>
  </body>
</html>
