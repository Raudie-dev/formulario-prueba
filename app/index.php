<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Portfolio</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Loading animation -->
    <div class="loader">
        <div class="loader-spinner"></div>
    </div>

    <!-- Scroll indicator -->
    <div class="scroll-indicator"></div>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1 data-aos="fade-down">Hola, soy Juan Arana</h1>
            <p data-aos="fade-up">Desarrollador Backend | Apasionado por Python y Django</p>
            <a href="#projects" class="btn btn-light" data-aos="fade-up" data-aos-delay="200">Ver Proyectos</a>
        </div>
    </section>

    <!-- Section Divider -->
    <div class="section-divider"></div>

    <!-- About Section -->
    <section id="about" class="primary-section about-section">
        <div class="container">
            <div class="text-center" data-aos="fade-up">
                <h2>Sobre Mí</h2>
            </div>
            <div class="row about-container">
                <div class="col-md-6 about-image-container" data-aos="fade-right">
                    <img src="img/Imagen de WhatsApp 2024-10-27 a las 10.49.37_06a6c492.jpg" alt="Mi foto" class="profile-image" class="img-fluid rounded-circle">
                </div>
                <div class="col-md-6 about-content" data-aos="fade-left">
                    <p class="about-text text-justify">
                      Soy un programador junior y estudiante de Ingeniería Informática, apasionado por el desarrollo backend y con un entusiasmo constante por aprender y emprender en el mundo digital.
                    </p>
                    <p class="about-text text-justify">
                      Mi meta en la vida es dejar una huella significativa, mientras doy lo mejor de mí en cada proyecto y en cada paso que doy hacia adelante.
                    </p>
                    <p class="about-text text-justify">
                        Cuando no estoy programando, me gusta explorar nuevas tecnologías, leer sobre desarrollo web y contribuir a proyectos de código abierto.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Projects Section -->
    <section id="proyectos" class="secondary-section projects-section">
        <div class="container">
            <div class="text-center" data-aos="fade-up">
                <h2>Mis Proyectos</h2>
            </div>
            <div class="row projects-container">
                <!-- Project 1 -->
                <div class="col-md-4 project-wrapper" data-aos="fade-up">
                    <div class="project-card">
                        <img src="img/project1.jpg" alt="Proyecto 1" class="project-image">
                        <div class="project-content">
                            <h5 class="project-title">E-commerce Website</h5>
                            <p class="project-description">Plataforma de comercio electrónico con carrito de compras, pagos y gestión de productos.</p>
                            <a href="#" class="btn btn-primary project-button project-button-primary">Ver Demo</a>
                            <a href="#" class="btn btn-success project-button project-button-secondary">Ver Código</a>
                        </div>
                    </div>
                </div>
                <!-- Project 2 -->
                <div class="col-md-4 project-wrapper" data-aos="fade-up" data-aos-delay="100">
                    <div class="project-card">
                        <img src="img/project2.jpg" alt="Proyecto 2" class="project-image">
                        <div class="project-content">
                            <h5 class="project-title">App de Gestión</h5>
                            <p class="project-description">Aplicación para gestión de tareas y proyectos con funcionalidades colaborativas.</p>
                            <a href="#" class="btn btn-primary project-button project-button-primary">Ver Demo</a>
                            <a href="#" class="btn btn-success project-button project-button-secondary">Ver Código</a>
                        </div>
                    </div>
                </div>
                <!-- Project 3 -->
                <div class="col-md-4 project-wrapper" data-aos="fade-up" data-aos-delay="200">
                    <div class="project-card">
                        <img src="img/project3.jpg" alt="Proyecto 3" class="project-image">
                        <div class="project-content">
                            <h5 class="project-title">Blog Personal</h5>
                            <p class="project-description">Blog con sistema de gestión de contenidos y comentarios para artículos técnicos.</p>
                            <a href="#" class="btn btn-primary project-button project-button-primary">Ver Demo</a>
                            <a href="#" class="btn btn-success project-button project-button-secondary">Ver Código</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Skills Section -->
    <section id="habilidades" class="primary-section skills-section">
          <div class="container">
          <div class="text-center" data-aos="fade-up">
              <h2>Mis Habilidades</h2>
          </div>
          <div class="row text-center skills-container">
            <!-- Git -->
            <div class="col-6 col-md-4 col-lg-2 mb-4 skill-item">
              <i class="skill-icon fab fa-git-alt fa-5x text-primary mb-2" data-bs-toggle="collapse" data-bs-target="#collapseGit" aria-expanded="false" aria-controls="collapseGit"></i>
              <h5 class="skill-name">Git</h5>
              <div class="collapse" id="collapseGit">
                <div class="skill-details">
                  <div class="skill-details-content">
                    Control de versiones distribuido para gestionar proyectos y colaboración.
                  </div>
                </div>
              </div>
            </div>
            <!-- GitHub -->
            <div class="col-6 col-md-4 col-lg-2 mb-4 skill-item">
              <i class="skill-icon fab fa-github fa-5x text-light mb-2" data-bs-toggle="collapse" data-bs-target="#collapseGitHub" aria-expanded="false" aria-controls="collapseGitHub"></i>
              <h5 class="skill-name">GitHub</h5>
              <div class="collapse" id="collapseGitHub">
                <div class="skill-details">
                  <div class="skill-details-content">
                    Plataforma para alojar y gestionar repositorios de código con Git.
                  </div>
                </div>
              </div>
            </div>
            <!-- Django -->
            <div class="col-6 col-md-4 col-lg-2 mb-4 skill-item">
              <i class="skill-icon fab fa-python fa-5x text-warning mb-2" data-bs-toggle="collapse" data-bs-target="#collapseDjango" aria-expanded="false" aria-controls="collapseDjango"></i>
              <h5 class="skill-name">Django</h5>
              <div class="collapse" id="collapseDjango">
                <div class="skill-details">
                  <div class="skill-details-content">
                    Framework web de Python para construir aplicaciones rápidas y seguras.
                  </div>
                </div>
              </div>
            </div>
            <!-- HTML -->
            <div class="col-6 col-md-4 col-lg-2 mb-4 skill-item">
              <i class="skill-icon fab fa-html5 fa-5x text-danger mb-2" data-bs-toggle="collapse" data-bs-target="#collapseHTML" aria-expanded="false" aria-controls="collapseHTML"></i>
              <h5 class="skill-name">HTML</h5>
              <div class="collapse" id="collapseHTML">
                <div class="skill-details">
                  <div class="skill-details-content">
                    Lenguaje de marcado estándar para crear estructuras web.
                  </div>
                </div>
              </div>
            </div>
            <!-- CSS -->
            <div class="col-6 col-md-4 col-lg-2 mb-4 skill-item">
              <i class="skill-icon fab fa-css3-alt fa-5x text-primary mb-2" data-bs-toggle="collapse" data-bs-target="#collapseCSS" aria-expanded="false" aria-controls="collapseCSS"></i>
              <h5 class="skill-name">CSS</h5>
              <div class="collapse" id="collapseCSS">
                <div class="skill-details">
                  <div class="skill-details-content">
                    Lenguaje para estilizar páginas web y hacerlas visualmente atractivas.
                  </div>
                </div>
              </div>
            </div>
            <!-- Linux -->
            <div class="col-6 col-md-4 col-lg-2 mb-4 skill-item">
              <i class="skill-icon fab fa-linux fa-5x text-success mb-2" data-bs-toggle="collapse" data-bs-target="#collapseLinux" aria-expanded="false" aria-controls="collapseLinux"></i>
              <h5 class="skill-name">Linux</h5>
              <div class="collapse" id="collapseLinux">
                <div class="skill-details">
                  <div class="skill-details-content">
                    Sistema operativo de código abierto para servidores y desarrolladores.
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="secondary-section contact-section">
        <div class="container">
            <div class="text-center" data-aos="fade-up">
                <h2>Contacto</h2>
            </div> 
            <div class="row contact-container">
              <div class="col-md-6 contact-info-container" data-aos="fade-left">
                  <div class="contact-form">
                      <h5 class="contact-heading">Información de Contacto</h5>
                      <p class="contact-info">
                          <i class="fas fa-map-marker-alt contact-icon"></i>
                          Guarico - Venezuela
                      </p>
                      <p class="contact-info">
                          <i class="fas fa-envelope contact-icon"></i>
                          <a href="mailto:juandiegoaranaperez@gmail.com" class="contact-link">juandiegoaranaperez@gmail.com</a>
                      </p>
                      <p class="contact-info">
                          <i class="fas fa-phone contact-icon"></i>
                          <a href="tel:+584243284360" class="contact-link">+58 424-3284360</a>
                      </p>
                      <h5 class="contact-heading">Redes Sociales</h5>
                      <div class="social-icons">
                        <p class="contact-info">
                            <i class="fab fa-linkedin contact-icon"></i>
                            <a href="https://www.linkedin.com/in/juan-diego-arana-perez-2a467530b/" target="_blank" class="contact-link">Linkedin</a>
                        </p>
                        <p class="contact-info">
                            <i class="fab fa-github contact-icon"></i>
                            <a href="https://github.com/JuanDiego3030" target="_blank" class="contact-link">GitHub</a>
                        </p>
                        <p class="contact-info">
                            <i class="fab fa-instagram contact-icon"></i>
                            <a href="https://www.instagram.com/juandiego.arana/" target="_blank" class="contact-link">Instagram</a>
                        </p>
                      </div>
                  </div>
              </div>
                <div class="col-md-6 contact-form-container" data-aos="fade-right">
                    <div class="contact-form">
                        <form id="contactForm">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" placeholder="Tu nombre">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="tu@email.com">
                            </div>
                            <div class="mb-3">
                                <label for="mensaje" class="form-label">Mensaje</label>
                                <textarea class="form-control" id="mensaje" rows="5" placeholder="Tu mensaje"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary contact-submit-button">Enviar Mensaje</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="container">
            <p class="footer-text">© 2023 Mi Portfolio. Todos los derechos reservados.</p>
            <div>
                <a href="#" class="footer-link"><i class="fas fa-home footer-icon"></i>Inicio</a>
                <a href="#about" class="footer-link"><i class="fas fa-user footer-icon"></i>Sobre Mí</a>
                <a href="#proyectos" class="footer-link"><i class="fas fa-code footer-icon"></i>Proyectos</a>
                <a href="#contact" class="footer-link"><i class="fas fa-envelope footer-icon"></i>Contacto</a>
            </div>
        </div>
    </footer>

    <!-- Back to top button -->
    <button class="back-to-top">
        <i class="fas fa-arrow-up"></i>
    </button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="script.js"></script>
</body>
</html>
