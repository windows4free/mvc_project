<?php

namespace Controllers\Mantenimientos\Products;

use Controllers\PublicController;
use Views\Renderer;
use Dao\Mantenimientos\Products as ProductsDAO;

const PRODUCTS_LIST_VIEW_TEMPLATE = "mantenimientos/productos/listado";

class Listado extends PublicController
{
    private array $productsList = [];

    public function run(): void
    {
        $this->productsList = ProductsDAO::getAllProducts();
        Renderer::render(PRODUCTS_LIST_VIEW_TEMPLATE, $this->prepareViewData());
    }

    private function prepareViewData()
    {
        return [
            "products" => $this->productsList
        ];
    }
}



