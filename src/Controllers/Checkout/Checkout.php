<?php

namespace Controllers\Checkout;

use Controllers\PublicController;
use Dao\Products\Products as ProductDAO;
use Utilities\Site as Site;
use Utilities\Security;
use Dao\Catalogo\Carretilla as CarretillaDAO;

class Checkout extends PublicController
{
    public function run(): void
    {
        $viewData = array();
        $usercod = Security::getUserId();
        
        // ===== AGREGAR ESTO: Obtener datos del carrito =====
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
        
        // Enviar los datos al template
        $viewData["items"] = $items;
        $viewData["total"] = number_format($total, 2);
        $viewData["hayItems"] = count($items) > 0;
        // ===================================================
        
        if ($this->isPostBack()) {
            $items = CarretillaDAO::getCarretillaByUser($usercod);

            if (empty($items)) {
                Site::redirectToWithMsg("index.php?page=Catalogo_Carretilla", "Su carretilla está vacía.");
                die();
            }

            foreach ($items as $item) {
                $productItem = ProductDAO::getProductById($item["productId"]);
                if (!$productItem || intval($productItem["productStock"]) < intval($item["crrctd"])) {
                    Site::redirectToWithMsg("index.php?page=Catalogo_Carretilla", "El producto no tiene stock suficiente.");
                    die();
                }
            }
            
            $PayPalOrder = new \Utilities\Paypal\PayPalOrder(
                "test" . (time() - 10000000),
                "http://localhost/mvc_project/index.php?page=Checkout_Error",
                "http://localhost/mvc_project/index.php?page=Checkout_Accept"
            );

            foreach ($items as $item) {
                $PayPalOrder->addItem(
                    $item["productName"],
                    $item["productDescription"],
                    $item["sku"] ?? "PRD" . $item["productId"],
                    floatval($item["crrprc"]),
                    0,
                    intval($item["crrctd"]),
                    "DIGITAL_GOODS"
                );
            }

            $PayPalRestApi = new \Utilities\PayPal\PayPalRestApi(
                \Utilities\Context::getContextByKey("PAYPAL_CLIENT_ID"),
                \Utilities\Context::getContextByKey("PAYPAL_CLIENT_SECRET")
            );
            $PayPalRestApi->getAccessToken();
            $response = $PayPalRestApi->createOrder($PayPalOrder);
            
            if ($response->id) {
                $_SESSION["orderid"] = $response->id;
                foreach ($response->links as $link) {
                    if ($link->rel == "approve") {
                        Site::redirectTo($link->href);
                        die();
                    }
                }
            }
        }

        \Views\Renderer::render("paypal/checkout", $viewData);
    }
}