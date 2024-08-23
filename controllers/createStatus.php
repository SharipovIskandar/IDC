<?php

declare(strict_types=1);

use App\Status;

if ($_POST['status']) {
    $status = (new Status())->createStatus($_POST['status']);

    if ($status) {
        header('Location: /status');
        exit();
    }
}