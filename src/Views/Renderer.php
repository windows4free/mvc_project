<?php

namespace Views;

use Utilities\Context;

class Renderer
{
    public static function render(
        $vista,
        $datos = [],
        $layoutFile = "layout.view.tpl",
        $render = true
    ) {
        if (!is_array($datos)) {
            throw new \Exception("Renderer error: datos no es array");
        }

        $global_context = Context::getContext();

        if (is_array($global_context)) {
            $datos = array_merge($global_context, $datos);
        }

        if (isset($_SESSION)) {
            $datos["_SESSION"] = $_SESSION;
        }

        if (!str_contains($layoutFile, ".view.tpl")) {
            $layoutFile .= ".view.tpl";
        }

        $viewsPath = "src/Views/templates/";
        $fileTemplate = $vista . ".view.tpl";

        $layoutPath = $viewsPath . $layoutFile;
        $viewPath = $viewsPath . $fileTemplate;

        if (!file_exists($layoutPath)) {
            throw new \Exception("Layout no encontrado: $layoutFile");
        }

        if (!file_exists($viewPath)) {
            throw new \Exception("Vista no encontrada: $vista");
        }

        $layout = file_get_contents($layoutPath);
        $view = file_get_contents($viewPath);

        $html = str_replace("{{{page_content}}}", $view, $layout);

        $html = self::loadPartials($html);

        $template_code = self::_parseTemplate($html);

        $htmlResult = self::_renderTemplate($template_code, $datos);

        if ($render) {
            if (($datos["USE_URLREWRITE"] ?? "0") == "1") {
                echo self::rewriteUrl($htmlResult);
            } else {
                echo $htmlResult;
            }
        } else {
            return $htmlResult;
        }
    }

    private static function _renderTemplate($template_block, $context, $parent = null, $root = null)
    {
        $html = "";

        $parent ??= $context;
        $root ??= $context;

        foreach ($template_block as $node) {

            if (str_contains($node, "{{")) {

                $parts = preg_split(
                    "/(\{\{[&,~]?\w*\}\})/",
                    $node,
                    -1,
                    PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY
                );

                foreach ($parts as $part) {
                    if (str_starts_with($part, "{{")) {
                        $key = trim($part, "{} ");

                        if (str_starts_with($key, "~")) {
                            $key = str_replace("~", "", $key);
                            $html .= $root[$key] ?? "";
                        } elseif (str_starts_with($key, "&")) {
                            $key = str_replace("&", "", $key);
                            $html .= $parent[$key] ?? "";
                        } else {
                            $html .= $context[$key] ?? "";
                        }
                    } else {
                        $html .= $part;
                    }
                }

            } else {
                $html .= $node;
            }
        }

        return $html;
    }

    private static function _parseTemplate($htmlTemplate)
    {
        $regexp_array = [
            'foreach'     => '(\{\{foreach [~&]?\w*\}\})',
            'endfor'      => '(\{\{endfor [~&]?\w*\}\})',
            'if'          => '(\{\{if [~&]?\w*\}\})',
            'if_not'      => '(\{\{ifnot [~&]?\w*\}\})',
            'if_close'    => '(\{\{endif [~&]?\w*\}\})',
            'ifnot_close' => '(\{\{endifnot [~&]?\w*\}\})',
            'with'        => '(\{\{with [~&]?\w*\}\})',
            'with_close'  => '(\{\{endwith [~&]?\w*\}\})'
        ];

        $tag_regexp = "/" . join("|", $regexp_array) . "/";

        return preg_split(
            $tag_regexp,
            $htmlTemplate,
            -1,
            PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY
        );
    }

    private static function loadPartials($htmlTemplate)
    {
        $viewsPath = "src/Views/templates/";

        return preg_replace_callback(
            '/\{\{include ([\w\/]+)\}\}/',
            function ($matches) use ($viewsPath) {

                $file = $viewsPath . $matches[1] . ".view.tpl";

                if (file_exists($file)) {
                    return file_get_contents($file);
                }

                return "<!-- include no encontrado: {$matches[1]} -->";
            },
            $htmlTemplate
        );
    }

    public static function rewriteUrl($html)
    {
        $basedir = Context::getContextByKey("BASE_DIR");

        return preg_replace_callback(
            '/index\.php\?page=([\w\.\-]+)([^\s"\']*)/',
            function ($matches) use ($basedir) {

                $page = str_replace(["_", ".", "-"], "/", $matches[1]);
                $query = $matches[2] ?? "";

                $url = $basedir . "/" . $page;

                if (!empty($query)) {
                    $url .= "/?" . ltrim($query, "&");
                }

                return $url;
            },
            $html
        );
    }

    private function __construct() {}
}