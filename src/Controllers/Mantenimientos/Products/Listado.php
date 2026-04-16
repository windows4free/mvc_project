<?php

namespace Controllers\Mantenimientos\Products;

use Controllers\PrivateController;
use Views\Renderer;
use Dao\Mantenimientos\Products as ProductsDAO;
use Controllers\PrivateNoAuthException;

const PRODUCTS_LIST_VIEW_TEMPLATE = "mantenimientos/productos/listado";

class Listado extends PrivateController
{
    private array $productsList = [];
    
    public function run(): void
    {
        // Verificar permiso para ver el listado
        if (!$this->isFeatureAutorized('Controllers\\Mantenimientos\\Products\\Listado')) {
            throw new PrivateNoAuthException();
        }
        
        $this->productsList = ProductsDAO::getAllProducts();
        Renderer::render(PRODUCTS_LIST_VIEW_TEMPLATE, $this->prepareViewData());
    }

    private function prepareViewData()
    {
        return [
            "products" => $this->productsList,
            "showNew" => $this->isFeatureAutorized('Controllers\\Mantenimientos\\Products\\Formulario'),
            "showUpdate" => $this->isFeatureAutorized('Controllers\\Mantenimientos\\Products\\Formulario'),
            "showDelete" => $this->isFeatureAutorized('Controllers\\Mantenimientos\\Products\\Formulario')
        ];
    }
}