<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{SITE_TITLE}}</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{BASE_DIR}}/public/css/appstyle.css" />
  <link rel="stylesheet" href="{{BASE_DIR}}/public/css/mirnas.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  {{foreach SiteLinks}}
    <link rel="stylesheet" href="{{~BASE_DIR}}/{{this}}" />
  {{endfor SiteLinks}}
  {{foreach BeginScripts}}
    <script src="{{~BASE_DIR}}/{{this}}"></script>
  {{endfor BeginScripts}}
</head>
<body>
  <header class="mirnas-header">
    <input type="checkbox" class="menu_toggle" id="menu_toggle" />
    <label for="menu_toggle" class="menu_toggle_icon">
      <div class="hmb dgn pt-1"></div>
      <div class="hmb hrz"></div>
      <div class="hmb dgn pt-2"></div>
    </label>
    <div class="header-brand">
      <span class="brand-icon"><i class="fas fa-crown"></i></span>
      <h1>{{SITE_TITLE}}</h1>
    </div>
    <nav id="menu">
      <ul>
        <li><a href="index.php?page={{PUBLIC_DEFAULT_CONTROLLER}}"><i class="fas fa-home"></i>&nbsp;Inicio</a></li>
        {{foreach PUBLIC_NAVIGATION}}
            <li><a href="{{nav_url}}">{{nav_label}}</a></li>
        {{endfor PUBLIC_NAVIGATION}}
      </ul>
    </nav>
  </header>
  <main>
  {{{page_content}}}
  </main>
  <footer class="mirnas-footer">
    <div class="footer-content">
      <div class="footer-brand">
        <i class="fas fa-crown"></i>
        <strong>Mirnas Exclusividades</strong>
      </div>
      <div class="footer-info">
        <span><i class="fab fa-instagram"></i> <a href="https://instagram.com/mirnasexclusividades" target="_blank">@mirnasexclusividades</a></span>
        <span><i class="fab fa-whatsapp"></i> <a href="https://wa.me/50488543260" target="_blank">+504 8854-3260</a></span>
        <span><i class="fas fa-map-marker-alt"></i> Danli, El Paraiso, Barrio las Flores</span>
        <span><i class="fas fa-clock"></i> 9:00 a.m. – 6:00 p.m.</span>
      </div>
      <div class="footer-copy">
        &copy; {{~CURRENT_YEAR}} Mirnas Exclusividades. Todos los derechos reservados.
      </div>
    </div>
  </footer>
  {{foreach EndScripts}}
    <script src="{{~BASE_DIR}}/{{this}}"></script>
  {{endfor EndScripts}}
</body>
</html>
