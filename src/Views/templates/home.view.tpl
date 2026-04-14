<body>
    <h1>Mirnas Exclusividades</h1>

    <div class="cart">
        <a href="index.php?page=Cart_ShoppingCart">
            <p>Ver carrito</p>
        </a>
    </div>

    <div class="product-container">
        {{foreach productsNew}}
        <div class="product-info" data-productId="{{productId}}">
            <img src="{{productImgUrl}}" alt="{{productName}}">
            <h2>{{productName}}</h2>
            <p class="productPrice">{{productPrice}}</p>
            <p>{{productDescription}}</p>

            <div class="add-to-cart">
                <form action="index.php?page=Cart_AddToCart" method="POST">
                    <input type="hidden" name="productId" value="{{productId}}">
                    <input type="hidden" name="quantity" value="1">
                    <button>Agregar al carrito</button>
                </form>
            </div>
        </div>
        {{endfor productsNew}}
    </div>

</body>