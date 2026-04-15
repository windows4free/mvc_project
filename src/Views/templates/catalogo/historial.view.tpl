<section class="historial-section">
  <h2><i class="fas fa-history"></i> Historial de Pedidos</h2>

  {{if verDetalle}}
  <div class="historial-detalle">
    <div class="detalle-header">
      <h3>Detalle de Orden #{{orden.ordenId}}</h3>
      <span class="orden-estado estado-{{orden.ordenEstado}}">{{orden.ordenEstado}}</span>
    </div>
    <p><strong>Fecha:</strong> {{orden.ordenFecha}}</p>
    <p><strong>PayPal ID:</strong> {{orden.paypalOrderId}}</p>

    <table class="WWList">
      <thead>
        <tr>
          <th>Producto</th>
          <th>Cantidad</th>
          <th>Precio Unitario</th>
          <th>Subtotal</th>
        </tr>
      </thead>
      <tbody>
        {{foreach detalle}}
        <tr>
          <td>
            <div class="carr-producto">
              <img src="{{productImgUrl}}" alt="{{productName}}" onerror="this.src='public/imgs/hero/1.jpg'" />
              <span>{{productName}}</span>
            </div>
          </td>
          <td>{{detCantidad}}</td>
          <td>L {{detPrecio}}</td>
          <td>L {{subtotal}}</td>
        </tr>
        {{endfor detalle}}
      </tbody>
    </table>

    <div class="detalle-total">
      <strong>Total Pagado: L {{orden.ordenTotal}}</strong>
    </div>

    <a href="index.php?page=Catalogo_Historial" class="btn-volver">
      <i class="fas fa-arrow-left"></i> Volver al Historial
    </a>
  </div>
  {{endif verDetalle}}

  {{ifnot verDetalle}}
  {{if ordenes}}
  <table class="WWList">
    <thead>
      <tr>
        <th>Orden #</th>
        <th>Fecha</th>
        <th>Total</th>
        <th>Estado</th>
        <th>Acción</th>
      </tr>
    </thead>
    <tbody>
      {{foreach ordenes}}
      <tr>
        <td>#{{ordenId}}</td>
        <td>{{ordenFecha}}</td>
        <td>L {{ordenTotal}}</td>
        <td><span class="orden-estado estado-{{ordenEstado}}">{{ordenEstado}}</span></td>
        <td>
          <a href="index.php?page=Catalogo_Historial&ordenId={{ordenId}}" class="btn-detalle">
            <i class="fas fa-eye"></i> Ver Detalle
          </a>
        </td>
      </tr>
      {{endfor ordenes}}
    </tbody>
  </table>
  {{endif ordenes}}

  {{ifnot ordenes}}
  <div class="empty-state">
    <i class="fas fa-box-open"></i>
    <p>Aún no tienes pedidos realizados.</p>
    <a href="index.php?page=Catalogo_Catalogo" class="primary">
      <i class="fas fa-store"></i> Ir al Catálogo
    </a>
  </div>
  {{endifnot ordenes}}
  {{endifnot verDetalle}}
</section>
