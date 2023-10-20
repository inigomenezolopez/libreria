<?php echo $this->renderSection("navbar"); ?>

  
  

<header>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<!-- Fixed navbar -->
<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-danger align-items-center">
  <div class="container-fluid">
  <a class="navbar-brand" href="#" style="font-family: 'Brush Script MT', cursive; color: #FFFFFF; font-size: 30px;">Comic-shop</a>


    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end align-items-center" id="navbarCollapse">
    <ul class="navbar-nav align-items-center">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Cómics</a>
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
      
      <form class="d-flex me-2 " role="search">
  <input class="form-control" type="search" placeholder="Buscar" aria-label="Buscar">
  <button class="btn btn-dark ms-1" style="color: white;" type="submit">Buscar</button>
</form>
<button class="btn btn-dark ms-1" style="color: white;" type="submit">Iniciar sesión</button>



    </div>
    
    
  
</div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</header>


