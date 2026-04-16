<?php

namespace Controllers\Mantenimientos\Products;

use Dao\Mantenimientos\Products as ProductsDAO;
use Controllers\PublicController;
use Views\Renderer;
use Utilities\Site;

const PRODUCTS_FORMULARIO_URL = "index.php?page=Mantenimientos-Products-Formulario";
const PRODUCTS_LISTADO_URL    = "index.php?page=Mantenimientos-Products-Listado";
const PRODUCTS_XSRF_KEY       = "Mantenimientos_Products_Formulario";

class Formulario extends PublicController
{
    private array $viewData = [];
    private array $modes = [
        "INS" => "Nuevo Producto",
        "UPD" => "Actualizar %s %s",
        "DSP" => "Detalle de %s %s",
        "DEL" => "Eliminando %s %s"
    ];
    private array $confirmTooltips = [
        "INS" => "",
        "UPD" => "",
        "DSP" => "",
        "DEL" => "¿Esta Seguro de Realizar la Eliminación? ¡¡Esto no se puede Revertir!!"
    ];

    private $productId;
    private $productName;
    private $productDescription;
    private $productPrice;
    private $productImgUrl;
    private $productStock;
    private $productStatus;

    private $xsrfToken = '';
    private $mode;

    public function run(): void
    {
        $this->LoadPage();
        if ($this->isPostBack()) {
            $this->CapturarDatos();
            if ($this->ValidarDatos()) {
                switch ($this->mode) {
                    case "INS":
                        if (ProductsDAO::crearProducto(
                            $this->productName,
                            $this->productDescription,
                            $this->productPrice,
                            $this->productImgUrl,
                            $this->productStock,
                            $this->productStatus
                        ) !== 0) {
                            Site::redirectToWithMsg(PRODUCTS_LISTADO_URL, "Producto creado satisfactoriamente");
                        };
                        break;
                    case "UPD":
                        if (ProductsDAO::actualizarProducto(
                            $this->productId,
                            $this->productName,
                            $this->productDescription,
                            $this->productPrice,
                            $this->productImgUrl,
                            $this->productStock,
                            $this->productStatus
                        ) !== 0) {
                            Site::redirectToWithMsg(PRODUCTS_LISTADO_URL, "Producto actualizado satisfactoriamente");
                        };
                        break;
                    case "DEL":
                        if (ProductsDAO::eliminarProducto(
                            $this->productId
                        ) !== 0) {
                            Site::redirectToWithMsg(PRODUCTS_LISTADO_URL, "Producto eliminado satisfactoriamente");
                        };
                        break;
                }
            }
        }
        $this->GenerarViewData();
        Renderer::render("mantenimientos/productos/formulario", $this->viewData);
    }

    private function LoadPage()
    {
        $this->mode = $_GET["mode"] ?? '';
        if (!isset($this->modes[$this->mode])) {
            Site::redirectToWithMsg(PRODUCTS_LISTADO_URL, "Error al cargar formulario, Intente de nuevo");
        }
        $this->productId = intval($_GET["id"] ?? '0');
        if ($this->mode !== "INS" && $this->productId <= 0) {
            Site::redirectToWithMsg(PRODUCTS_LISTADO_URL, "Error al cargar formulario, Se requiere Id del Producto");
        } else {
            if ($this->mode !== "INS") {
                $this->CargarDatos();
            }
        }
    }

    private function CargarDatos()
    {
        $tmpProduct = ProductsDAO::getProductById($this->productId);
        if (count($tmpProduct) <= 0) {
            Site::redirectToWithMsg(PRODUCTS_LISTADO_URL, "No se encontró el Producto");
        }
        $this->productId          = $tmpProduct["productId"];
        $this->productName        = $tmpProduct["productName"];
        $this->productDescription = $tmpProduct["productDescription"];
        $this->productPrice       = $tmpProduct["productPrice"];
        $this->productImgUrl      = $tmpProduct["productImgUrl"];
        $this->productStock       = $tmpProduct["productStock"];
        $this->productStatus      = $tmpProduct["productStatus"];
    }

    private function CapturarDatos()
    {
        $this->productId          = intval($_POST["productId"] ?? '0');
        $this->productName        = $_POST["productName"] ?? '';
        $this->productDescription = $_POST["productDescription"] ?? '';
        $this->productPrice       = $_POST["productPrice"] ?? '';
        $this->productImgUrl      = $_POST["productImgUrl"] ?? '';
        $this->productStock       = $_POST["productStock"] ?? '';
        $this->productStatus      = $_POST["productStatus"] ?? '';
        $this->xsrfToken          = $_POST["uuid"] ?? '';
    }

    private function ValidarDatos()
    {
        $sessionToken = $_SESSION[PRODUCTS_XSRF_KEY] ?? '';
        if ($this->xsrfToken !== $sessionToken) {
            Site::redirectToWithMsg(PRODUCTS_LISTADO_URL, "Error al cargar formulario, Inconsistencia en la Petición");
        }
        $validateId = intval($_GET["id"] ?? '0');
        if ($validateId !== $this->productId) {
            return false;
        }
        return true;
    }

    private function GenerarViewData()
    {
        $this->viewData["mode"]                   = $this->mode;
        $this->viewData["modeDsc"]                = sprintf($this->modes[$this->mode], $this->productId, $this->productName);
        $this->viewData["productId"]              = $this->productId;
        $this->viewData["productName"]            = $this->productName;
        $this->viewData["productDescription"]     = $this->productDescription;
        $this->viewData["productPrice"]           = $this->productPrice;
        $this->viewData["productImgUrl"]          = $this->productImgUrl;
        $this->viewData["productStock"]           = $this->productStock;
        $this->viewData["productStatus"]          = $this->productStatus;
        $this->viewData["isReadonly"]             = ($this->mode === 'DEL' || $this->mode === 'DSP') ? 'readonly' : '';
        $this->viewData["hideConfirm"]            = $this->mode === 'DSP';
        $this->viewData["confirmToolTip"]         = $this->confirmTooltips[$this->mode];
        $this->viewData["xsrf_token"]             = $this->GenerateXSRFToken();
    }

    private function GenerateXSRFToken()
    {
        $tmpStr = "products_formulario" . time() . rand(10000, 99999);
        $this->xsrfToken = md5($tmpStr);
        $_SESSION[PRODUCTS_XSRF_KEY] = $this->xsrfToken;
        return $this->xsrfToken;
    }
}