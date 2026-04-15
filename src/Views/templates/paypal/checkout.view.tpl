<section class="checkout-section">
  <h2><i class="fab fa-paypal"></i> Confirmar Pago con PayPal</h2>

  <div class="grid">
    <div class="col-12 col-xl-8">
      <div class="checkout-resumen depth-1">
        <h3><i class="fas fa-receipt"></i> Resumen de tu Orden</h3>
        <table class="WWList">
          <thead>
            <tr>
              <th>Producto</th>
              <th>Cantidad</th>
              <th>Precio</th>
              <th>Subtotal</th>
            </tr>
          </thead>
          <tbody>
            {{foreach items}}
            <tr>
              <td>{{productName}}</td>
              <td>{{crrctd}}</td>
              <td>L {{crrprc}}</td>
              <td>L {{subtotal}}</td>
            </tr>
            {{endfor items}}
          </tbody>
        </table>
        <div class="checkout-total">
          <strong>Total a Pagar: L {{total}}</strong>
        </div>
      </div>
    </div>

    <div class="col-12 col-xl-4">
      <div class="paypal-box depth-1">
        <div class="paypal-logo">
          <i class="fab fa-paypal"></i> PayPal
        </div>
        <p>Serás redirigido a PayPal para completar tu pago de forma segura.</p>
        <form action="index.php?page=checkout_checkout" method="post">
          <button type="submit" class="btn-paypal">
            <i class="fab fa-paypal"></i> Pagar con PayPal
          </button>
        </form>
        <a href="index.php?page=Catalogo_Carretilla" class="btn-cancelar">
          <i class="fas fa-arrow-left"></i> Volver a la Carretilla
        </a>
        <div class="paypal-note">
          <i class="fas fa-lock"></i> Pago 100% seguro con PayPal
        </div>
      </div>
    </div>
  </div>
</section>
