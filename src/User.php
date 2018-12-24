<?php

use Doctrine\Common\Collections\ArrayCollection;

// not jsonserializable, because we want to be able
// to select which members we want to seralize per request

/**
 * @Entity @Table(name="users")
 **/
class User
{
    /**
     * @Id
     * @Column(type="guid")
     * @GeneratedValue(strategy="UUID")
     **/
    protected $id;

    /**
     * @Unique
     * @Column(type="string")
     **/
    protected $username;

    /** @Column(type="datetimetz", options={"default"="CURRENT_TIMESTAMP"}) **/
    protected $createdOn;

    /** @Column(type="datetimetz", nullable=TRUE) **/
    protected $lastSeen;

    /** @Column(type="string") **/
    protected $hash;

    /** @OneToMany(targetEntity="UserToken", mappedBy="user") **/
    protected $tokens;

    public function __construct($username) {
        $this->createdOn = new DateTime("now");
        $this->username = $username;
        $this->tokens = new ArrayCollection();
    }

    public function getId() {
        return $this->id;
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

    public function setHash($hash) {
        $this->hash = $hash;
    }

    public function getTokens() {
        return $this->tokens;
    }

}
