<h1>{{modeDsc}}</h1>
<section class="grid row">
    <form class="depth-0 offset-3 col-6" action="index.php?page=Mantenimientos_Products_Formulario&mode={{mode}}&id={{productId}}" method="POST" >
        <div class="row align-center">
            <div class="col-4">
                <label for="productId">Código</label>
            </div>
            <div class="col-8">
                <input type="text" value="{{productId}}" disabled name="productIdux" id="productId" readonly/>
                <input type="hidden" name="productId" value="{{productId}}" />
                <input type="hidden" name="uuid" value="{{xsrf_token}}" />
            </div>
        </div>
         <div class="row align-center">
            <div class="col-4">
                <label for="productName">Nombre del Producto</label>
            </div>
            <div class="col-8">
                <input type="text" name="productName" id="productName" value="{{productName}}" placeholder="Nombre del Producto" {{isReadonly}} />
            </div>
        </div>
        <div class="row align-start">
            <div class="col-4">
                <label for="productDescription">Descripción</label>
            </div>
            <div class="col-8">
                <textarea id="productDescription" name="productDescription" placeholder="Descripción del Producto" cols="40" rows="8" {{isReadonly}}>{{productDescription}}</textarea>
            </div>
        </div>
         <div class="row align-center">
            <div class="col-4">
                <label for="productPrice">Precio</label>
            </div>
            <div class="col-8">
                <input type="text" name="productPrice" id="productPrice" value="{{productPrice}}" {{isReadonly}} placeholder="Precio del Producto" />
            </div>
        </div>
         <div class="row align-center">
            <div class="col-4">
                <label for="productImgUrl">URL de la Imagen</label>
            </div>
            <div class="col-8">
                <input type="text" name="productImgUrl" id="productImgUrl" {{isReadonly}} value="{{productImgUrl}}" placeholder="URL de la imagen del producto" />
            </div>
        </div>
        <div class="row align-center">
            <div class="col-4">
                <label for="productStock">Stock</label>
            </div>
            <div class="col-8">
                <input type="text" name="productStock" id="productStock" value="{{productStock}}" {{isReadonly}} placeholder="Stock del Producto" />
            </div>
<div class="row align-center">
    <div class="col-4">
        <label for="productStatus">Estado</label>
    </div>
    <div class="col-8">
        <select name="productStatus" id="productStatus" {{if ~readonly}} disabled {{endif ~readonly}}>
            <option value="ACT" {{productStatus_act}}>Activo</option>
            <option value="INA" {{productStatus_ina}}>Inactivo</option>
        </select>
    </div>
</div>
        {{if confirmToolTip}}
            <div class="error">
                {{confirmToolTip}}
            </div>
        {{endif confirmToolTip}}
        <div class="right">
            {{ifnot hideConfirm}}
            <button type="submit" name="btnEnviar">Confirmar</button>
            {{endifnot hideConfirm}}
            &nbsp;
            <button id="btnCancelar">Cancelar</button>
        </div>
    </form>
</section>
<script>
    document.addEventListener("DOMContentLoaded", ()=>{
        document.getElementById("btnCancelar").addEventListener("click", (e)=>{
            e.preventDefault();
            e.stopPropagation();
            window.location.assign("index.php?page=Mantenimientos_Products_Listado");
        });
    });
</script>