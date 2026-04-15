<section class="catalogo-section">
  <div class="catalogo-header">
    <h2><i class="fas fa-store"></i> Catálogo</h2>
    <div class="filtros-categoria">
      {{foreach categorias}}
        <a href="index.php?page=Catalogo_Catalogo&categoria={{key}}"
           class="filtro-btn {{if active}}filtro-activo{{endif active}}">
          {{value}}
        </a>
      {{endfor categorias}}
    </div>
  </div>

  {{if productos}}
  <div class="productos-grid grid">
    {{foreach productos}}
    <div class="producto-card col-12 col-m-6 col-xl-4 depth-1">
      <div class="producto-img">
        <img src="{{productImgUrl}}" alt="{{productName}}" onerror="this.src='public/imgs/hero/1.jpg'" />
        <span class="producto-categoria">{{categoriaLabel}}</span>
      </div>
      <div class="producto-info">
        <h3>{{productName}}</h3>
        <p>{{productDescription}}</p>
        <div class="producto-footer">
          <span class="producto-precio">L {{productPrice}}</span>
          {{if sinStock}}
            <span class="producto-stock stock-bajo">Agotado</span>
          {{endif sinStock}}
          {{ifnot sinStock}}
            <span class="producto-stock">Stock: {{productStock}}</span>
          {{endifnot sinStock}}
        </div>
        {{ifnot sinStock}}
        <form action="index.php?page=Catalogo_Carretilla&accion=agregar" method="post">
          <input type="hidden" name="productId" value="{{productId}}" />
          <div class="cantidad-row">
            <label>Cantidad:</label>
            <input type="number" name="cantidad" value="1" min="1" max="{{productStock}}" class="input-cantidad" />
          </div>
          <button type="submit" class="btn-agregar primary">
            <i class="fas fa-cart-plus"></i> Agregar a Carretilla
          </button>
        </form>
        {{endifnot sinStock}}
        {{if sinStock}}
        <button class="btn-agregar" disabled>
          <i class="fas fa-ban"></i> Agotado
        </button>
        {{endif sinStock}}
      </div>
    </div>
    {{endfor productos}}
  </div>
  {{endif productos}}

  {{ifnot productos}}
  <div class="empty-state">
    <i class="fas fa-box-open"></i>
    <p>No hay productos disponibles en esta categoría.</p>
  </div>
  {{endifnot productos}}
</section>
