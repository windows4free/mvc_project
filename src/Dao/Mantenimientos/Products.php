<?php

namespace Dao\Mantenimientos;

use Dao\Table;

class Products extends Table
{

    public static function getAllProducts(): array
    {
        $products = [];
        $sqlstr = "SELECT * from products;";
        $products = self::obtenerRegistros($sqlstr, []);
        return $products;
    }

    public static function getProductById(int $productId): array
    {
        $sqlstr = "SELECT * from products where productId= :productId;";
        $param = ["productId" => $productId];
        return self::obtenerUnRegistro($sqlstr, $param);
    }

    public static function crearProducto(
        $productName,
        $productDescription,
        $productPrice,
        $productImgUrl,
        $productStock,
        $productStatus
    ): int {
        $sqlstr = "insert into products ( productName, productDescription, productPrice, productImgUrl, productStock, productStatus)
                   values (:productName, :productDescription, :productPrice, :productImgUrl, :productStock, :productStatus);";

        $affectedRow = self::executeNonQuery($sqlstr, [
            "productName" => $productName,
            "productDescription" => $productDescription,
            "productPrice" => $productPrice,
            "productImgUrl" => $productImgUrl,
            "productStock" => $productStock,
            "productStatus" => $productStatus
        ]);
        return $affectedRow;
    }

    public static function actualizarProducto(
        $productId,
        $productName,
        $productDescription,
        $productPrice,
        $productImgUrl,
        $productStock,
        $productStatus
    ): int {
        $sqlstr = "update products set productName = :productName, productDescription = :productDescription, 
                    productPrice = :productPrice, productImgUrl = :productImgUrl, 
                    productStock = :productStock, productStatus = :productStatus
                    where productId = :productId;";

        $affectedRow = self::executeNonQuery($sqlstr, [
            "productId" => $productId,
            "productName" => $productName,
            "productDescription" => $productDescription,
            "productPrice" => $productPrice,
            "productImgUrl" => $productImgUrl,
            "productStock" => $productStock,
            "productStatus" => $productStatus
        ]);
        return $affectedRow;
    }

    public static function eliminarProducto(
        $productId
    ): int {
        $sqlstr = "delete from products where productId = :productId;";

        $affectedRow = self::executeNonQuery($sqlstr, ["productId" => $productId]);
        return $affectedRow;
    }
}

