<section class="accept-section fullCenter">
  {{if ordenExitosa}}
  <div class="accept-box depth-1">
    <div class="accept-icon success"><i class="fas fa-check-circle"></i></div>
    <h2>¡Pago Exitoso!</h2>
    <p>Tu orden ha sido procesada correctamente. ¡Gracias por tu compra en Mirnas Exclusividades!</p>
    <p class="paypal-ref"><strong>Referencia PayPal:</strong> {{paypalId}}</p>
    <div class="accept-actions">
      <a href="index.php?page=Catalogo_Historial" class="primary">
        <i class="fas fa-history"></i> Ver Mis Pedidos
      </a>
      <a href="index.php?page=Catalogo_Catalogo">
        <i class="fas fa-store"></i> Seguir Comprando
      </a>
    </div>
  </div>
  {{endif ordenExitosa}}

  {{ifnot ordenExitosa}}
  <div class="accept-box depth-1">
    <div class="accept-icon error-icon"><i class="fas fa-exclamation-triangle"></i></div>
    <h2>No se encontró la orden</h2>
    <p>No pudimos verificar tu pago. Si crees que esto es un error, contáctanos.</p>
    <a href="https://wa.me/50488543260" target="_blank" class="primary">
      <i class="fab fa-whatsapp"></i> Contactar por WhatsApp
    </a>
  </div>
  {{endifnot ordenExitosa}}
</section>
