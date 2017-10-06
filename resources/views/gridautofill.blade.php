<html>
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <style >
    body{
        margin-top: 40px;
    }
    .container{
        background: #333;

        display: grid;        
        /*grid-template-columns:repeat(auto-fill,200px);*/
        /* grid-template-columns:repeat(auto-fill,minmax(100px ,1fr));*/
         grid-template-columns:repeat(auto-fit,minmax(100px ,1fr));
        grid-gap :1px; 
    }
    .box{
        background: #00b1b3;
        color:#fff;
        border-radius: 2px;
        padding: 10px;
    }

   
    
    </style>
</head>
<body>
    <div class="container">
        <div class="box a">A
        </div>
        <div class="box b">B</div>
        <div class="box c">C</div>
        <div class="box d">D</div>
        <div class="box e">E</div>
    </div>


</body>
</html>

