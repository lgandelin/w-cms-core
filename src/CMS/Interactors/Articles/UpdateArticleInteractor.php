<?php

namespace CMS\Interactors\Articles;

use CMS\Structures\ArticleStructure;

class UpdateArticleInteractor extends GetArticleInteractor
{
    public function run($articleID, ArticleStructure $articleStructure)
    {
        if ($article = $this->getArticleByID($articleID)) {
            if (isset($articleStructure->title) && $articleStructure->title !== null && $article->getTitle() != $articleStructure->title) {
                $article->setTitle($articleStructure->title);
            }
            if (isset($articleStructure->summary) && $articleStructure->summary !== null && $article->getSummary() != $articleStructure->summary) {
                $article->setSummary($articleStructure->summary);
            }
            if (isset($articleStructure->text) && $articleStructure->text !== null && $article->getText() != $articleStructure->text) {
                $article->setText($articleStructure->text);
            }
            if (isset($articleStructure->category_id) && $articleStructure->category_id !== null && $article->getCategoryID() != $articleStructure->category_id) {
                $article->setCategoryID($articleStructure->category_id);
            }
            if (isset($articleStructure->author_id) && $articleStructure->author_id !== null && $article->getAuthorID() != $articleStructure->author_id) {
                $article->setAuthorID($articleStructure->author_id);
            }
            if ($article->getPageID() != $articleStructure->page_id) {
                $article->setPageID($articleStructure->page_id);
            }
            if (isset($articleStructure->publication_date) && $articleStructure->publication_date !== null && $article->getPublicationDate() != $articleStructure->publication_date) {
                $article->setPublicationDate($articleStructure->publication_date);
            }

            $article->valid();

            if ($this->anotherArticleExistsWithSameTitle($articleID, $article->getTitle())) {
                throw new \Exception('There is already a article with the same title');
            }

            $this->repository->updateArticle($article);
        }
    }

    private function anotherArticleExistsWithSameTitle($articleID, $articleTitle)
    {
        $article = $this->repository->findByTitle($articleTitle);

        return ($article && $article->getID() != $articleID);
    }
}
