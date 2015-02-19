<?php

namespace CMS\Interactors\Pages;

use CMS\Interactors\Areas\DeleteAreaInteractor;
use CMS\Interactors\Areas\GetAreasInteractor;
use CMS\Interactors\Articles\GetArticlesInteractor;
use CMS\Interactors\Articles\UpdateArticleInteractor;
use CMS\Repositories\PageRepositoryInterface;
use CMS\Structures\ArticleStructure;

class DeletePageInteractor extends GetPageInteractor
{
    public function __construct(
        PageRepositoryInterface $repository,
        GetAreasInteractor $getAreasInteractor,
        DeleteAreaInteractor $deleteAreaInteractor,
        GetArticlesInteractor $getArticlesInteractor,
        UpdateArticleInteractor $updateArticleInteractor
    ) {
        parent::__construct($repository);

        $this->getAreasInteractor = $getAreasInteractor;
        $this->deleteAreaInteractor = $deleteAreaInteractor;
        $this->getArticlesInteractor = $getArticlesInteractor;
        $this->updateArticleInteractor = $updateArticleInteractor;
    }

    public function run($pageID)
    {
        if ($this->getPageByID($pageID)) {

            //If there are associated articles to this page, delete the reference
            $articles = $this->getArticlesInteractor->getByAssociatedPageID($pageID);

            if (is_array($articles) && sizeof($articles) > 0) {
                foreach ($articles as $article) {
                    $articleStructure = new ArticleStructure([
                        'page_id' => null
                    ]);

                    $this->updateArticleInteractor->run($article->getID(), $articleStructure);
                }
            }

            $areas = $this->getAreasInteractor->getAll($pageID);

            foreach ($areas as $area) {
                $this->deleteAreaInteractor->run($area->getID());
            }

            $this->repository->deletePage($pageID);
        }
    }
}
