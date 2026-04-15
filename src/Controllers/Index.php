<?php

namespace Controllers;

use Views\Renderer;

class Index extends PublicController
{
    public function run(): void
    {
        $viewData = array();
        Renderer::render("index", $viewData);
    }
}

