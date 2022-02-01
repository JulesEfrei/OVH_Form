

    <section class="w-75 h-auto bg-white mx-auto mt-5 d-flex flex-column ">
        <div class="d-flex justify-content-between p-4 align-item-center border-bottom border-dark">
            <div>
                <h2 class="fs-3">Votre pannier</h2>
                <h3 class="fs-6">Numéro : <?php echo($_SESSION['cartId']) ?></h3>
            </div>
        </div>
        <h3 class="fs-6 p-4">Nombre de nom de domaine : <?php echo(count($_SESSION['item-id'])); ?></h3>
        <div class="px-4 pb-4 container">
            <div class="row border-bottom border-secondary">
                <h3 class="col-7 fs-5">Nom de domaine</h3>
                <h3 class="col-4 fs-5">Id</h3>
            </div>
            <?php foreach ($_SESSION['item-id'] as $elm): ?>
                <div class="row pt-3">
                    <h5 class="col-7 fs-6 text-black-50"><?php getNameFromId($elm); ?></h5>
                    <h5 class="col-4 fs-6 text-black-50"><?php echo($elm); ?></h5>
                    <a href="index.php?action=deleteitem&id=<?php echo($elm); ?>" class="col-1 text-black-50"><i class="far fa-trash-alt"></i></a>
                </div>
            <?php endforeach; ?>
            <div class="row pt-3">
                <h5 class="col-7 fs-6 text-black-50">...</h5>
            </div>
        </div>
    </section>