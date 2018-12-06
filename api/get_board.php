<?php

require_once "../src/bootstrap.php";

$board_id = $_GET['board_id'];

$taskboard = $entityManager->find('Taskboard', $board_id);

if ($taskboard == null) {
    // no board found
    echo "{}";
    exit(1);
}

echo json_encode($taskboard);
