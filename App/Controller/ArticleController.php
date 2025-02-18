<?php
namespace App\Controller;

use App\Repository\ArticleRepository;

class ArticleController extends Controller
{
    public function route(): void
    {
        try {
            if (isset($_GET['action'])) {
                switch ($_GET['action']) {
                    case 'list':
                        $this->list();
                        break;
                    case 'show':
                        $this->show();
                        break;
                    default:
                        throw new \Exception("Cette action n'existe pas : ".$_GET['action']);
                }
            } else {
                throw new \Exception("Aucune action détectée");
            }
        } catch(\Exception $e) {
            $this->render('errors/default', [
                'error' => $e->getMessage()
            ]);
        }
    }

    protected function list()
    {
        $repository = new ArticleRepository();
        $articles = $repository->findAll();
        
        $this->render('article/list', [
            'articles' => $articles
        ]);
    }

    protected function show()
    {
        if (!isset($_GET['id'])) {
            throw new \Exception("L'id est manquant");
        }
        
        $repository = new ArticleRepository();
        $article = $repository->findOneById($_GET['id']);
        
        if (!$article) {
            throw new \Exception("L'article n'existe pas");
        }
        
        $this->render('article/show', [
            'article' => $article
        ]);
    }
}
