<?php

namespace CMSTests\Repositories;

use CMS\Entities\ArticleCategory;
use CMS\Repositories\ArticleCategoryRepositoryInterface;

class InMemoryArticleCategoryRepository implements ArticleCategoryRepositoryInterface
{
    private $articleCategories;

    public function __construct()
    {
        $this->articleCategories = [];
    }

    public function findByID($articleCategoryID)
    {
        foreach ($this->articleCategories as $articleCategory) {
            if ($articleCategory->getID() == $articleCategoryID) {
                return $articleCategory;
            }
        }

        return false;
    }

    public function findAll($lang = null)
    {
        return $this->articleCategories;
    }

    public function createArticleCategory(ArticleCategory $articleCategory)
    {
        $this->articleCategories[]= $articleCategory;
    }

    public function updateArticleCategory(ArticleCategory $articleCategory)
    {
        foreach ($this->articleCategories as $articleCategoryModel) {
            if ($articleCategoryModel->getID() == $articleCategory->getID()) {
                $articleCategoryModel->setName($articleCategory->getName());
                $articleCategoryModel->setDescription($articleCategory->getDescription());
            }
        }
    }

    public function deleteArticleCategory($articleCategoryID)
    {
        foreach ($this->articleCategories as $i => $articleCategory) {
            if ($articleCategory->getID() == $articleCategoryID) {
                unset($this->articleCategories[$i]);
            }
        }
    }
}
