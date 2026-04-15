<section class="fullCenter">
  <div class="accept-box depth-1">
    <div class="accept-icon error-icon"><i class="fas fa-exclamation-circle"></i></div>
    <h2>Error {{CLIENT_ERROR_CODE}}</h2>
    <p>{{CLIENT_ERROR_MSG}}</p>
    {{if DEVELOPMENT}}
    <hr/>
    <pre style="text-align:left;font-size:0.8em;">Código: {{ERROR_CODE}}<br/>{{ERROR_MSG}}</pre>
    {{endif DEVELOPMENT}}
    <a href="index.php" class="primary"><i class="fas fa-home"></i> Volver al Inicio</a>
  </div>
</section>
