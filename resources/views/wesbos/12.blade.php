<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/wesbos/assets/style.css">
  <title>auto-fit and auto-fill!</title>
</head>

<body>
  <div class="container">
    <div class="item item1">Item 01</div>
    <div class="item item2">Item 02</div>
    <div class="item item3">Item 03</div>
    <div class="item item4">Item 04</div>
 
  </div>

  <style>
    .container {
      display: grid;
      grid-gap: 20px;
      border: 10px solid var(--yellow);
      grid-template-columns:repeat(auto-fill,150px);
      /**check out the different between auto-fill and auto-fit resize the window to see the differnet*/
    }

    .item4 {
        grid-column-end : -1;
    }


  </style>
</body>

</html>