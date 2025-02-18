<?php require_once _ROOTPATH_ . '/templates/header.php'; ?>

<h1><?= htmlspecialchars($article->getTitle()) ?></h1>

<div class="article-content">
    <?= nl2br(htmlspecialchars($article->getDescription())) ?>
</div>

<a href="index.php?controller=article&action=list" class="btn btn-primary mt-3">Retour à la liste</a>

<?php require_once _ROOTPATH_ . '/templates/footer.php'; ?>
