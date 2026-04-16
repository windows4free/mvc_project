<section class="container">
    <table class="">
        <thead>
            <tr>
                <th>Id Producto</th>
                <th>Nombre del Producto</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>URL Imagen</th>
                <th>Stock</th>
                <th>Estado</th>
                <th>
                    <a href="index.php?page=Mantenimientos-Products-Formulario&mode=INS&id=0">Nuevo</a>
                </th>
            </tr>
        </thead>
        <tbody>
            {{foreach products}}
            <tr>
                <td>{{productId}}</td>
                <td>{{productName}}</td>
                <td>{{productDescription}}</td>
                <td>{{productPrice}}</td>
                <td>{{productImgUrl}}</td>
                <td>{{productStock}}</td>
                <td>{{productStatus}}</td>
                <td>
                    <a href="index.php?page=Mantenimientos-Products-Formulario&mode=DSP&id={{productId}}">Mostrar</a>
                    <br/>
                    <a href="index.php?page=Mantenimientos-Products-Formulario&mode=UPD&id={{productId}}">Actualizar</a>
                    <br/>
                    <a href="index.php?page=Mantenimientos-Products-Formulario&mode=DEL&id={{productId}}">Eliminar</a>
                </td>
            </tr>
            {{endfor products}}
        </tbody>
    </table>
</section>
