// Declare data

var domain = []; //Get all the domain name wanted
var user = {}; //Get all information about the client


// Add domain to the array function

function addToCart() {

    //Get form
    let form = document.getElementById("domain");

    // If empty
    if(form.value.length == 0) {
        buildPopup("Veillez entrer un nom de domaine", true);
        console.log("Empty form")
    } else {

        //If invalid domain
        if(isDomain(form.value) == 0) {
            buildPopup("Nom de domaine invalide", true);
            console.log("Invalid domain")
        } else {
            buildPopup("Nom de domaine ajouter au pannier", false);
            domain.push(form.value);
            console.log("Domain array updated !");
            console.log(domain);
            form.value = "";
        }
    }

}

// Test If string is domain

function isDomain(string) {

    const regex = /^(((?!\-))(xn\-\-)?[a-z0-9\-_]{0,61}[a-z0-9]{1,1}\.)*(xn\-\-)?([a-z0-9\-]{1,61}|[a-z0-9\-]{1,30})\.[a-z]{2,}$/;

    if(string.match(regex)) {
        return 1
    } else {
        return 0
    }

}


// If form already send function
function ifData(id) {
    //If form has already pass
    if (Object.keys(user).length != 0) {
        if(confirm("Attention, vous allez écraser le formulaire précédent") == true) {
            getFormData(id)
        }
    } else {
        getFormData(id)
    }
}


// Get data from form

function getFormData(id) {

    // If the form is not correctly completed
    if(document.getElementById(id).checkValidity() == false) {
        buildPopup("Veillez remplir le formulaire correctement", 1)
        console.log("Invalid form")
    } else {

        let selector = "#" + id + " input";

        //Get all input from form

        let input = document.querySelectorAll(selector);

        //Get data

        user = Array.from(input).reduce((acc, input) => ({...acc, [input.name]: input.value}), {})

        //If business form => Get the select tag

        if(id == "business-form") {

            let select = document.getElementById("select").value;

            user["type"] = select

        }

        verifyData(id);

    }

}


//Verify data user form

function verifyData(form) {

    if (form == "business-form") {
        if(user.type == "1") {
            buildPopup("Type de compte incorrect", true)
            console.log("Type of account invalid")
            return false
        }
    }

    if(user.password == user.confirm_password) {
        buildPopup("Le formulaire à bien été enregistré", false)
        console.log("Form send !")
    } else {
        buildPopup("Les mots de passe ne correspondent pas", true)
        console.log("Passwords do not match.")
    }

}


//Order function

function order() {

    if(domain.length == 0 || Object.keys(user).length == 0) {
        buildPopup("Impossible de valider votre commande.\n Veuillez vérifier que vous avez entré un nom de\n domaine valide et remplis le formulaire.", true)
        console.log("Order invalid. Please enter domain name and complete the form")
    } else {
        buildPopup("Commande envoyé !", false)

        //AJAX
        $.ajax({
            url: 'index.php',
            data: {user: JSON.stringify(user), domain: JSON.stringify(domain)},
            contentType: "application/x-www-form-urlencoded; charset=UTF-8", // $_POST
            type: 'POST',
        });

    }

}