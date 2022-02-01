<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSS Files -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">


    <title>Réservez votre nom de domaine</title>
</head>
<body class="bg-light">


    <main class="bg-white w-75 mx-auto my-auto p-4 d-flex flex-column">

        <h2 class="mb-5 fs-4">Verifiez la disponibilité d'un nom de domaine et réserver-le en quelques cliques</h2>

        <form method="post" class="d-flex flex-column align-items-start needs-validation" novalidate>
            <label for="domain">Entrez un nom de domaine</label>
            <div class="input-group mt-3 hover-shadow">
                <input type="text" name="domain" id="domain" placeholder="monsite.com" required class="form-control">
                <button type="submit" class="btn btn-outline-primary">Vérifier la disponibilité</button>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback">
                    Veillez entrer un nom de domaine valide
                </div>
            </div>
        </form>

    </main>

    <?php

        if(isset($_SESSION['item-id'])) {
            include_once ("Template/cart.php");
        }

    ?>


    <!-- Footer -->
    <footer class="position-absolute bottom-0 start-0 bg-secondary w-100 d-flex align-items-start justify-content-center py-1" style="--bs-bg-opacity: .5;">
        <h3 class="fs-5">Made by EPIXELIC</h3>
    </footer>



    <!-- Link Bootstrap js-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Link main.js file -->
    <script src="Public/js/main.js"></script>

</body>
</html>