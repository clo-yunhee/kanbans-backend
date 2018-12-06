<?php

/**
 * @Entity @Table(name="boards")
 **/
class Taskboard
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;

    /** @Column(type="string") **/
    protected $boardName;

    public function getId() {
        return $this->id;
    }

    public function getBoardName() {
        return $this->boardName;
    }

    public function setBoardName($name) {
        $this->boardName = $name;
    }
}
