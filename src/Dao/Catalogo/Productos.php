<?php

namespace Dao\Catalogo;

use Dao\Table;

class Productos extends Table
{
    public static function getAllProductosActivos(): array
    {
        $sqlstr = "SELECT * FROM products WHERE productStatus IN ('ACT') ORDER BY productCategory, productName;";
        return self::obtenerRegistros($sqlstr, []);
    }

    public static function getProductosByCategoria(string $categoria): array
    {
        $sqlstr = "SELECT * FROM products WHERE productStatus IN ('ACT') AND productCategory = :categoria ORDER BY productName;";
        return self::obtenerRegistros($sqlstr, ["categoria" => $categoria]);
    }

    public static function getProductoById(int $productId): array
    {
        $sqlstr = "SELECT * FROM products WHERE productId = :productId;";
        return self::obtenerUnRegistro($sqlstr, ["productId" => $productId]);
    }

    public static function getAllProductos(): array
    {
        $sqlstr = "SELECT * FROM products ORDER BY productCategory, productName;";
        return self::obtenerRegistros($sqlstr, []);
    }

    public static function crearProducto(
        $productName,
        $productDescription,
        $productPrice,
        $productImgUrl,
        $productStock,
        $productStatus,
        $productCategory
    ): int {
        $sqlstr = "INSERT INTO products (productName, productDescription, productPrice, productImgUrl, productStock, productStatus, productCategory)
                   VALUES (:productName, :productDescription, :productPrice, :productImgUrl, :productStock, :productStatus, :productCategory);";
        return self::executeNonQuery($sqlstr, [
            "productName" => $productName,
            "productDescription" => $productDescription,
            "productPrice" => $productPrice,
            "productImgUrl" => $productImgUrl,
            "productStock" => $productStock,
            "productStatus" => $productStatus,
            "productCategory" => $productCategory
        ]);
    }

    public static function actualizarProducto(
        $productId,
        $productName,
        $productDescription,
        $productPrice,
        $productImgUrl,
        $productStock,
        $productStatus,
        $productCategory
    ): int {
        $sqlstr = "UPDATE products SET productName = :productName, productDescription = :productDescription,
                    productPrice = :productPrice, productImgUrl = :productImgUrl, productStock = :productStock,
                    productStatus = :productStatus, productCategory = :productCategory
                    WHERE productId = :productId;";
        return self::executeNonQuery($sqlstr, [
            "productId" => $productId,
            "productName" => $productName,
            "productDescription" => $productDescription,
            "productPrice" => $productPrice,
            "productImgUrl" => $productImgUrl,
            "productStock" => $productStock,
            "productStatus" => $productStatus,
            "productCategory" => $productCategory
        ]);
    }

    public static function eliminarProducto(int $productId): int
    {
        $sqlstr = "UPDATE products SET productStatus = 'INA' WHERE productId = :productId;";
        return self::executeNonQuery($sqlstr, ["productId" => $productId]);
    }
}
