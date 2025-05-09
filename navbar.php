<?php
if (isset($title)) {
  ?>
  <nav class="navbar navbar-expand-lg navbar-light" id="neubar">
    <div class="container">
      <a class="navbar-brand " href="prueba.php">
        <img src="img/logoTottus.png" alt="Bootstrap" width="191" height="35">
      </a>
      <button type="button" class="navbar-toggler" data-bs-toggle="collapse"
        data-bs-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="navbar-nav  mb-2 mb-lg-0">
          <li class="<?php if (isset($active_productos)) {
            echo $active_productos;
          } ?> nav-item">
            <a class="nav-link mx-2" href="prueba.php"><i class='bi bi-archive-fill'></i> Inventario</a>
          </li>
          <li class="<?php if (isset($active_categoria)) {
            echo $active_categoria;
          } ?> nav-item">
            <a class="nav-link mx-2" href="categorias.php"><i class='bi bi-tag-fill'></i> Categorías</a>
          </li>
          <li class="<?php if (isset($active_usuarios)) {
            echo $active_usuarios;
          } ?> nav-item">
            <a class="nav-link mx-2" href="usuarios.php"><i class='bi bi-person-vcard-fill'></i> Usuarios</a>
          </li>
          <li class="<?php if (isset($active_pedidos)) {
            echo $active_pedidos;
          } ?> nav-item">
            <a class="nav-link mx-2" href="pedidos.php"><i class='bi bi-bag-check-fill'></i> Pedidos</a>
          </li>
          <li class="<?php if (isset($active_clientes)) {
            echo $active_clientes;
          } ?> nav-item">
            <a class="nav-link mx-2" href="clientes.php"><i class='bi bi-people-fill'></i> Clientes</a>
          </li>
          <!--<li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class='bi bi-bar-chart-fill'></i> Informes
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="inform1.php">Registro Productos</a></li>
              <li><a class="dropdown-item" href="informe2.php">Recuento de Empleados</a></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
          </li>

          <!--<li><a class="dropdown-item" href="#"><i class='bi bi-flag-fill'></i> Generar Reporte</a></li>-->
        </ul>
        </li>
        </ul>
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="login.php?logout">
              <i class="bi bi-box-arrow-right"></i> Salir
            </a>
          </li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
  <?php
}
?>


<style>
  #neubar {
    background: #DFE9DE;
    box-shadow: 4px 6px 12px rgba(0, 0, 0, 0.4)
  }

  #neubar .nav-item a:focus,
  #neubar .nav-item a:hover {
    color: green;
    /* Cambia el color de texto a verde al hacer clic o pasar el ratón */
  }

  .nav-item .active {
    border-radius: 6px;
    background: linear-gradient(145deg, #ffe7ca, #f5d7b2);
    box-shadow: 4px 4px 8px #ddc1a0,
      -4px -4px 8px #f7e5cc;
  }

  #neubar .dropdown-menu a:hover {
    color: #454545
  }

  #neubar .nav-item {
    margin: auto 4px;
  }

  #neubar a {
    padding-left: 12px;
    padding-right: 12px;
  }

  #neubar .dropdown-menu {
    background: #DFE9DE
  }

  a.navbar-brand {
    color: #454545
  }

  .custom-dropdown .dropdown-menu {
    display: none;
  }

  .custom-dropdown .nav-link i {
    transition: transform 0.3s ease-in-out;
    transform: rotate(0deg);
  }
</style>