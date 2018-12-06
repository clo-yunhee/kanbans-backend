<?php

/**
 * @Entity @Table(name="items")
 **/
class Taskitem
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
    protected $content;

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

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
    }
}
