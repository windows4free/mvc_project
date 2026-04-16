<?php

namespace Controllers\Catalogo;

use Controllers\PublicController;
use Dao\Catalogo\Productos;
use Views\Renderer;
use utilities\Site as Site;

class Catalogo extends PublicController
{
    public function run(): void
    {
        Site::addLink("public/css/mirnas.css");
        //Site::addLink("public/css/mirnas.css?v=" . time());

        $viewData = array();

        $categoria = $_GET["categoria"] ?? "ALL";
        $viewData["categoriaActiva"] = $categoria;

        if ($categoria === "ALL") {
            $productos = Productos::getAllProductosActivos();
        } else {
            $productos = Productos::getProductosByCategoria($categoria);
        }

        $categoriasLabels = [
            "GEN" => "Exclusividades",
            "BBY" => "Baby &amp; Kids",
            "HOG" => "Hogar"
        ];

        // Enriquecer cada producto con datos para las plantillas
        foreach ($productos as &$prod) {
            $cat = $prod["productCategory"] ?? "GEN";
            $prod["categoriaLabel"] = $categoriasLabels[$cat] ?? "General";
            $prod["sinStock"]       = ((int)$prod["productStock"]) <= 0;
        }
        unset($prod);

        $viewData["productos"]  = $productos;
        $viewData["categorias"] = [
            ["key" => "ALL", "value" => "Todos",             "active" => $categoria === "ALL"],
            ["key" => "GEN", "value" => "Exclusividades",    "active" => $categoria === "GEN"],
            ["key" => "BBY", "value" => "Baby &amp; Kids",   "active" => $categoria === "BBY"],
            ["key" => "HOG", "value" => "Hogar",             "active" => $categoria === "HOG"],
        ];

        Renderer::render("catalogo/catalogo", $viewData);
    }
}
