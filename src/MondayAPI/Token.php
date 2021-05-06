<?php

namespace TBlack\MondayAPI;

class Token
{
    private $token = false;

    function __construct($token)
    {
        $this->token = $token;
    }

    public function getToken()
    {
        return $this->token;
    }
}


?>
