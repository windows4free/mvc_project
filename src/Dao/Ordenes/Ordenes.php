<?php

namespace Dao\Ordenes;

/**
 * DAO para el historial de compras.
 * Maneja las tablas `ordenes` y `detalle_ordenes`.
 */
class Ordenes extends \Dao\Table
{
    /**
     * Guarda una orden nueva y su detalle.
     * Llamar desde el controller de Accept después de capturar el pago.
     *
     * @param int    $usercod       ID del usuario
     * @param string $paypalOrderId ID de la orden en PayPal
     * @param array  $items         Ítems de la carretilla
     * @return int|false  ID de la orden creada, o false si falla
     */
    public static function guardarOrden(int $usercod, string $paypalOrderId, array $items)
    {
        $conn = self::getConn();

        try {
            $conn->beginTransaction();

            // Calcular total
            $total = 0.0;
            foreach ($items as $item) {
                $total += floatval($item['crrprc']) * intval($item['crrctd']);
            }

            // Insertar cabecera de orden
            $sqlOrden = "INSERT INTO ordenes (usercod, paypalOrderId, ordenFecha, ordenTotal, ordenEstado)
                         VALUES (:usercod, :paypalOrderId, NOW(), :ordenTotal, 'COMPLETADA')";

            self::executeNonQuery($sqlOrden, [
                'usercod'       => $usercod,
                'paypalOrderId' => $paypalOrderId,
                'ordenTotal'    => $total,
            ], $conn);

            $ordenId = intval($conn->lastInsertId());

            // Insertar cada línea de detalle
            $sqlDetalle = "INSERT INTO detalle_ordenes
                               (ordenId, productId, productName, productImgUrl, detCantidad, detPrecio)
                           VALUES
                               (:ordenId, :productId, :productName, :productImgUrl, :detCantidad, :detPrecio)";

            foreach ($items as $item) {
                self::executeNonQuery($sqlDetalle, [
                    'ordenId'       => $ordenId,
                    'productId'     => intval($item['productId']),
                    'productName'   => $item['productName']   ?? '',
                    'productImgUrl' => $item['productImgUrl'] ?? '',
                    'detCantidad'   => intval($item['crrctd']),
                    'detPrecio'     => floatval($item['crrprc']),
                ], $conn);
            }

            $conn->commit();
            return $ordenId;
        } catch (\Exception $ex) {
            $conn->rollBack();
            throw $ex;
        }
    }

    /**
     * Retorna todas las órdenes de un usuario, ordenadas de más reciente a más antigua.
     *
     * @param int $usercod
     * @return array
     */
    public static function getHistorialByUser(int $usercod): array
    {
        $sql = "SELECT ordenId,
                       paypalOrderId,
                       DATE_FORMAT(ordenFecha, '%d/%m/%Y %H:%i') AS ordenFecha,
                       ordenTotal,
                       ordenEstado
                FROM   ordenes
                WHERE  usercod = :usercod
                ORDER  BY ordenFecha DESC";

        return self::obtenerRegistros($sql, ['usercod' => $usercod]);
    }

    /**
     * Retorna la cabecera de una orden específica, verificando que pertenezca al usuario.
     *
     * @param int $ordenId
     * @param int $usercod
     * @return array|false
     */
    public static function getOrdenById(int $ordenId, int $usercod)
    {
        $sql = "SELECT ordenId,
                       paypalOrderId,
                       DATE_FORMAT(ordenFecha, '%d/%m/%Y %H:%i') AS ordenFecha,
                       ordenTotal,
                       ordenEstado
                FROM   ordenes
                WHERE  ordenId = :ordenId
                  AND  usercod = :usercod
                LIMIT  1";

        return self::obtenerUnRegistro($sql, [
            'ordenId' => $ordenId,
            'usercod' => $usercod,
        ]);
    }

    /**
     * Retorna el detalle (líneas) de una orden.
     *
     * @param int $ordenId
     * @return array
     */
    public static function getDetalleByOrden(int $ordenId): array
    {
        $sql = "SELECT detId,
                       productId,
                       productName,
                       productImgUrl,
                       detCantidad,
                       detPrecio
                FROM   detalle_ordenes
                WHERE  ordenId = :ordenId
                ORDER  BY detId ASC";

        return self::obtenerRegistros($sql, ['ordenId' => $ordenId]);
    }
}
