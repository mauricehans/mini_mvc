<?php require_once _ROOTPATH_ . '/templates/header.php'; ?>

<h1>Liste des articles</h1>

<div class="row">
    <?php foreach ($articles as $article) { ?>
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($article->getTitle()) ?></h5>
                    <a href="index.php?controller=article&action=show&id=<?= $article->getId() ?>" class="btn btn-primary">Lire plus</a>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

<?php require_once _ROOTPATH_ . '/templates/footer.php'; ?>
