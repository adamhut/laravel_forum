<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/wesbos/assets/style.css">
    <title>CSS Grid Implicit vs Explicit Grid Tracks!</title>
</head>

<body>
  <div class="container">
    <div class="item">1</div>
    <div class="item">2</div>
    <div class="item">3</div>
    <div class="item">4</div>
  </div>

  <style>
    .container {
      display: grid;
      grid-gap:20px;
      grid-template-columns:200px 400px;
      grid-template-rows:200px 400px;
      grid-auto-rows:500px;
      grid-auto-columns:100px;

    }
  </style>
</body>

</html>