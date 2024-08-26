<?php

declare(strict_types=1);

use App\Ads;

function dd($args)
{
    echo "<pre>";
    print_r($args);
    echo "</pre>";
    die();
}

function getAds(): false|array
{
    return (new Ads())->getAds();
}

function basePath(string $path): string
{
    return __DIR__.$path;
}

function loadView(string $path, array|null $args = null, bool $loadFromPublic = false)
{
    if($loadFromPublic)
    {
        $file = "public/pages/$path.php";
    }else{
        $file = "resources/views/pages/$path.php";
    }
    $filePath = basePath("/public/pages/$path.php");
    if (!file_exists($filePath)) {
        require $file;
    }
    if (is_array($args)) {
        extract($args);
    }
    require $filePath;
}

function loadPartials(string $path, array|null $args = null, bool $loadFromPublic = true): void
{
    if (is_array($args)) {
        extract($args);
    }
    if($loadFromPublic)
    {
        $file = "/public/partials/$path.php";
    }else{
        $file = "resources/views/pages/$path.php";
    }
    require basePath($file);
}

function loadController(string $path, array|null $args = null): void
{
    if (is_array($args)) {
        extract($args);
    }
    require basePath('/controllers/'.$path.'.php');
}

function redirect(string $url): void
{
    header('Location: '.$url);
    exit();
}