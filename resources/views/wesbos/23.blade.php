<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Bootstrappy Grid with CSS Variables!</title>
  <link rel="stylesheet" href="/wesbos/assets/style.css">
</head>

<body>

  <div class="grid" style="--cols:10">
    <div class="item">1</div>
    <div class="item" style="--sapn:3">
    
        <div class="grid" style="--cols:2">
            <div class="item">1</div>
            <div class="item">2</div>
        </div>
    
    </div>
    <div class="item">3</div>
    <div class="item">4</div>
  </div>

  <style>
    
    .grid {
        display:grid;
        grid-template-columns:repeat(var(--cols,12) , minmax(0,1fr));
        grid-gap:20px;
    }

    .item{
        min-width:0;
        width:100%;
        --span:1
        grid-column:span var(--span);
    }
  </style>

</body>

</html>