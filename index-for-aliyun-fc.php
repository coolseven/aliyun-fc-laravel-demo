<?php

use RingCentral\Psr7\Response;

function startsWith($haystack, $needle)
{
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}

function handler($request, $context): Response
{
    $uri = $request->getAttribute("requestURI");

    $isPhpScript = false;
    $root_dir    = __DIR__;
    $filename    = $root_dir . explode("?", $uri)[0];
    $filename    = rawurldecode($filename);

    $pathinfo = pathinfo($filename);
    if (!isset($pathinfo['extension'])) {
        $isPhpScript = true;
    } else {
        $extension = strtolower($pathinfo['extension']);
        if ($extension == 'php') {
            $isPhpScript = true;
        }
    }

    $proxy = $GLOBALS['fcPhpCgiProxy'];
    //php script
    if ($isPhpScript) {
//        $host   = "rayzhang.mofangdegisn.cn";
        $resp = $proxy->requestPhpCgi($request, $root_dir, "index.php",
            [
//                'SERVER_NAME' => $host,
'SERVER_PORT'     => '80',
//                'HTTP_HOST' => $host,
'SCRIPT_FILENAME' => $root_dir . "/public/index.php",
// 'REQUEST_URI'     => 
'SCRIPT_NAME'     => "/index.php",
            ],
            [
                'debug_show_cgi_params' => true,
                'readWriteTimeout'      => 20000,
            ]
        );
        return $resp;
    } else {
        // static files, js, css, jpg ...
        $handle   = fopen($filename, "r");
        $contents = fread($handle, filesize($filename));
        fclose($handle);
        $headers = [
            'Content-Type'  => $proxy->getMimeType($filename),
            'Cache-Control' => "max-age=8640000",
            'Accept-Ranges' => 'bytes',
        ];
        return new Response(200, $headers, $contents);
    }
}
