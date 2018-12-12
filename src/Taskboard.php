<?php

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity @Table(name="taskboards")
 **/
class Taskboard implements JsonSerializable
{
    /**
     * @Id
     * @Column(type="guid")
     * @GeneratedValue(strategy="UUID")
     **/
    protected $id;

    /** @Column(type="datetimetz", options={"default"="CURRENT_TIMESTAMP"}) **/
    protected $createdOn;

    /** @Column(type="datetimetz", nullable=TRUE) **/
    protected $updatedOn;

    /** @Column(type="string") **/
    protected $boardName;

    /** @OneToMany(targetEntity="Tasklist", mappedBy="board") */
    protected $lists;

    public function __construct() {
        $this->createdOn = new DateTime("now");
        $this->lists = new ArrayCollection();
    }

    public function getId() {
        return $this->id;
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

    public function getBoardName() {
        return $this->boardName;
    }

    public function setBoardName($boardName) {
        $this->boardName = $boardName;
    }

    public function getLists() {
        return $this->lists;
    }

    public function jsonSerialize() {
        return [
            "_id" => $this->id,
            "createdOn" => $this->createdOn->getTimestamp(),
            "updatedOn" => $this->updatedOn->getTimestamp(),
            "boardName" => $this->boardName,
            "lists" => $this->lists->toArray(),
        ];
    }
}
