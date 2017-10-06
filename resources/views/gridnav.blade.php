<html>
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <style >
    .container{
       display: grid;
       grid-template-columns: 150px auto; 
       grid-template-rows: 150px auto 100px;
       grid-template-areas: 
            "header header"
            "navbody main"
            "footer footer";
        grid-gap: 10px;
    }
    
    body{
        margin-top:40px;
    }

    header{
        grid-area: header;
        background: #f00;
    }    

    nav{
        grid-area: navbody;
        background: brown;
    }    
    menu{
        grid-area: menu;
        background: #003300;
    }    
    footer{
        grid-area: footer;
        background: #e3e3e3;
    }    
    </style>
</head>
<body>
    <div class="container">
        <header>header</header>
        <nav>nav</nav>
        <main>main</main>
        <footer>footer</footer>
    </div>


</body>
</html>
