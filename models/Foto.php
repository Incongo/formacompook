<?php

class Foto
{
    private $fotos_id;
    private $titulo;
    private $ruta;
    private $descripcion;
    private $votos;

    public function __construct($fotos_id, $titulo, $ruta, $descripcion)
    {
        $this->fotos_id = $fotos_id;
        $this->titulo = $titulo;
        $this->ruta = $ruta;
        $this->descripcion = $descripcion;
        $this->votos = array();
    }

    public function getFoto_id()
    {
        return $this->fotos_id;
    }

    public function getTitulo()
    {
        return $this->titulo;
    }

    public function getRuta()
    {
        return $this->ruta;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }
}
