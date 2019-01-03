<?php

require_once "../init.php";

$boardId = safeGet('boardId');
$startListId = safeGet('startListId');
$startIndex = safeGet('startColumnIndex');
$endIndex = safeGet('endColumnIndex');

$board = safeFind('Taskboard', $boardId);

$startList = safeFind('Tasklist', $startListId);

if ($startList->getBoard()->getId() !== $board->getId()) {
    dieWithError("Parent board mismatch");
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

