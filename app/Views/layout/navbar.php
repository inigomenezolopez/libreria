<?php echo $this->renderSection("navbar"); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

<body class="pt-5 pt-md-5">
  <header>

    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-danger align-items-center" style="padding-top: 0.01rem; padding-bottom: 0.01rem;">
      <div class="container-fluid">
        <a class="navbar-brand" href="#" style="font-family: 'Brush Script MT', cursive; color: #FFFFFF; font-size: 30px;">Comic-shop</a>


        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">

          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end align-items-center" id="navbarCollapse">
          <ul class="navbar-nav align-items-center">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="<?= base_url(route_to('inicio')) ?>">Inicio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= base_url(route_to('todos-los-comics')) ?>">Cómics</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Novedades</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Autor</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#"><i class="fas fa-shopping-cart text-white"></i></a>
            </li>
          </ul>
          <form class="d-flex align-items-center" role="search" style="align-items: center;">
            <input class="form-control " type="search" placeholder="Buscar" aria-label="Buscar" style="margin-top: 10px;">
            <button class="btn btn-dark ms-1 align-items-center" style="color: white; margin-top: 10px;" type="submit">Buscar</button>
            <button class="btn btn-dark ms-2 " style="color: white; min-width: 117px; margin-top: 10px;" type="submit">Iniciar sesión</button>
          </form>







        </div>



      </div>
    </nav>

  </header>
</body>

