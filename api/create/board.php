<?php

require_once "../init.php";

$boardName = safeGet('boardName');

$taskboard = new Taskboard();
$taskboard->setBoardName($boardName);

$entityManager->persist($taskboard);
$entityManager->flush();

dieOk($taskboard);



