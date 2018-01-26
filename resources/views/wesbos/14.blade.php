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
    <div class="item item1">
      <p>I'm Sidebar #1</p>
    </div>
    <div class="item item2">
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Inventore, sed.</p>
      <p>Lorem ipsum d</p>
    </div>
    <div class="item item3">
      <p>I'm Sidebar #2</p>
    </div>
    <div class="item footer">
      <p>I'm the footer</p>
    </div>
  </div>

  <style>
    .container {
      display: grid;
      grid-gap: 20px;
      grid-template-columns:1fr 10fr 1fr;
      grid-template-rows:150px 150px 100px;
      grid-template-areas:
        "sidebar-1 content sidebar-2"
        "sidebar-1 content sidebar-2"
        "footer footer footer";
    }
    .footer{
        grid-area:footer;
    }
    .item1{
        grid-area:sidebar-1;
    }
    .item2{
        grid-area:content;
    }
    .item3{
        grid-area:sidebar-2;
    }

    @media(max-width:1200px){
        .container {
             grid-template-areas:
                "content content content"
                "sidebar-1 sidebar-1 sidebar-2"
                "footer footer footer";
        }
    }
  </style>
</body>

</html>