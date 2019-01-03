<?php

require_once "../init.php";

$startItemId = safeGet('startItemId');
$startListId = safeGet('startListId');
$startIndex = safeGet('startListIndex');
$endListId = safeGet('endListId'):
$endIndex = safeGet('endListIndex');

$startItem = safeFind('Taskitem', $startItemId);

if ($startItem->getListIndex() !== $startIndex) {
    dieWithError("Start item index mismatch");
}

$startList = safeFind('Tasklist', $startListId);

if ($startItem->getList()->getId() !== $startList->getId()) {
    dieWithError("Start parent list mismatch");
}

$endList = safeFind('Tasklist', $endListId);

if ($startList->getBoard()->getId() !== $endList->getBoard()->getId()) {
    dieWithError("Parent board mismatch");
}

$startItems = $startList->getItems();
$endItems = $endList->getItems();

// remove the item and shift the rightwise items from the start list

foreach ($startItems as $k => $item) {
    $listIndex = $item->getListIndex();

    if ($listIndex > $startIndex) {
        $item->setListIndex($listIndex - 1);
    } 
}

$startItems->removeElement($startItem);

// shift the leftwise items from the end list

foreach ($endItems as $k => $item) {
    $listIndex = $item->getListIndex();

    if ($listIndex >= $endIndex) {
        $item->setListIndex($listIndex + 1);
    }
}

// add the item to end list

$startItem->setList($endList);
$startItem->setListIndex($endIndex);

$endItems->add($startItem);

// persist all those changes

$entityManager->persist($startList);
$entityManager->persist($endList);
$entityManager->flush();

// send confirmation

dieOk(array("moved" => true));

