<?php

namespace CMS\Entities\Blocks;

use CMS\Entities\Block;
use CMS\Interactors\Articles\GetArticlesInteractor;
use CMS\Interactors\Medias\GetMediaInteractor;
use CMS\Interactors\Pages\GetPageInteractor;
use CMS\Structures\DataStructure;

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

    public function getContentData()
    {
        $content = new \StdClass();
        $content->articles = (new GetArticlesInteractor())->getAll($this->article_list_category_id, $this->article_list_number, $this->article_list_order, null, true);

        foreach ($content->articles as $article) {
            if ($article->page_id)
                $article->page = (new GetPageInteractor())->getPageByID($article->page_id, true);

            if ($article->media_id)
                $article->media = (new GetMediaInteractor())->getMediaByID($article->media_id, true);
        }

        return $content;
    }
}
