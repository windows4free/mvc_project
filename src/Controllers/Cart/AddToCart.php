<?php

namespace Controllers\Cart;

use Controllers\PublicController;
use Dao\Products\Products as ProductDao;
use Utilities\Site as Site;

const URL_TEMPLATE = "index.php?page=HomeController";

class AddToCart extends PublicController
{
    public function run(): void
    {
        if ($this->isPostBack()) {
            $productId = intval($_POST["productId"] ?? 0);
            $quantity = intval($_POST["quantity"] ?? 1);
            if ($productId > 0) {
                $product = ProductDao::getProductById($productId);
                if ($product["productStatus"] === "ACT") {
                    $currentQuantity = $_SESSION["cart"][$productId]["quantity"] ?? 0;
                    $requestedAmount = $currentQuantity + $quantity;
                    if (intval($product["productStock"]) < $requestedAmount) {
                        Site::redirectToWithMsg(URL_TEMPLATE,"El producto " . $product["productName"] . " no esta disponible este momento");
                        die();
                    }
                    if (!isset($_SESSION["cart"])) {
                        $_SESSION["cart"] = [];
                    }
                    if (isset($_SESSION["cart"][$productId])) {
                        $_SESSION["cart"][$productId]["quantity"] += $quantity;
                    } else {
                        $_SESSION["cart"][$productId] = [
                            "productName" => $product["productName"],
                            "productDescription" => $product["productDescription"],
                            "productImgUrl" => $product["productImgUrl"],
                            "sku" => "PRD-" . $product["productId"],
                            "productPrice" => floatval($product["productPrice"]),
                            "tax" => 0, // changing it later
                            "quantity" => $quantity
                        ];
                    }
                }
            }
            Site::redirectToWithMsg(URL_TEMPLATE, "Artículo añadido(s) al carrito");
            die();
        }
    }
}