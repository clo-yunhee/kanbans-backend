<?php

/**
 * @Entity @Table(name="taskitems")
 **/
class Taskitem implements JsonSerializable
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     **/
    protected $id;

    /**
     * @ManyToOne(targetEntity="Tasklist", inversedBy="items")
     **/
    protected $list;

    /** @Column(type="datetimetz", options={"default"="CURRENT_TIMESTAMP"}) **/
    protected $createdOn;

    /** @Column(type="datetimetz", nullable=TRUE) **/
    protected $updatedOn;

    /** @Column(type="string") **/
    protected $content;

    /** @Column(type="integer") **/ 
    protected $listIndex;

    public function __construct($lastIndex) {
        $this->createdOn = new DateTime("now");
        $this->listIndex = $lastIndex;
    }

    public function getId() {
        return $this->id;
    }

    public function getList() {
        return $this->list;
    }

    public function setList($list) {
        $this->list = $list;
    }

    public function getCreatedOn() {
        return $this->createdOn;
    }

    public function getUpdatedOn() {
        return $this->updatedOn;
    }

    public function setUpdatedOn() {
        $this->updatedOn = new DateTime("now");
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function getListIndex() {
        return $this->listIndex;
    }

    public function setListIndex($listIndex) {
        $this->listIndex = $listIndex;
    }

    public function jsonSerialize() {
        return [
            "_id" => $this->id,
            "listId" => $this->list->getId(),
            "boardId" => $this->list->getBoard()->getId(),
            "createdOn" => $this->createdOn->getTimestamp(),
            "updatedOn" => $this->updatedOn ? $this->updatedOn->getTimestamp() : null,
            "content" => $this->content,
            "listIndex" => $this->listIndex,
        ];
    }
}
