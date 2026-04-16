<?php

namespace Controllers;

use Views\Renderer;
use Utilities\Site as Site;

class Index extends PublicController
{
    public function run(): void
    {
        Site::addLink("public/css/mirnas.css");
        $viewData = array();
        Renderer::render("index", $viewData);
    }
}

