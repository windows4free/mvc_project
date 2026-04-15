<section class="carretilla-section">
  <h2><i class="fas fa-shopping-cart"></i> Mi Carretilla de Compras</h2>

  {{if hayItems}}
  <div class="grid">
    <div class="col-12 col-xl-8">
      <table class="WWList carretilla-tabla">
        <thead>
          <tr>
            <th>Producto</th>
            <th>Precio Unitario</th>
            <th>Cantidad</th>
            <th>Subtotal</th>
            <th>Acción</th>
          </tr>
        </thead>
        <tbody>
          {{foreach items}}
          <tr>
            <td>
              <div class="carr-producto">
                <img src="{{productImgUrl}}" alt="{{productName}}" onerror="this.src='public/imgs/hero/1.jpg'" />
                <span>{{productName}}</span>
              </div>
            </td>
            <td>L {{crrprc}}</td>
            <td>{{crrctd}}</td>
            <td>L {{subtotal}}</td>
            <td>
              <a href="index.php?page=Catalogo_Carretilla&accion=eliminar&productId={{productId}}"
                 class="btn-eliminar"
                 onclick="return confirm('¿Eliminar este producto de la carretilla?')">
                <i class="fas fa-trash"></i>
              </a>
            </td>
          </tr>
          {{endfor items}}
        </tbody>
      </table>
    </div>

    <div class="col-12 col-xl-4">
      <div class="resumen-orden depth-1">
        <h3><i class="fas fa-receipt"></i> Resumen de Orden</h3>
        <div class="resumen-total">
          <span>Total:</span>
          <strong>L {{total}}</strong>
        </div>
        <a href="index.php?page=Checkout_Checkout" class="btn-pagar primary">
          <i class="fab fa-paypal"></i> Proceder al Pago con PayPal
        </a>
        <a href="index.php?page=Catalogo_Carretilla&accion=vaciar"
           class="btn-vaciar"
           onclick="return confirm('¿Desea vaciar toda la carretilla?')">
          <i class="fas fa-trash-alt"></i> Vaciar Carretilla
        </a>
        <a href="index.php?page=Catalogo_Catalogo" class="btn-seguir">
          <i class="fas fa-arrow-left"></i> Seguir Comprando
        </a>
      </div>
    </div>
  </div>
  {{endif hayItems}}

  {{ifnot hayItems}}
  <div class="empty-state">
    <i class="fas fa-shopping-cart"></i>
    <p>Tu carretilla está vacía.</p>
    <a href="index.php?page=Catalogo_Catalogo" class="btn-catalogo primary">
      <i class="fas fa-store"></i> Ir al Catálogo
    </a>
  </div>
  {{endifnot hayItems}}
</section>
