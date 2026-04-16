<?php

namespace Controllers\Catalogo;

use Controllers\PublicController;
use Dao\Catalogo\Carretilla as CarretillaDAO;
use Dao\Catalogo\Productos;
use Utilities\Security;
use Utilities\Site;
use Views\Renderer;

class Carretilla extends PublicController
{
    public function run(): void
    {
        $viewData = array();
        $usercod  = Security::getUserId();
        $accion   = $_GET["accion"] ?? "";

        if ($accion === "agregar" && $this->isPostBack()) {
            $productId = intval($_POST["productId"] ?? 0);
            $cantidad  = intval($_POST["cantidad"] ?? 1);
            if ($productId > 0 && $cantidad > 0) {
                $producto = Productos::getProductoById($productId);
                if (!empty($producto)) {
                    CarretillaDAO::agregarOActualizar($usercod, $productId, $cantidad, (float)$producto["productPrice"]);
                }
            }
            Site::redirectTo("index.php?page=Catalogo_Carretilla");
            die();
        }

        if ($accion === "eliminar") {
            $productId = intval($_GET["productId"] ?? 0);
            if ($productId > 0) {
                CarretillaDAO::eliminarItem($usercod, $productId);
            }
            Site::redirectTo("index.php?page=Catalogo_Carretilla");
            die();
        }

        if ($accion === "vaciar") {
            CarretillaDAO::vaciarCarretilla($usercod);
            Site::redirectTo("index.php?page=Catalogo_Carretilla");
            die();
        }

        $items = CarretillaDAO::getCarretillaByUser($usercod);
        $total = CarretillaDAO::getTotalCarretilla($usercod);

        // Calcular subtotales por item
        foreach ($items as &$item) {
            $item["subtotal"] = number_format(
                (float)$item["crrctd"] * (float)$item["crrprc"],
                2
            );
            $item["crrprc"] = number_format((float)$item["crrprc"], 2);
        }
        unset($item);

        $viewData["items"]    = $items;
        $viewData["total"]    = number_format($total, 2);
        $viewData["hayItems"] = count($items) > 0;

        Renderer::render("catalogo/carretilla", $viewData);
    }
}
