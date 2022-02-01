<?php if($_SESSION['is_orderable'] == 1): ?>

    <div class="alert alert-success position-absolute w-auto top-0 end-0 mt-4 me-4 d-flex flex-column" role="alert">
        <p class="mb-0">Le nom de domaine <strong><?php echo $_SESSION["domain"] ?></strong> est disponible</p>
        <a href="index.php?action=newitem" class="btn btn-outline-primary mt-3 align-self-center btn-sm">Ajouter le nom de domaine au pannier</a>
    </div>

<?php elseif($_SESSION['is_orderable'] == 0): ?>

    <div class="alert alert-danger position-absolute w-auto top-0 end-0 mt-4 me-4" role="alert">
        <p class="mb-0">Le nom de domaine <strong><?php echo $_SESSION["domain"] ?></strong> est indisponible</p>
    </div>

<?php else: ?>

    <div class="alert alert-danger position-absolute w-auto top-0 end-0 mt-4 me-4" role="alert">
        <p class="mb-0">Entrez un nom de domaine valide</p>
    </div>

<?php endif; ?>