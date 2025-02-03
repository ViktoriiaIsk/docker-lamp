<?php
class User
{
    //properties
    public $id;
    public $mail;
    public $username;
    private $password;
    public $avatar;

    public function __construct(String $username, String $mail, String $avatar = 'default.png')
    {
        $this->mail = $mail;
        $this->username = $username;
        $this->avatar = $avatar;
    }


    public function getId()
    {
        return $this->id;
    }

    public function setId($i)
    {
        $this->id = $i;
    }

    public function getUserName()
    {
        return $this->username;
    }

    public function setUserName($username)
    {
        $this->username = $username;
    }


    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    //functies van dit object, maar we noemen deze method_exists

    public function login() {}

    public function printName()
    {
        return ucwords($this->username);
    }

    public function logout() {}
}
