<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Colombiano, Coma Contento</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    body {
      background-color: #fffdf7;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .navbar {
      background: linear-gradient(to right, #fcd116, #003893, #ce1126);
      border-bottom-left-radius: 1rem;
      border-bottom-right-radius: 1rem;
    }
    .navbar-brand, .nav-link, footer {
      color: white !important;
      font-weight: 600;
    }
    .hero {
      background-image: url('imagenes/banner-colombia.jpg');
      background-size: cover;
      background-position: center;
      color: white;
      padding: 7rem 2rem;
      text-align: center;
      background-blend-mode: overlay;
      background-color: rgba(0, 0, 0, 0.4);
      border-radius: 0 0 2rem 2rem;
    }
    .hero h1 {
      font-size: 3.5rem;
      font-weight: bold;
    }
    .hero p {
      font-size: 1.2rem;
    }
    .section-title {
      font-weight: bold;
      font-size: 2rem;
      margin-bottom: 2rem;
    }
    .card {
      border: none;
      border-radius: 1.5rem;
      overflow: hidden;
      background-color: #fff;
      transition: transform 0.3s, box-shadow 0.3s;
    }
    .card:hover {
      box-shadow: 0 0 25px rgba(0,0,0,0.1);
      transform: translateY(-5px);
    }
    .card img {
      height: 180px;
      object-fit: cover;
      border-bottom: 5px solid #fcd116;
    }
    .btn-primary, .btn-warning, .btn-danger {
      border-radius: 50px;
      padding: 0.5rem 1.5rem;
    }
    footer {
      background-color: #003893;
      text-align: center;
      padding: 1.5rem;
      border-top-left-radius: 2rem;
      border-top-right-radius: 2rem;
      margin-top: 3rem;
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Colombiano, Coma Contento</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="#about">Nosotros</a></li>
          <li class="nav-item"><a class="nav-link" href="#modulos">Módulos</a></li>
          <li class="nav-item"><a class="nav-link" href="#contacto">Contacto</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <section class="hero">
    <h1>Bienvenidos a Colombiano, Coma Contento</h1>
    <p>Sabores auténticos de cada rincón de Colombia</p>
  </section>

  <section id="about" class="container py-5">
    <h2 class="text-center section-title">Sobre Nosotros</h2>
    <div class="row align-items-center">
      <div class="col-md-6 mb-4 mb-md-0">
        <img src="imagenes/restaurante.jpg" class="img-fluid rounded-4 shadow" alt="Restaurante">
      </div>
      <div class="col-md-6">
        <p>Bienvenido a “Colombiano, Coma Contento”, un rincón donde se vive, se siente y se saborea Colombia. Nuestro restaurante es más que un lugar para comer: es una experiencia que celebra la diversidad cultural y gastronómica de nuestra tierra. Cada plato que servimos es un homenaje a las tradiciones, ingredientes y saberes ancestrales que han pasado de generación en generación en las distintas regiones del país.</p>
        <p>Desde una bandeja paisa con sabor antioqueño, hasta un encocado de camarón con la esencia del Pacífico, pasando por un sabanero a la llanera, una mazamorra del altiplano cundiboyacense o una patarasca del Amazonas, en nuestro menú llevamos la bandera de Colombia en cada sabor, color y aroma. Porque aquí, ¡se come con orgullo patrio! </p>
        <p>Apoyados en nuestra plataforma tecnológica, gestionamos de forma moderna la creación de cartas, el análisis de ventas y la evaluación del desempeño gastronómico de cada región y momento del día (desayuno, almuerzo y cena). Así garantizamos que la sazón colombiana siga viva, evolucionando y deleitando a todos nuestros comensales.</p>
        <p>Colombiano, Coma Contento no solo es un restaurante: es un pedacito de patria servido en un plato. ¡Ven y déjate conquistar por el sabor de Colombia!</p>
      </div>
    </div>
  </section>

  <section id="modulos" class="container py-5">
    <h2 class="text-center section-title">Módulos del Sistema</h2>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="card text-center h-100">
          <img src="imagenes/ventas.jpg" alt="Ventas">
          <div class="p-4">
            <h5>Consultar Ventas</h5>
            <p>Revisa las estadísticas de ventas mensuales y anuales por plato.</p>
            <a href="ConsultarVentas.php" class="btn btn-warning">Ir al módulo</a>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card text-center h-100">
          <img src="imagenes/regiones.jpg" alt="Regiones">
          <div class="p-4">
            <h5>Ventas por Región</h5>
            <p>Consulta los platos más vendidos por región en distintos periodos.</p>
            <a href="VentasPorRegion.php" class="btn btn-warning">Ir al módulo</a>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card text-center h-100">
          <img src="imagenes/VentasPorMomento.jpg" alt="Momentos">
          <div class="p-4">
            <h5>Ventas por Momento</h5>
            <p>Revisa los platos más populares en desayuno, almuerzo y cena.</p>
            <a href="VentasPorMomento.php" class="btn btn-warning">Ir al módulo</a>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card text-center h-100">
          <img src="imagenes/Plato.jpg" alt="Crear Plato">
          <div class="p-4">
            <h5>Crear Platos</h5>
            <p>Registra nuevos platos con sus ingredientes y preparación.</p>
            <a href="CrearPlato.php" class="btn btn-primary">Ir al módulo</a>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card text-center h-100">
          <img src="imagenes/cartas.jpg" alt="Crear Carta">
          <div class="p-4">
            <h5>Crear Carta</h5>
            <p>Define una nueva carta, su vigencia y visualiza versiones anteriores.</p>
            <a href="CrearCarta.php" class="btn btn-primary">Ir al módulo</a>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card text-center h-100">
          <img src="imagenes/fotos.jpg" alt="Ver Fotografías">
          <div class="p-4">
            <h5>Ver Fotografías</h5>
            <p>Disfruta de la galería de nuestros platos típicos colombianos.</p>
            <a href="VerFotos.php" class="btn btn-danger">Ver fotos</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="contacto" class="container py-5">
    <h2 class="text-center section-title">Contacto</h2>
    <div class="row justify-content-center">
      <div class="col-md-6 text-center">
        <p><strong>Dirección:</strong> Calle 10 #20-30, Bogotá, Colombia</p>
        <p><strong>Teléfono:</strong> +57 310 123 4567</p>
        <p><strong>Email:</strong> info@comacontento.com.co</p>
        <p><strong>Horario:</strong> Lunes a Domingo de 7:00 am a 9:00 pm</p>
      </div>
    </div>
  </section>

  <footer>
    <p>&copy; 2025 Colombiano, Coma Contento. Todos los derechos reservados.</p>
  </footer>
</body>
</html>
