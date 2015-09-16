<?php

namespace Webaccess\WCMSCore\Entities\Blocks;

use Webaccess\WCMSCore\Entities\Block;
use Webaccess\WCMSCore\Interactors\Articles\GetArticlesInteractor;
use Webaccess\WCMSCore\Interactors\Medias\GetMediaInteractor;
use Webaccess\WCMSCore\Interactors\Pages\GetPageInteractor;

class ArticleListBlock extends Block
{
    private $article_list_category_id;
    private $article_list_order;
    private $article_list_number;

    public function setArticleListCategoryID($article_list_category_id)
    {
        $this->article_list_category_id = $article_list_category_id;
    }

    public function getArticleListCategoryID()
    {
        return $this->article_list_category_id;
    }

    public function setArticleListNumber($article_list_number)
    {
        $this->article_list_number = $article_list_number;
    }

    public function getArticleListNumber()
    {
        return $this->article_list_number;
    }

    public function setArticleListOrder($article_list_order)
    {
        $this->article_list_order = $article_list_order;
    }

    public function getArticleListOrder()
    {
        return $this->article_list_order;
    }
}
