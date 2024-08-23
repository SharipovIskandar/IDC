<?php

use App\Branch;

$branch = new Branch();
if($_POST['branchName'] && $_POST['branchAddress']) {
    $branchName = $_POST['branchName'];
    $branchAddress = $_POST['branchAddress'];

    $stmt = $branch->createBranch($branchName, $branchAddress);
    header('Location: /branch');
}