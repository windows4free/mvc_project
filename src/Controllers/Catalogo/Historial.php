<?php

namespace Controllers\Catalogo;

use Controllers\PrivateController;
use Dao\Ordenes\Ordenes as OrdenesDAO;
use Utilities\Security;
use Views\Renderer;

class Historial extends PrivateController
{
    public function run(): void
    {
        $viewData = array();
        $usercod  = Security::getUserId();
        $ordenId  = intval($_GET["ordenId"] ?? 0);

        if ($ordenId > 0) {
            $orden   = OrdenesDAO::getOrdenById($ordenId, $usercod);
            $detalle = OrdenesDAO::getDetalleByOrden($ordenId);

            foreach ($detalle as &$item) {
                $item["subtotal"] = number_format(
                    (float)$item["detCantidad"] * (float)$item["detPrecio"],
                    2
                );
                $item["detPrecio"] = number_format((float)$item["detPrecio"], 2);
            }
            unset($item);

            $viewData["orden"]      = $orden;
            $viewData["detalle"]    = $detalle;
            $viewData["verDetalle"] = true;
        } else {
            $ordenes = OrdenesDAO::getHistorialByUser($usercod);

            foreach ($ordenes as &$ord) {
                $ord["ordenTotal"] = number_format((float)$ord["ordenTotal"], 2);
            }
            unset($ord);

            $viewData["ordenes"]    = $ordenes;
            $viewData["verDetalle"] = false;
        }

        Renderer::render("catalogo/historial", $viewData);
    }
}
