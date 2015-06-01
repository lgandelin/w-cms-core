<?php

namespace CMS\Interactors\Articles;

use CMS\Context;
use CMS\Structures\ArticleStructure;

class UpdateArticleInteractor extends GetArticleInteractor
{
    public function run($articleID, ArticleStructure $articleStructure)
    {
        if ($article = $this->getArticleByID($articleID)) {
            $properties = get_object_vars($articleStructure);
            unset ($properties['ID']);
            foreach ($properties as $property => $value) {
                $method = ucfirst(str_replace('_', '', $property));
                $setter = 'set' . $method;

                if ($articleStructure->$property !== null) {
                    call_user_func_array(array($article, $setter), array($value));
                }
            }

            $article->valid();

            if ($this->anotherArticleExistsWithSameTitle($articleID, $article->getTitle())) {
                throw new \Exception('There is already a article with the same title');
            }

            Context::$articleRepository->updateArticle($article);
        }
    }

    private function anotherArticleExistsWithSameTitle($articleID, $articleTitle)
    {
        $article = Context::$articleRepository->findByTitle($articleTitle);

        return ($article && $article->getID() != $articleID);
    }
}
