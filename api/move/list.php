<?php

require_once "../../src/bootstrap.php";

$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true);

$boardId = $data['boardId']
    ?? dieWithError("Board id missing");

$startListId = $data['startListId']
    ?? dieWithError("Start list id missing");

$startIndex = $data['startColumnIndex']
    ?? dieWithError("Start column index missing");

$endIndex = $data['endColumnIndex']
    ?? dieWithError("End column index missing");

$board = $entityManager->find('Taskboard', $boardId)
    ?? dieWithError("Board not found");

$startList = $entityManager->find('Tasklist', $startListId)
    ?? dieWithError("Start list not found");

if ($startList->getBoard()->getId() !== $board->getId()) {
    dieWithError("Start list doesn't belong to the start board");
}

$lists = $board->getLists();

// shift the rightwise lists

foreach ($lists as $k => $list) {
    $columnIndex = $list->getColumnIndex();

    if ($columnIndex > $startIndex) {
        $list->setColumnIndex($columnIndex - 1);
    } 
}

// shift the leftwise lists

foreach ($lists as $k => $list) {
    $columnIndex = $list->getColumnIndex();

    if ($columnIndex >= $endIndex) {
        $list->setColumnIndex($columnIndex + 1);
    }
}

// change the list columnIndex

$startList->setColumnIndex($endIndex);

// persist all those changes

$entityManager->persist($board);
$entityManager->flush();

// send confirmation

dieOk(array("moved" => true));

