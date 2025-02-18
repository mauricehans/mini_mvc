<?php
namespace App\Repository;

use App\Entity\Comment;

class CommentRepository extends Repository
{
    public function findByArticleId(int $articleId)
    {
        $query = $this->pdo->prepare("
            SELECT c.*, CONCAT(u.first_name, ' ', u.last_name) AS author
            FROM comment c
            INNER JOIN user u ON c.user_id = u.id
            WHERE c.article_id = :article_id
            ORDER BY c.id DESC
        ");
        $query->bindParam(':article_id', $articleId, \PDO::PARAM_INT);
        $query->execute();
        $results = $query->fetchAll($this->pdo::FETCH_ASSOC);

        $comments = [];
        foreach ($results as $result) {
            $comment = Comment::createAndHydrate($result);
            $comment->setAuthor($result['author']);
            $comments[] = $comment;
        }
        return $comments;
    }
    
    public function persist(Comment $comment)
    {
        $query = $this->pdo->prepare("
            INSERT INTO comment (comment, user_id, article_id)
            VALUES (:comment, :user_id, :article_id)
        ");
        $commentText = $comment->getComment();
        $userId = $comment->getUserId();
        $articleId = $comment->getArticleId();

        $query->bindParam(':comment', $commentText, \PDO::PARAM_STR);
        $query->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $query->bindParam(':article_id', $articleId, \PDO::PARAM_INT);
        return $query->execute();
    }
}
