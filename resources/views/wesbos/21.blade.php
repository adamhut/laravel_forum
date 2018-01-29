<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link rel="stylesheet" href="/wesbos/assets/style.css">
  <title>Flexbox vs CSS Grid: Axis Flipping!</title>
</head>

<body>

  <!-- Flipping the direction of columns -->

  <script>
    function flip(e) {
      const flipper = document.querySelector('.flipper');
      flipper.classList.toggle('flip');
    }
  </script>

  <h1>Axis Flipping</h1>
  <button onClick="flip()">Flip It</button>
  <div class="flipper">
    <div class="item">1</div>
    <div class="item">2</div>
    <div class="item">3</div>
    <div class="item">4</div>
    <div class="item">5</div>
    <div class="item">6</div>
    <div class="item">7</div>
    <div class="item">8</div>
    <div class="item">9</div>
    <div class="item">10</div>

  </div>

  <style>
    .flipper{
        display:grid;
        grid-gap:20px;
        grid-template-columns:repeat(auto-fit, minmax(50px,1fr));
    }
    .flipper.flip{
        grid-template-columns:1fr;
    }
  </style>

  <h1>Control on the right</h1>
<div class="tracks">
    <div class="track">
      <h2>The Future (Ft. The R.O.C.)</h2>
      <button>⭐</button>
      <button>❤️</button>
      <button>❌</button>
    </div>
    <div class="track">
      <h2>Bounce With Me (Ft. Jermaine Dupri & Xscape)</h2>
      <button>⭐</button>
      <button>❤️</button>
      <button>❌</button>
    </div>
    <div class="track">
      <h2>Puppy Love (Ft. Jagged Edge & Jermaine Dupri)</h2>
      <button>⭐</button>
      <button>❤️</button>
      <button>❌</button>
    </div>
    <div class="track">
      <h2>You Know Me (Ft. Da Brat & Jermaine Dupri)</h2>
      <button>⭐</button>
      <button>❤️</button>
      <button>❌</button>
    </div>
    <div class="track">
      <h2>The Dog in Me</h2>
      <button>⭐</button>
      <button>❤️</button>
      <button>❌</button>
    </div>
    <div class="track">
      <h2>Bow Wow (That's My Name) (Ft. Snoop Dogg)</h2>
      <button>⭐</button>
      <button>❤️</button>
      <button>❌</button>
    </div>
  </div>
  <style>
    .track {
      background: white;
      padding: 10px;
      border-bottom: 1px solid rgba(0, 0, 0, 0.1);
      display:grid;
      grid-template-columns:1fr;
      grid-auto-flow:column;

    }
    .track h2{
        /*flex:1*/
    }
  </style>
  <h1>Flex on item</h1>
  <div class="controls">
    <button>⏯️</button>
    <button>🐢</button>
    <button>🐰</button>
    <div class="scrubber"></div>
    <button>💬</button>
    <button>🔽</button>
  </div>

  <style>
    .controls {
      margin: 10px 0;
      /*display:flex;
     
      */
      display:grid;
      grid-template-columns: auto auto auto 1fr auto auto;

       align-items:center;
    }

    .scrubber {
      background: #BADA55;
      height: 10px;
      min-width: 100px;
      border-radius: 10px;
      /*flex:1;*/
    }
  </style>


  <h1>Perfectly Center</h1>
  <div class="hero">
    <h2>Something Big Is Coming</h2>
    <p>Get Ready...</p>
  </div>

  <style>
    .hero {
        height: 200px;
        background: rgba(255, 255, 255, 0.2);
        /*display:flex;
        flex-direction:column;
        justify-content:center;
        align-items :center;
        */
        display:grid;
        justify-items:center;
        align-content :center;
    }
  </style>
    
    <h1>self control</h1>
    <div class="corners">
        <div class="corner item">1</div>
        <div class="corner item">TWO</div>
        <div class="corner item">3</div>
        <div class="corner item">4</div>
    </div>

  <style>
    .corners {
      display: grid;
      height: 200px;
      width: 200px;
      border: 10px solid var(--yellow);
        grid-template-columns:1fr 1fr;
        grid-template-rows:1fr 1fr;
        align-items:end;
        justify-content:end;
    }


    .corner:nth-child(1),
    .corner:nth-child(2) {
       align-self:start;
    }

    .corner:nth-child(1),
    .corner:nth-child(3) {
       justify-self:start;
    }
  </style>

  <h1>Stacked Layout</h1>
  <!-- Stacked Layout -->
  <div class="stacked">
    <div class="item">1</div>
    <div class="item">2</div>
    <div class="item">3</div>
    <div class="item">4</div>
    <div class="item">5</div>
  </div>

  <style>
    .stacked {
        display:flex;
        flex-wrap:wrap;
        justify-content:space-around;
    }

    .stacked>* {
      width: 30%;
      margin-bottom: 20px;
      
    }
  </style>

    <h1>Unknow Content Size</h1>
    <div class="container known">
    <div class="item">Short</div>
    <div class="item">Longerrrrrr</div>
    <div class="item">
      <img src="https://source.unsplash.com/300x200" alt="">
    </div>
    <div class="item">💩</div>
  </div>

  <style>
    .known {
      margin: 100px 0;
      display:grid;
      grid-template-columns:repeat(5,auto);
      justify-content:center;
      grid-gap:20px;
    }
  </style>

  <h1>Unknow Number Of Items</h1>
  <script>
    function addItem() {
      const unknown = document.querySelector('.unknown');
      unknown.innerHTML += `<div class="item">${unknown.childElementCount}</div>`;
    }
  </script>
  <button onClick="addItem()">+ Add</button>
  <div class="unknown">
    <div class="item">1</div>
    <div class="item">2</div>
    <div class="item">3</div>
  </div>

  <style>
    .unknown {
        display:grid;
        grid-template-columns:repeat(auto-fill, minmax(50px , 1fr));
        grid-gap:20px;
    }
  </style>
  <h1>varable width each row</h1>
  <div class="flex-container">
    <div class="item">Short</div>
    <div class="item">Longerrrrrrrrrrrrrr</div>
    <div class="item">💩</div>
    <div class="item">This is Many Words</div>
    <div class="item">Lorem, ipsum.</div>
    <div class="item">10</div>
    <div class="item">Snickers</div>
    <div class="item">Wes Is Cool</div>
    <div class="item">Short</div>
  </div>
  <style>
    .flex-container {
        display:flex;
        flex-wrap:wrap;
        border:1px solid #fff;
       
    }

    .flex-container>* {
      margin: 10px;
      flex:1;
    }
  </style>

</body>

</html>