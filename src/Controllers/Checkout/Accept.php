<?php

namespace Controllers\Checkout;

use Controllers\PublicController;
use Dao\Products\Products as ProductDAO;

class Accept extends PublicController
{
    public function run(): void
    {
        $dataview = array();
        $token = $_GET["token"] ?: "";
        $session_token = $_SESSION["orderid"] ?: "";
        if ($token !== "" && $token == $session_token) {
            $PayPalRestApi = new \Utilities\PayPal\PayPalRestApi(
                \Utilities\Context::getContextByKey("PAYPAL_CLIENT_ID"),
                \Utilities\Context::getContextByKey("PAYPAL_CLIENT_SECRET")
            );
            $result = $PayPalRestApi->captureOrder($session_token);
            $dataview["orderjson"] = json_encode($result, JSON_PRETTY_PRINT);

            $items = $_SESSION["cart"] ?? [];
            foreach ($items as $productId => $item) {
                ProductDAO::substractInventory($productId, $item["cantidad"]);
            }
            unset($_SESSION["cart"]);
            unset($_SESSION["orderid"]);


        } else {
            $dataview["orderjson"] = "No Order Available!!!";
        }
        \Views\Renderer::render("paypal/accept", $dataview);
    }
}
