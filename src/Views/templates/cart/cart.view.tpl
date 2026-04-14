<h2>Carro de la compra</h2>

{{if isEmpty}}
<p>El carrito está vacío</p>
{{endif isEmpty}}

{{ifnot isEmpty}}
<div class="cart-container">
  <div class="items-list">
    {{foreach cartItems}}
    <div class="item-info">
      <img src="{{productImgUrl}}" alt="{{productName}}">
      <div class="item-details">
        <h3>{{productName}}</h3>
        <p>Cantidad: {{quantity}}</p>
        <p>Precio: {{productPrice}}</p>
      </div>
    </div>
    <hr>
    {{endfor cartItems}}
  </div>

  <div class="cart-summary">
    <div class="summary">
        <h2>Resumen</h2>
      <div class="summary-info">
        <p>Subtotal: {{cartTotal}}</p>
        <hr>
      </div>
      <div class="summary-total">
        <p>Total: {{cartTotal}}</p>
      </div>
    </div>
    <form action="index.php?page=Checkout_Checkout" method="post">
      <button type="submit">Realizar pedido</button>
    </form>
  </div>
</div>
{{endifnot isEmpty}}