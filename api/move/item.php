<?php

require_once "../../src/bootstrap.php";

$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true);

$startItemId = $data['startItemId']
    ?? dieWithError("Start item id missing");

$startListId = $data['startListId']
    ?? dieWithError("Start list id missing");

$startIndex = $data['startListIndex']
    ?? dieWithError("Start list index missing");

$endListId = $data['endListId']
    ?? dieWithError("End list id missing");

$endIndex = $data['endListIndex']
    ?? dieWithError("End list index missing");

$startItem = $entityManager->find('Taskitem', $startItemId)
    ?? dieWithError("Start item not found");

if ($startItem->getListIndex() !== $startIndex) {
    dieWithError("Start item index mismatch");
}

$startList = $entityManager->find('Tasklist', $startListId)
    ?? dieWithError("Start list not found");

if ($startItem->getList()->getId() !== $startList->getId()) {
    dieWithError("Start item doesn't belong to the start list");
}

$endList = $entityManager->find('Tasklist', $endListId)
    ?? dieWithError("End list not found");

if ($startList->getBoard()->getId() !== $endList->getBoard()->getId()) {
    dieWithError("Start and end lists don't belong to the same board");
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

