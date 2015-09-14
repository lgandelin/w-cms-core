<?php

namespace Webaccess\WCMSCore\Interactors\Articles;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\DataStructure;

class UpdateArticleInteractor extends GetArticleInteractor
{
    public function run($articleID, DataStructure $articleStructure)
    {
        if ($article = $this->getArticleByID($articleID)) {
            $article->setInfos($articleStructure);
            $article->valid();

            if ($this->anotherArticleExistsWithSameTitle($articleID, $article->getTitle())) {
                throw new \Exception('There is already a article with the same title');
            }

            Context::get('article_repository')->updateArticle($article);
        }
    }

    private function anotherArticleExistsWithSameTitle($articleID, $articleTitle)
    {
        $article = Context::get('article_repository')->findByTitle($articleTitle);

        return ($article && $article->getID() != $articleID);
    }
}
