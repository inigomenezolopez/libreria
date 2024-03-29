<!DOCTYPE html>
<html lang="en">
<link rel="shortcut icon" type="image/x-icon" href="/libreria/public/favicon.ico" />

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
    @media (max-width: 992px) {
        .navbar-collapse {
            display: flex;
            flex-direction: column;
            align-items: center;
        }


        .dropdown {
            margin-top: 10px;
        }




    }
    </style>
</head>

<body class="pt-5 pt-md-5">
    <header>
        <!-- Fixed navbar -->
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-danger">
            <div class="container-fluid d-flex">
                <a class="navbar-brand" href="<?= base_url(route_to('inicio')) ?>"
                    style="font-family: 'Brush Script MT', cursive; color: #FFFFFF; font-size: 30px;">Comic-shop</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                    aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse align-items-center" id="navbarCollapse">
                    <form action="<?= base_url(route_to('search-comics')) ?>" method="get" class=" mx-auto w-50"
                        role="search">
                        <div class="input-group">
                            <input id="myInput" class="form-control form-control-lg" name="title" type="search"
                                placeholder="Buscar" aria-label="Buscar">

                            <button class="btn btn-dark ms-1 align-items-center input-group-append" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>



                    <ul class="navbar-nav align-items-center">
                        <li class="nav-item">
                            <a class="nav-link " aria-current="page"
                                href="<?= base_url(route_to('inicio')) ?>">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url(route_to('todos-los-comics')) ?>">Cómics</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url(route_to('latestComics')) ?>">Novedades</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url(route_to('carrito')) ?>">
                                <i class="fas fa-shopping-cart text-white">
                                    <span class="badge">
                                        <?php if (session()->has('user')): ?>
                                        <?= session()->get("comicCount_" . session()->get('user')['id']) ?? 0 ?>
                                        <?php else: ?>
                                        0
                                        <?php endif; ?>
                                    </span>
                                </i>
                            </a>
                        </li>
                    </ul>
                    <div class="dropdown">
        <?php if (session()->has('user')) : ?>
          <button class="btn btn-dark dropdown-toggle ms-2 align-items-center" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" style="color: white; min-width: 117px;">
            Mi perfil
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <li><a id="uniqueDropdownItem" class="dropdown-item" href="<?= base_url(route_to('perfil')) ?>">Ver perfil</a></li>
            <li><a id="uniqueDropdownItem" class="dropdown-item" href="<?= base_url(route_to('logout')) ?>">Cerrar sesión</a></li>
          </ul>
        <?php else : ?>
          <a class="btn btn-dark ms-2 align-items-center" style="color: white; min-width: 117px;" href="<?= base_url(route_to('login')) ?>">
            Iniciar sesión
          </a>
        <?php endif; ?>
      </div>
                </div>
            </div>
        </nav>

    </header>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script> <!-- Asegúrate de que este script esté al final de tu body -->
    <script>
    document.addEventListener('DOMContentLoaded', (event) => {
        document.querySelectorAll('.dropdown-item').forEach((item) => {
            item.addEventListener('mousedown', function() {
                this.style.backgroundColor = '#dc3545';
                this.style.color = 'white';
            });
            item.addEventListener('mouseup', function() {
                this.style.backgroundColor = '';
                this.style.color = '';
            });
        });
    });
    </script>

    <script>
    window.onload = function() {
        var input = document.getElementById('myInput');
        if (window.innerWidth >= 992) {
            input.style.marginLeft = '245px';
        } else {
            input.style.marginLeft = '0';
        }
    };

    window.onresize = function() {
        var input = document.getElementById('myInput');
        if (window.innerWidth >= 992) {
            input.style.marginLeft = '245px';
        } else {
            input.style.marginLeft = '0';
        }
    };
    </script>
</body>

</html>