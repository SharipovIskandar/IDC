<?php

declare(strict_types=1);

$statuses        = (new \App\Status())->getStatuses();

loadView('dashboard/statuses', ['statuses' => $statuses]);
