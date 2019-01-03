<?php

require_once "../init.php";

$boardId = safeGet('boardId');
$listName = safeGet('listName');
$columnIndex = safeGet('columnIndex');

$parentBoard = safeFind('Taskboard', $boardId);

$tasklist = new Tasklist();
$tasklist->setBoard($parentBoard);
$tasklist->setListName($listName);
$tasklist->setColumnIndex($columnIndex);

$entityManager->persist($tasklist);
$entityManager->flush();

dieOk($tasklist->getBoard()
               ->getLists()
               ->toArray());



