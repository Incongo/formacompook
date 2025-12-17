<?php

class Usuario
{
    private $usuarios_id;
    private $nombre;
    private $email;
    private $password;
    private $avatar;

    public function __construct($usuario_id, $nombre, $email, $password, $avatar)
    {
        $this->usuarios_id = $usuario_id;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->password = $password;
        $this->avatar = $avatar;
    }

    public function getUsuario_id()
    {
        return $this->usuarios_id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }
}
