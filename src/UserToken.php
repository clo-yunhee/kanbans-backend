<?php

require_once 'password.php';

/**
 * @Entity @Table(name="usertokens") **/
class UserToken
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     **/
    protected $id;

    /** @Column(type="string", unique=TRUE) **/
    protected $token;

    /** @ManyToOne(targetEntity="User", inversedBy="tokens")
        @JoinColumn(name="userId", referencedColumnName="id") **/
    protected $user;

    public function getId() {
        return $this->id;
    }

    public function getToken() {
        return $this->token;
    }

    public function getUser() {
        return $this->user;
    }

    public static function generate($user) {
        $ut = new self;
        $ut->user = $user;
        $ut->token = generateToken();
        return $ut;
    }
}
