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

    /** @Column(type="integer", options={"default"=0}) **/
    protected $index;

    public function __construct() {
        $this->createdOn = new DateTime("now");
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

    public function getIndex() {
        return $this->index;
    }

    public function setIndex($index) {
        $this->index = $index;
    }

    public function jsonSerialize() {
        return [
            "_id" => $this->id,
            "listId" => $this->list->getId(),
            "boardId" => $this->list->getBoard()->getId(),
            "createdOn" => $this->createdOn->getTimestamp(),
            "updatedOn" => $this->updatedOn ? $this->updatedOn->getTimestamp() : null,
            "content" => $this->content,
            "index" => $this->index,
        ];
    }
}
