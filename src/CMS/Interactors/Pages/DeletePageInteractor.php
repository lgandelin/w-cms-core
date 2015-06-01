<?php

namespace CMS\Interactors\Pages;

use CMS\Context;
use CMS\Interactors\Areas\DeleteAreaInteractor;
use CMS\Interactors\Areas\GetAreasInteractor;
use CMS\Interactors\Articles\GetArticlesInteractor;
use CMS\Interactors\Articles\UpdateArticleInteractor;
use CMS\Structures\ArticleStructure;

class DeletePageInteractor extends GetPageInteractor
{
    public function run($pageID)
    {
        if ($this->getPageByID($pageID)) {

            //If there are associated articles to this page, delete the reference
            $articles = (new GetArticlesInteractor())->getByAssociatedPageID($pageID);

            if (is_array($articles) && sizeof($articles) > 0) {
                foreach ($articles as $article) {
                    $articleStructure = new ArticleStructure([
                        'page_id' => null
                    ]);

                    (new UpdateArticleInteractor())->run($article->getID(), $articleStructure);
                }
            }

            $areas = (new GetAreasInteractor())->getAll($pageID);

            foreach ($areas as $area) {
                (new DeleteAreaInteractor())->run($area->getID());
            }

            Context::$pageRepository->deletePage($pageID);
        }
    }
}
