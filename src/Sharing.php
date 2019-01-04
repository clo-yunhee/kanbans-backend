<?php

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity @Table(name="sharing")
 **/
class Sharing implements JsonSerializable {

    /** @Id
        @ManyToOne(targetEntity="Taskboard", inversedBy="shared")
        @JoinColumn(name="boardId", referencedColumnName="id") **/
    protected $board;

    /** @Id
        @ManyToOne(targetEntity="User")
        @JoinColumn(name="userId", referencedColumnName="id") **/
    protected $user;

    /** @Column(type="boolean") **/
    protected $canView;

    /** @Column(type="boolean") **/
    protected $canEdit;

    public function __construct($board, $user) {
        $this->board = $board;
        $this->user = $user;
    }
    
    public function getBoard() {
        return $board;
    }

    public function getUser() {
        return $user;
    }

    public function isCanView() {
        return $canView;
    }

    public function setCanView($canView) {
        $this->canView = $canView;
    }

    public function isCanEdit() {
        return $canEdit;
    }

    public function setCanEdit($canEdit) {
        $this->canEdit = $canEdit;
    }

    public function jsonSerialize() {
        return [
            "boardId" => $this->board->getId(),
            "permissions" => [
                "view" => $this->canView,
                "edit" => $this->canEdit,
            ],
        ];
    }

}
