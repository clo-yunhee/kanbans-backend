<?php

require_once "../init.php";

$boardId = safeGet('_id');
$boardName = safeGet('boardName');

$taskboard = safeFind('Taskboard', $boardId);

$taskboard->setBoardName($boardName);

$entityManager->persist($taskboard);
$entityManager->flush();

dieOk($taskboard);

