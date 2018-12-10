<?php

/**
 * @Entity @Table(name="boards")
 **/
class Taskboard implements JsonSerializable
{
    /**
     * @Id
     * @Column(type="guid")
     * @GeneratedValue(strategy="UUID")
     **/
    protected $id;

    /** @Column(type="datetime", options={"default"="CURRENT_TIMESTAMP"}) **/
    protected $createdOn;

    /** @Column(type="datetime", nullable=TRUE) **/
    protected $updatedOn;

    /** @Column(type="string") **/
    protected $boardName;

    public function __construct() {
        $this->createdOn = new DateTime("now");
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

    public function jsonSerialize() {
        return [
            "_id" => $this->id,
            "createdOn" => $this->createdOn,
            "updatedOn" => $this->updatedOn,
            "boardName" => $this->boardName,
        ];
    }
}
