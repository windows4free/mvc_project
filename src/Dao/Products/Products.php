<?php

namespace Dao\Products;

use Dao\Table;

class Products extends Table
{
    public static function getAllProd(): array
    {
        $prod = [];
        $sqlstr = "SELECT * from products";
        $prod = self::obtenerRegistros($sqlstr, []);
        return $prod;
    }
    public static function getProductById(int $productId): array
    {
        $sqltr = "SELECT * from products where productId= :productId;";
        $param = ["productId" => $productId];
        return self::obtenerUnRegistro($sqltr, $param);
    }

    public static function createProduct(
        $productName,
        $productDescription,
        $productPrice,
        $productImgUrl,
        $productStock,
        $productStatus,
    ): int {
        $sqlstr = "insert into products (productName, productDescription, productPrice, productImgUrl, productStock, productStatus) values (:productName, :productDescription, :productPrice, :productImgUrl, :productStock, :productStatus);";

        $affectedRow = self::executeNonQuery($sqlstr, [
            "productName" => $productName,
            "productDescription" => $productDescription,
            "productPrice" => $productPrice,
            "productImgUrl" => $productImgUrl,
            "productStock" => $productStock,
            "productStatus" => $productStatus,
        ]);
        return $affectedRow;
    }

    public static function updateProduct(
        $productId,
        $productName,
        $productDescription,
        $productPrice,
        $productImgUrl,
        $productStock,
        $productStatus,
    ): int {
        $sqlstr = "update products set productName = :productName, productDescription = :productDescription, productPrice = :productPrice, productImgUrl = :productImgUrl, productStock = :productStock, productStatus = :productStatus where productId = :productId;";

        $affectedRow = self::executeNonQuery($sqlstr, [
            "productId" => $productId,
            "productName" => $productName,
            "productDescription" => $productDescription,
            "productPrice" => $productPrice,
            "productImgUrl" => $productImgUrl,
            "productStock" => $productStock,
            "productStatus" => $productStatus,
        ]);
        return $affectedRow;
    }

    public static function deleteProduct($productId): int
    {
        $sqlstr = "delete from products where productId = :productId;";
        $affectedRow = self::executeNonQuery($sqlstr, ["productId" => $productId]);
        return $affectedRow;
    }

    public static function substractFromInventory($productId, $quantity)
    {
        $sqlstr = "UPDATE products SET productStock = productStock - :quantity WHERE productId = :productId AND productStock >= :quantity;";

        $params = [
            "quantity" => $quantity,
            "productId" => $productId
        ];

        return self::executeNonQuery($sqlstr, $params);
    }

    public static function getNewProducts()
    {
        $sql = "SELECT p.productId, p.productName, p.productDescription, p.productPrice, p.productImgUrl, p.productStatus FROM products p WHERE p.productStatus = 'ACT' ORDER BY p.productId DESC LIMIT 4";
        $params = [];
        $sqlQuery = self::obtenerRegistros($sql, $params);
        return $sqlQuery;
    }
}