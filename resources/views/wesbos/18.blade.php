<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/wesbos/assets/style.css">
  <title>Re-ordering Grid Items!</title>
</head>

<body>
  <div class="container">
    <div class="item logo">LOGO</div>
    <div class="item nav">NAV</div>
    <div class="item content">
      <p>I'm the Content!</p>
    </div>
  </div>

  <style>
    .container {
      display: grid;
      grid-gap: 20px;
      grid-template-columns:repeat(10, 1fr);
    }
    .logo{
        grid-column:span 2;
        order:2;
    }
    .nav {
        grid-column:span 8;
        order:1;
    }
    .content{
        grid-column:1/-1;
        order:3;
    }


  </style>
</body>

</html>