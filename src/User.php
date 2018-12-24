<?php

// not jsonserializable, because we want to be able
// to select which members we want to seralize per request

/**
 * @Entity @Table(name="users")
 **/
class User
{
    /**
     * @Id
     * @Column(type="string")
     **/
    protected $username;

    /** @Column(type="datetimetz", options={"default"="CURRENT_TIMESTAMP"}) **/
    protected $createdOn;

    /** @Column(type="datetimetz", nullable=TRUE) **/
    protected $lastSeen;

    /** @Column(type="string") **/
    protected $hash;

    public function __construct($username) {
        $this->createdOn = new DateTime("now");
        $this->username = $username;
    }

    function getUsername() {
        return $this->username;
    }

    public function getCreatedOn() {
        return $this->createdOn;
    }

    public function getLastSeen() {
        return $this->lastSeen;
    }

    public function setLastSeen() {
        $this->lastSeen = new DateTime("now");
    }

    public function getHash() {
        return $this->hash;
    }

}
