<?php

declare(strict_types=1);

use App\Router;
    Router::get('/login', fn() => loadView('auth/login'));
    Router::get('/signup', fn() => loadView('auth/signup'));

    Router::post('/signup', fn() => (new \Controller\AuthConteroller())->signup());
    Router::post('/login', fn() => (new \Controller\AuthConteroller())->login());

    Router::get('/forget/password', fn() => (new \Controller\AuthConteroller())->forgotPassword());

    Router::get('/', fn() => (new \Controller\AdController())->index());

    Router::get('/branch', fn() => loadController('branch'));
    Router::get('/branch/create', fn() => loadView('dashboard/createBranch'));
    Router::post('/branch/create', fn() => loadController('createBranch'));

    Router::get('/status', fn() => loadController('showStatus'));
    Router::get('/status/create', fn() => loadView('dashboard/create-status'));
    Router::post('/status/create', fn() => loadController('createStatus'));

    Router::get('/dashboard', fn() => (new \Controller\AdController())->dashboard());

    Router::get('/ads/{id}', function (int $id) {
        (new \Controller\AdController())->show($id);
    });

    Router::get('/ads/create', fn() => loadView('dashboard/create-ad'));
    Router::post('/ads/create', fn() => (new Controller\AdController())->create());

    Router::get('/logout', fn()=> (new \Controller\AuthConteroller())->logout());

Router::errorResponse(404, 'Not Found');
