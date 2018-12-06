<?php

/**
 * @Entity @Table(name="lists")
 **/
class Tasklist
{
    /**
     * @Id
     * @Column(type="int")
     * @GeneratedValue
     **/
    protected $id;

    /** @Column(type="datetime") **/
    protected $createdOn;

    /** @Column(type="datetime") **/
    protected $updatedOn;

    /** @Column(type="string") **/
    protected $listName;

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

    public function getListName() {
        return $this->listName;
    }

    public function setListName($listName) {
        $this->listName = $listName;
    }
}
