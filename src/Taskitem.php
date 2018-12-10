<?php

/**
 * @Entity @Table(name="items")
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
     * @ManyToOne(targetEntity="Tasklist")
     **/
    protected $list;

    /** @Column(type="datetime", options={"default"="CURRENT_TIMESTAMP"}) **/
    protected $createdOn;

    /** @Column(type="datetime", nullable=TRUE) **/
    protected $updatedOn;

    /** @Column(type="string") **/
    protected $content;

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

    public function jsonSerialize() {
        return [
            "_id" => $this->id,
            "listId" => $this->list->id,
            "boardId" => $this->list->board->id,
            "createdOn" => $this->createdOn,
            "updatedOn" => $this->updatedOn,
            "content" => $this->content,
        ];
    }
}
