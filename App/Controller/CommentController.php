<?php
namespace App\Controller;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use App\Entity\User;

class CommentController extends Controller
{
    public function route(): void 
    {
        try {
            if (isset($_GET['action'])) {
                switch ($_GET['action']) {
                    case 'add':
                        $this->add();
                        break;
                    default:
                        throw new \Exception("Action inconnue : " . $_GET['action']);
                }
            } else {
                throw new \Exception("Aucune action détectée");
            }
        } catch (\Exception $e) {
            $this->render('errors/default', [
                'error' => $e->getMessage()
            ]);
        }
    }
    
    protected function add()
    {
        // Vérifier que l'utilisateur est connecté
        if (!User::isLogged()) {
            throw new \Exception("Vous devez être connecté pour ajouter un commentaire");
        }
        // Vérifier la présence d'un article_id en GET
        if (!isset($_GET['article_id'])) {
            throw new \Exception("L'id de l'article est manquant");
        }
        // Vérifier que le commentaire est transmis en POST
        if (!isset($_POST['comment']) || empty(trim($_POST['comment']))) {
            throw new \Exception("Le commentaire ne peut pas être vide");
        }
        
        $commentText = trim($_POST['comment']);
        $articleId   = intval($_GET['article_id']);
        $userId      = User::getCurrentUserId();
        
        $comment = new Comment();
        $comment->setComment($commentText)
                ->setUserId($userId)
                ->setArticleId($articleId);
                
        $commentRepo = new CommentRepository();
        if ($commentRepo->persist($comment)) {
            header('Location: index.php?controller=article&action=show&id=' . $articleId);
            exit;
        } else {
            throw new \Exception("Erreur lors de l'ajout du commentaire");
        }
    }
}
