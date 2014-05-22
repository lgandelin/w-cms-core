<?php

namespace CMS\Mappers;

interface PageMapperInterface {

    public function findBySlug($slug);
}