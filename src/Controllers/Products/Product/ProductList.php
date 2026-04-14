<?php

namespace Controllers\Products\Product;
use Controllers\PublicController;
use Views\Renderer;
use Dao\Products\Products as ProductsDAO;

const LIST_PROD_TEMPLATE = "products/product/productList";

class ProductList extends PublicController {
    
    private array $prodArray = [];
    public function run(): void{
        $this->prodArray = ProductsDAO::getAllProd();
        Renderer::render(LIST_PROD_TEMPLATE, $this->ProdDataView());
    }

    public function ProdDataView() {
        return [
            "products" => $this->prodArray
        ];
    }
}