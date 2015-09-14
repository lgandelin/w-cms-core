<?php

namespace Webaccess\WCMSCore\Entities;

class BlockType extends Entity
{
    private $ID;
    private $code;
    private $name;
    private $back_controller;
    private $back_view;
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

    public function setBackController($back_controller)
    {
        $this->back_controller = $back_controller;
    }

    public function getBackController()
    {
        return $this->back_controller;
    }

    public function setBackView($back_view)
    {
        $this->back_view = $back_view;
    }

    public function getBackView()
    {
        return $this->back_view;
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