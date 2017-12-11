<?php


class Session
{

    protected $signedIn = false;
    protected $userId;
    protected $message;

    /**
     * Session constructor.
     */
    public function __construct()
    {
        session_start();
        $this->checkLogin();
        $this->checkMessage();
    }

    private function checkLogin()
    {
        if (isset($_SESSION['userId'])) {
            $this->userId = $_SESSION['userId'];
            $this->signedIn = true;
        } else {
            unset($this->userId);
            $this->signedIn = false;
        }
    }

    public function login($user)
    {
        if ($user) {
            $this->userId = $_SESSION['userId'] = $user->getId();
            $this->signedIn = true;
        }
    }

    public function logout()
    {
        unset($_SESSION['userId']);
        unset($this->userId);
        $this->signedIn = false;
    }

    public function message($msg = "")
    {
        if ( ! empty($msg)) {
            $_SESSION['message'] = $msg;
        } else {
            return $this->message;
        }
    }

    public function checkMessage()
    {
        if (isset($_SESSION['message'])) {
            $this->message = $_SESSION['message'];
            unset($_SESSION['message']);
        } else {
            $this->message = "";
        }
    }

    //region Getters

    /**
     * @return bool
     */
    public function isSignedIn()
    {
        return $this->signedIn;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    public function getMessage()
    {
        return $this->message;
    }
    //endregion
}

$session = new Session();