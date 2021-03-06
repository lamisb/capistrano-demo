<?php

use Koine\AssetDownloader\AssetDownloader;
use Zend\Diactoros\Uri;

$extensions = [
    'gif',
    'jpeg',
    'jpg',
    'png',
];

$requestUri = $_SERVER['REQUEST_URI'];
$extensions = implode('|', $extensions);
$regexp = "/($extensions)$/i";

if (!preg_match($regexp, $requestUri)) {
    return;
}

try  {
    $uri = new Uri($requestUri);

    $publicDir = realpath(dirname(__FILE__) . '/../public/');

    $downloader = new AssetDownloader();
    $downloader->from('https://assetsnffrgf-a.akamaihd.net')
        ->to($publicDir);

    $downloader->download($uri);

    // slow on purpose
    sleep(5);
    header("location: $requestUri");
    exit();
} catch (League\Flysystem\FileExistsException $e) {
}

return false;
