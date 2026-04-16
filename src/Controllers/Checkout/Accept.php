<?php

namespace Controllers\Checkout;

use Controllers\PublicController;
use Dao\Products\Products as ProductDAO;
use Dao\Catalogo\Carretilla as CarretillaDAO;
use Dao\Ordenes\Ordenes as OrdenesDAO;

class Accept extends PublicController
{
    public function run(): void
    {
        $dataview = array();
        $token         = $_GET["token"]       ?: "";
        $session_token = $_SESSION["orderid"] ?: "";

        if ($token !== "" && $token == $session_token) {

            $PayPalRestApi = new \Utilities\PayPal\PayPalRestApi(
                \Utilities\Context::getContextByKey("PAYPAL_CLIENT_ID"),
                \Utilities\Context::getContextByKey("PAYPAL_CLIENT_SECRET")
            );
            $result = $PayPalRestApi->captureOrder($session_token);

            $usercod = \Utilities\Security::getUserId();
            $items   = CarretillaDAO::getCarretillaByUser($usercod);

            // Guardar la orden en el historial
            OrdenesDAO::guardarOrden($usercod, $session_token, $items);

            // Descontar inventario y vaciar carretilla
            foreach ($items as $item) {
                $productId = $item["userprd"] ?? $item["productId"];
                $quantity  = intval($item["crrctd"]);
                if ($productId) {
                    ProductDAO::substractFromInventory($productId, $quantity);
                }
            }
            CarretillaDAO::vaciarCarretilla($usercod);
            unset($_SESSION["cart"]);
            unset($_SESSION["orderid"]);

            // Datos que necesita la vista
            $dataview["ordenExitosa"] = true;
            $dataview["paypalId"]     = $session_token;

        } else {
            $dataview["ordenExitosa"] = false;
        }

        \Views\Renderer::render("paypal/accept", $dataview);
    }
}
