<?php

namespace Controllers\Checkout;

use Controllers\PublicController;
use Dao\Products\Products as ProductDAO;
use Utilities\Site as Site;
const URL_TEMPLATE = "index.php?page=Cart_ShoppingCart";

class Checkout extends PublicController
{
    public function run(): void
    {
        // unset($_SESSION["cart"]);
        // unset($_SESSION["orderid"]);
        $viewData = array();
        $usercod = \Utilities\Security::getUserId();
        if ($this->isPostBack()) {
            $items = \Dao\Catalogo\Carretilla::getCarretillaByUser($usercod);

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

            // $PayPalOrder->addItem("Test", "TestItem1", "PRD1", 100, 15, 1, "DIGITAL_GOODS");
            // $PayPalOrder->addItem("Test 2", "TestItem2", "PRD2", 50, 7.5, 2, "DIGITAL_GOODS");

            foreach ($items as $item) {
                $PayPalOrder->addItem(
                    $item["productName"],
                    $item["productDescription"],
                    $item["sku"] ?? "PRD" . $item["productId"],
                    floatval($item["crrprc"]),
                    0, //tax not working                       
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
