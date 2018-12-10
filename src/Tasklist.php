<?php

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity @Table(name="tasklists")
 **/
class Tasklist implements JsonSerializable
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     **/
    protected $id;

    /** @ManyToOne(targetEntity="Taskboard", inversedBy="lists")
        @JoinColumn(name="boardId", referencedColumnName="id") **/
    protected $board;

    /** @Column(type="datetime", options={"default"="CURRENT_TIMESTAMP"}) **/
    protected $createdOn;

    /** @Column(type="datetime", nullable=TRUE) **/
    protected $updatedOn;

    /** @Column(type="string") **/
    protected $listName;

    /** @OneToMany(targetEntity="Taskitem", mappedBy="list") */
    protected $items;

    public function __construct() {
        $this->createdOn = new DateTime("now");
        $this->items = new ArrayCollection();
    }

    public function getId() {
        return $this->id;
    }

    public function getBoard() {
        return $this->board;
    }

    public function setBoard($board) {
        $this->board = $board;
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

    public function getListName() {
        return $this->listName;
    }

    public function setListName($listName) {
        $this->listName = $listName;
    }

    public function getItems() {
        return $this->items;
    }

    public function jsonSerialize() {
        return [
            "_id" => $this->id,
            "boardId" => $this->board->getId(),
            "createdOn" => $this->createdOn,
            "updatedOn" => $this->updatedOn,
            "listName" => $this->listName,
            "items" => $this->items->toArray(),
        ];
    }
}
