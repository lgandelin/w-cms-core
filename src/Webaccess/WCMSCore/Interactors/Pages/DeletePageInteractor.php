<?php

namespace Webaccess\WCMSCore\Interactors\Pages;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Interactors\Areas\DeleteAreaInteractor;
use Webaccess\WCMSCore\Interactors\Areas\GetAreasInteractor;
use Webaccess\WCMSCore\Interactors\Articles\GetArticlesInteractor;
use Webaccess\WCMSCore\Interactors\Articles\UpdateArticleInteractor;
use Webaccess\WCMSCore\Structures\ArticleStructure;

class DeletePageInteractor extends GetPageInteractor
{
    public function run($pageID)
    {
        if ($this->getPageByID($pageID)) {
            $this->deleteAssociatedArticlesToPage($pageID);
            $this->deleteAreasInPage($pageID);
            Context::get('page')->deletePage($pageID);
        }
    }

    private function deleteAreasInPage($pageID)
    {
        $areas = (new GetAreasInteractor())->getAll($pageID);

        if (is_array($areas) && sizeof($areas) > 0) {
            foreach ($areas as $area) {
                (new DeleteAreaInteractor())->run($area->getID());
            }
        }
    }

    private function deleteAssociatedArticlesToPage($pageID)
    {
        $articles = (new GetArticlesInteractor())->getByAssociatedPageID($pageID);

        if (is_array($articles) && sizeof($articles) > 0) {
            foreach ($articles as $article) {
                $articleStructure = new ArticleStructure([
                    'page_id' => null
                ]);

                (new UpdateArticleInteractor())->run($article->getID(), $articleStructure);
            }
        }
    }
}
