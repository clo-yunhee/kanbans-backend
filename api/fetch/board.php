<?php

require_once "../init.php";

$boardId = safeGet('_id');

$taskboard = safeFind('Taskboard', $boardId);

dieOk($taskboard);
