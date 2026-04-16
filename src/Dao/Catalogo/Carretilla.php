<?php

namespace Dao\Catalogo;

use Dao\Table;

class Carretilla extends Table
{
    public static function getCarretillaByUser(int $usercod): array
    {
        $sqlstr = "SELECT c.usercod, c.productId, c.crrctd, c.crrprc, c.crrfching,
                          p.productName, p.productDescription, p.productImgUrl, p.productStock, p.productStatus
                   FROM carretilla c
                   INNER JOIN products p ON c.productId = p.productId
                   WHERE c.usercod = :usercod;";
        return self::obtenerRegistros($sqlstr, ["usercod" => $usercod]);
    }

    public static function agregarOActualizar(int $usercod, int $productId, int $cantidad, float $precio): int
    {
        $sqlstr = "INSERT INTO carretilla (usercod, productId, crrctd, crrprc, crrfching)
                   VALUES (:usercod, :productId, :crrctd, :crrprc, NOW())
                   ON DUPLICATE KEY UPDATE crrctd = :crrctd2, crrprc = :crrprc2, crrfching = NOW();";
        return self::executeNonQuery($sqlstr, [
            "usercod" => $usercod,
            "productId" => $productId,
            "crrctd" => $cantidad,
            "crrprc" => $precio,
            "crrctd2" => $cantidad,
            "crrprc2" => $precio,
        ]);
    }

    public static function eliminarItem(int $usercod, int $productId): int
    {
        $sqlstr = "DELETE FROM carretilla WHERE usercod = :usercod AND productId = :productId;";
        return self::executeNonQuery($sqlstr, ["usercod" => $usercod, "productId" => $productId]);
    }

    public static function vaciarCarretilla(int $usercod): int
    {
        $sqlstr = "DELETE FROM carretilla WHERE usercod = :usercod;";
        return self::executeNonQuery($sqlstr, ["usercod" => $usercod]);
    }

    public static function getTotalCarretilla(int $usercod): float
    {
        $sqlstr = "SELECT COALESCE(SUM(crrctd * crrprc), 0) as total FROM carretilla WHERE usercod = :usercod;";
        $result = self::obtenerUnRegistro($sqlstr, ["usercod" => $usercod]);
        return (float) ($result["total"] ?? 0);
    }

    public static function getConteoCarretilla(int $usercod): int
    {
        $sqlstr = "SELECT COALESCE(SUM(crrctd), 0) as conteo FROM carretilla WHERE usercod = :usercod;";
        $result = self::obtenerUnRegistro($sqlstr, ["usercod" => $usercod]);
        return (int) ($result["conteo"] ?? 0);
    }
}
