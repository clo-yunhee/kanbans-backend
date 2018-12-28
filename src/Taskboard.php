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

    /** @ManyToOne(targetEntity="User", inversedBy="ownedBoards")
        @JoinColumn(name="userId", referencedColumnName="id") **/
    protected $owner;

    /** @OneToMany(targetEntity="Sharing", mappedBy="board") **/
    protected $sharedWith;

    /* marker for update */
    private $changed;

    public function __construct() {
        $this->createdOn = new DateTime("now");
        $this->lists = new ArrayCollection();
        $this->changed = false;
        $this->sharedWith = new ArrayCollection();
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
        $this->changed = true;
    }

    public function getBoardName() {
        return $this->boardName;
    }

    public function setBoardName($boardName) {
        $this->boardName = $boardName;
        $this->setUpdatedOn();
    }

    public function getLists() {
        return $this->lists;
    }
    
    public function getOwner() {
        return $this->owner;
    }

    public function setOwner($owner) {
        $this->owner = $owner;
        $this->setUpdatedOn();
    }

    public function getSharedWith() {
        return $this->sharedWith;
    }

    public function hasChanged() {
        return $this->changed;
    }

    public function jsonSerialize() {
        return [
            "_id" => $this->id,
            "createdOn" => $this->createdOn->getTimestamp(),
            "updatedOn" => $this->updatedOn ? $this->updatedOn->getTimestamp() : null,
            "boardName" => $this->boardName,
            "lists" => $this->lists->toArray(),
            "owner" => $this->owner->getUsername(),
        ];
    }
}
