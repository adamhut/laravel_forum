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
    <div class="item item1">1</div>
    <div class="item item2">2</div>
    <div class="item item3">3</div>
    <div class="item item4">4</div>
    <div class="item item5">5</div>
    <div class="item item6">6</div>
    <div class="item item7">7</div>
    <div class="item item8">8</div>
    <div class="item item9">9</div>
    <div class="item item10">10</div>
    <div class="item item11">11</div>
    <div class="item item12">12</div>
    <div class="item item13">13</div>
    <div class="item item14">14</div>
    <div class="item item15">15</div>
    <div class="item item16">16</div>
    <div class="item item17">17</div>
    <div class="item item18">18</div>
    <div class="item item19">19</div>
    <div class="item item20">20</div>
    <div class="item item21">21</div>
    <div class="item item22">22</div>
    <div class="item item23">23</div>
    <div class="item item24">24</div>
    <div class="item item25">25</div>
    <div class="item item26">26</div>
    <div class="item item27">27</div>
    <div class="item item28">28</div>
    <div class="item item29">29</div>
    <div class="item item30">30</div>
  </div>

  <style>
    .container {
      display: grid;
      grid-gap: 20px;
      grid-template-areas:
       "💩 💩 💩 💩 🍔 🍔 🍔 🍔"
       "💩 💩 💩 💩 🍔 🍔 🍔 🍔"
       "💩 💩 💩 💩 🍔 🍔 🍔 🍔"
       "💩 💩 💩 💩 🍔 🍔 🍔 🍔";
    }

    .item3{
      grid-column:💩-start/🍔-end;
      grid-row-end: 💩-end;
    }

  </style>
</body>

</html>