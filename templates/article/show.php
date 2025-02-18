<?php require_once _ROOTPATH_ . '/templates/header.php'; ?>

<h1><?= htmlspecialchars($article->getTitle()) ?></h1>

<div class="article-content">
    <?= nl2br(htmlspecialchars($article->getDescription())) ?>
</div>

<!-- Section Commentaires -->
<h2>Commentaires</h2>

<?php if (!empty($comments)) { ?>
    <?php foreach ($comments as $comment) { ?>
        <div class="comment mb-3">
            <p><strong><?= htmlspecialchars($comment->getAuthor()) ?></strong> dit :</p>
            <p><?= nl2br(htmlspecialchars($comment->getComment())) ?></p>
        </div>
    <?php } ?>
<?php } else { ?>
    <p>Aucun commentaire pour le moment.</p>
<?php } ?>

<!-- Formulaire pour ajouter un commentaire -->
<?php if (\App\Entity\User::isLogged()) { ?>
    <form method="POST" action="index.php?controller=comment&action=add&article_id=<?= htmlspecialchars($article->getId()) ?>">
        <div class="mb-3">
            <textarea name="comment" class="form-control" placeholder="Votre commentaire" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter un commentaire</button>
    </form>
<?php } else { ?>
    <p><a href="index.php?controller=auth&action=login">Connectez-vous</a> pour ajouter un commentaire.</p>
<?php } ?>

<a href="index.php?controller=article&action=list" class="btn btn-primary mt-3">Retour à la liste</a>

<?php require_once _ROOTPATH_ . '/templates/footer.php'; ?>
