<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/wesbos/assets/style.css">
  <title>Using minmax() for Responsive Grids!</title>
</head>

<body>
  <div class="container">
    <div class="item item1">Item 01</div>
    <div class="item item2">Bonjour!</div>
    <div class="item item3">Item 03</div>
    <div class="item item4">Item 04</div>
  </div>

  <style>
    .container {
      display: grid;
      grid-gap: 20px;
      border: 10px solid var(--yellow);
     /* 
        grid-template-columns: repeat(auto-fill, minmax(150px ,1fr));
      grid-template-columns: repeat(auto-fit, minmax(150px ,1fr));
      */
      /*grid-template-columns:fit-content(100px) 150px 150px 150px;*/
    }
    .item2{

    }
  </style>
</body>

</html>