<?php

namespace Controllers\Cart;

use Controllers\PublicController;
use \Views\Renderer as Renderer;
use \Utilities\Site as Site;

const URL_TEMPLATE = "cart/cart";

class ShoppingCart extends PublicController
{
  public function run(): void
  {
    Site::addLink("public/css/shoppingCart.css");
    $viewData = [];
    $items = $_SESSION["cart"] ?? [];
    $total = 0;

    foreach ($items as $item) {
      $total += $item["productPrice"] * $item["quantity"];
    }

    $viewData["cartItems"] = $items;
    $viewData["cartTotal"] = number_format($total, 2);
    $viewData["isEmpty"] = empty($items);

    Renderer::render(URL_TEMPLATE, $viewData);
  }
}
