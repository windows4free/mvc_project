<?php

namespace Controllers\Cart;

use Controllers\PublicController;
use Dao\Products\Products as ProductDao;

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
                            "tax" => .15, // changing it later
                            "quantity" => $quantity
                        ];
                    }
                }
            }
            \Utilities\Site::redirectToWithMsg(URL_TEMPLATE,"Artículo(s) añadido(s) al carrito");
            die();
        }
    }
}