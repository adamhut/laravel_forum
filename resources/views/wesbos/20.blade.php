<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>CSS Grid Image Gallery!</title>
</head>

<body>

  <div class="overlay">
    <div class="overlay-inner">
      <button class="close">× Close</button>
      <img>
    </div>
  </div>

  <section class="gallery">


  </section>


  <style>
    * {
      box-sizing: border-box;
    }

    body {
      padding: 50px;
      font-family: sans-serif;
      background: linear-gradient(to right, #F93D66, #6D47D9);
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
      margin: 0 0 5px 0;
    }

    p {
      margin: 0 0 20px 0;
    }

    .close {
      background: none;
      color: black;
      border: 0;
    }

    .gallery {
        display:grid;
        grid-template-columns:repeat(auto-fill, 100px);
        grid-auto-rows:100px;
        grid-auto-flow:dense;

    }

    .item{
        overflow:hidden;
        display:grid;
        grid-template-columns:1;
        grid-template-rows:1;
    }

    .item img{
        grid-column:1/-1;
        grid-row:1/-1;
        width:100%;
        height:100%;
        object-fit:cover;
    }
    .item__overlay{
        display:grid;
        justify-items:center;
        align-items:center;

        background:#ffc60032;
        grid-column:1/-1;
        grid-row:1/-1;
        position:relative;
        transform: translateY(100%);
        transition:0.2s;
    }


     .item__overlay button{
        background:none;
        border:2px solid #ffffff;
        color: white;
        text-trnasform:uppercase;
        background:rgba(0,0,0,0.7);
        padding:5px;
     }

     .item:hover .item__overlay{
         transform: translateY(0%);
     }

    .item.v2{
        grid-row:span 2;
    }

    .item.v3{
        grid-row:span 3;
    }

    .item.v4{
        grid-row:span 4;
    }

    .item.h2{
        grid-column:span 2;
    }

    .item.h3{
        grid-column:span 3;
    }

    .item.h4{
        grid-column:span 4;
    }



    .overlay {
      position: fixed;
      background: rgba(0, 0, 0, 0.7);
      top: 0;
      right: 0;
      bottom: 0;
      left: 0;
      display: none;
      z-index: 2;
    }

    .overlay.open {
      display: grid;
      align-items:center;
      justify-items:center;
    }

    .overlay-inner {
      background: white;
      width: 700px;
      padding: 20px;
    }

    .overlay img {
      width: 100%;
    }
  </style>

  <script>
    const gallery = document.querySelector('.gallery');
    const overlay = document.querySelector('.overlay');

    const overlayClose = overlay.querySelector('.close');
    const overlayImage = overlay.querySelector('img');



    function generateHTML([h,v])
    {
      return `
        <div class="item h${h} v${v}">
          <img src="/images/${randomNumber(12)}.jpg" />
          <div class="item__overlay">
            <button> View</button>
          </div>
        </div>
      `;
    }

    function randomNumber(limit) {
      return Math.floor(Math.random()*limit)+1;
    }

    const filler = Array.from({length:20},()=>{
      return [1,1];
    });

    const digits =Array.from({length:50},()=>{
      return [randomNumber(4), randomNumber(4)];
    }).concat(filler);

    function handleClick(e)
    {
        //console.log(e.currentTarget);
        const src = e.currentTarget.querySelector('img').src;
        //console.log(src);
        overlayImage.src = src;
        open();
    }

    function open()
    {
        overlay.classList.add('open');
    }

    function close()
    {
        overlay.classList.remove('open');
    }

    const html = digits.map(generateHTML).join('');

    gallery.innerHTML=html;

    const items =  document.querySelectorAll('.item');
    items.forEach(item=> item.addEventListener('click',handleClick));

    overlayClose.addEventListener('click',close);

  </script>
</body>

</html>