<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FrontEnd Store</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link href="https://fonts.googleapis.com/css2?family=Staatliches&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="header">
        <a href="index.php">
            <img class="header__logo" src="img/logo.png" alt="Logotipo">
        </a>
    </header>

    <nav class="navegacion">
        <a class="navegacion__enlace navegacion__enlace--activo" href="index.php">Tienda</a>
        <a class="navegacion__enlace" href="nosotros.html">Nosotros</a>
    </nav>

    <main class="contenedor">
        <h1>Nuestros Productos</h1>

        <div class="grid">
            <div class="producto">
                <a href="producto.html?img=1.jpg">
                    <img class="producto__imagen" src="img/1.jpg" alt="imagen camisa">
                    <div class="producto__informacion">
                        <p class="producto__nombre">VueJS</p>
                        <p class="producto__precio">$25</p>
                    </div>
                </a>
            </div>  <!--.producto-->
            <div class="producto">
                <a href="producto.html?img=2.jpg">
                    <img class="producto__imagen" src="img/2.jpg" alt="imagen camisa">
                    <div class="producto__informacion">
                        <p class="producto__nombre">AngularJS</p>
                        <p class="producto__precio">$25</p>
                    </div>
                </a>
            </div>  <!--.producto-->
            <div class="producto">
                <a href="producto.html?img=3.jpg">
                    <img class="producto__imagen" src="img/3.jpg" alt="imagen camisa">
                    <div class="producto__informacion">
                        <p class="producto__nombre">ReactJS</p>
                        <p class="producto__precio">$25</p>
                    </div>
                </a>
            </div>  <!--.producto-->
            <div class="producto">
                <a href="producto.html?img=4.jpg">
                    <img class="producto__imagen" src="img/4.jpg" alt="imagen camisa">
                    <div class="producto__informacion">
                        <p class="producto__nombre">Redux</p>
                        <p class="producto__precio">$25</p>
                    </div>
                </a>
            </div>  <!--.producto-->
            <div class="producto">
                <a href="producto.html?img=5.jpg">
                    <img class="producto__imagen" src="img/5.jpg" alt="imagen camisa">
                    <div class="producto__informacion">
                        <p class="producto__nombre">Node.js</p>
                        <p class="producto__precio">$25</p>
                    </div>
                </a>
            </div>  <!--.producto-->
            <div class="producto">
                <a href="producto.html?img=6.jpg">
                    <img class="producto__imagen" src="img/6.jpg" alt="imagen camisa">
                    <div class="producto__informacion">
                        <p class="producto__nombre">SASS</p>
                        <p class="producto__precio">$25</p>
                    </div>
                </a>
            </div>  <!--.producto-->
            <div class="producto">
                <a href="producto.html?img=7.jpg">
                    <img class="producto__imagen" src="img/7.jpg" alt="imagen camisa">
                    <div class="producto__informacion">
                        <p class="producto__nombre">HTML5</p>
                        <p class="producto__precio">$25</p>
                    </div>
                </a>
            </div>  <!--.producto-->
            <div class="producto">
                <a href="producto.html?img=8.jpg">
                    <img class="producto__imagen" src="img/8.jpg" alt="imagen camisa">
                    <div class="producto__informacion">
                        <p class="producto__nombre">Github</p>
                        <p class="producto__precio">$25</p>
                    </div>
                </a>
            </div>  <!--.producto-->
            <div class="producto">
                <a href="producto.html?img=9.jpg">
                    <img class="producto__imagen" src="img/9.jpg" alt="imagen camisa">
                    <div class="producto__informacion">
                        <p class="producto__nombre">BulmaCSS</p>
                        <p class="producto__precio">$25</p>
                    </div>
                </a>
            </div>  <!--.producto-->
            <div class="producto">
                <a href="producto.html?img=10.jpg">
                    <img class="producto__imagen" src="img/10.jpg" alt="imagen camisa">
                    <div class="producto__informacion">
                        <p class="producto__nombre">TypeScript</p>
                        <p class="producto__precio">$25</p>
                    </div>
                </a>
            </div>  <!--.producto-->
            <div class="producto">
                <a href="producto.html?img=11.jpg">
                    <img class="producto__imagen" src="img/11.jpg" alt="imagen camisa">
                    <div class="producto__informacion">
                        <p class="producto__nombre">Drupal</p>
                        <p class="producto__precio">$25</p>
                    </div>
                </a>
            </div>  <!--.producto-->
            <div class="producto">
                <a href="producto.html?img=12.jpg">
                    <img class="producto__imagen" src="img/12.jpg" alt="imagen camisa">
                    <div class="producto__informacion">
                        <p class="producto__nombre">JavaScript</p>
                        <p class="producto__precio">$25</p>
                    </div>
                </a>
            </div>  <!--.producto-->
            <div class="producto">
                <a href="producto.html?img=13.jpg">
                    <img class="producto__imagen" src="img/13.jpg" alt="imagen camisa">
                    <div class="producto__informacion">
                        <p class="producto__nombre">GraphQL</p>
                        <p class="producto__precio">$25</p>
                    </div>
                </a>
            </div>  <!--.producto-->
            <div class="producto">
                <a href="producto.html?img=14.jpg">
                    <img class="producto__imagen" src="img/14.jpg" alt="imagen camisa">
                    <div class="producto__informacion">
                        <p class="producto__nombre">WordPress</p>
                        <p class="producto__precio">$25</p>
                    </div>
                </a>
            </div>  <!--.producto-->

            <div class="grafico grafico--camisas"></div>
            <div class="grafico grafico--node"></div>
        </div>
    </main>

    <footer class="footer">
        <p class="footer__texto">Front End Store - Todos los derechos Reservados 2022.</p>
    </footer>
    
</body>
</html>
