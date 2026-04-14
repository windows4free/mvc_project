<?php

namespace Controllers\Checkout;

use Controllers\PublicController;

class Checkout extends PublicController
{
    public function run(): void
    {
        $viewData = array();
        if ($this->isPostBack()) {
            $items = $_SESSION["cart"] ?? [];
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
                    $item["sku"],
                    $item["productPrice"],
                    $item["tax"],
                    $item["quantity"],
                    "DIGITAL_GOODS"
                );
            }

            $PayPalRestApi = new \Utilities\PayPal\PayPalRestApi(
                \Utilities\Context::getContextByKey("PAYPAL_CLIENT_ID"),
                \Utilities\Context::getContextByKey("PAYPAL_CLIENT_SECRET")
            );
            $PayPalRestApi->getAccessToken();
            $response = $PayPalRestApi->createOrder($PayPalOrder);

            $_SESSION["orderid"] = $response->id;
            foreach ($response->links as $link) {
                if ($link->rel == "approve") {
                    \Utilities\Site::redirectTo($link->href);
                } 
            }
            die();
        }

        \Views\Renderer::render("paypal/checkout", $viewData);
    }
}
