<?php

namespace SimplePayment\User\DTO;

class UserDTO
{
    public string $name;
    public string $email;
    public string $document;
    public string $type;
    public string $password;

    public function __construct(string $name, string $email, string $document, string $type, string $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->document = $document;
        $this->type = $type;
        $this->password = $password;
    }
}
