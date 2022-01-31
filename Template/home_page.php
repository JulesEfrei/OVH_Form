<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSS Files -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">


    <title>Réservez votre nom de domaine</title>
</head>
<body class="bg-light">


    <main class="bg-white w-75 mx-auto my-auto p-4">

    <h2 class="mb-5 fs-4">Verifiez la disponibilité d'un nom de domaine et réserver-le en quelques cliques</h2>

    <form method="post" class="d-flex flex-column align-items-start needs-validation" novalidate>
        <label for="domain">Entrez un nom de domaine</label>
        <div class="input-group mt-3">
            <input type="text" name="domain" id="domain" placeholder="monsite.com" required class="form-control">
            <button type="submit" class="btn btn-outline-primary">Vérifier la disponibilité</button>
            <div class="valid-feedback"></div>
            <div class="invalid-feedback">
                Veillez entrer un nom de domaine valide
            </div>
        </div>
    </form>

    </main>



    <!-- Footer -->
    <footer class="position-absolute bottom-0 start-0 bg-secondary w-100 d-flex align-items-start justify-content-center py-1" style="--bs-bg-opacity: .5;">
        <h3>Made by EPIXELIC</h3>
    </footer>



    <!-- Link Bootstrap js-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function () {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>

</body>
</html>
