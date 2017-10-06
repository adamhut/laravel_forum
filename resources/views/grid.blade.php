<html>
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <style >
    .container{
        display: grid;
        background: #e3e3e3;
        width: 800px;
        height: 400px;
        margin: 100px auto 0;
        display: grid;
        grid-template-columns: 100px 2fr 1fr;
        grid-template-rows: repeat(3, 1fr);
        grid-gap: 1em;
    }
    .item{
        border: 1px solid #999;
    }
    /*
    .item:first-child{
        background: #f00;
        grid-row-start: 2;
        grid-row-end:3;
        grid-row:1/2;
        grid-column-start: 1;
        grid-column-end: 4;

    }
    .item:last-child{
        background: #f00;
       
        grid-row:1/2;
        grid-column-start: 2;
        grid-column-end: 5;
    }
    */
    </style>
</head>
<body>
    <div class="container">
        <div class="item">1</div>
        <div class="item">2</div>
        <div class="item">3</div>
        <div class="item">4</div>
        <div class="item">5</div>
        <div class="item">6</div>
        <div class="item">7</div>
        <div class="item">8</div>
        <div class="item">9</div>
    </div>


</body>
</html>
