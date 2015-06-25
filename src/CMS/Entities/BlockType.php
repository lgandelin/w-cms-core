<?php

namespace CMS\Entities;

class BlockType
{
    private $ID;
    private $code;
    private $name;
    private $content_view;
    private $front_view;
    private $order;

    public function setID($ID)
    {
        $this->ID = $ID;
    }

    public function getID()
    {
        return $this->ID;
    }

    public function setCode($code)
    {
        $this->code = $code;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setContentView($content_view)
    {
        $this->content_view = $content_view;
    }

    public function getContentView()
    {
        return $this->content_view;
    }

    public function setFrontView($front_view)
    {
        $this->front_view = $front_view;
    }

    public function getFrontView()
    {
        return $this->front_view;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setOrder($order)
    {
        $this->order = $order;
    }

    public function getOrder()
    {
        return $this->order;
    }
}