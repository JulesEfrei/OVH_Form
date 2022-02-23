// Declare data

var domain = []; //Get all the domain name wanted
var user = {}; //Get all information about the client

//AJAX setup function
function ajaxSetup(content) {

    //AJAX
    $.ajax({
        url: './php/index.php',
        data: content,
        contentType: "application/x-www-form-urlencoded; charset=UTF-8",
        type: 'POST',
        success: function(data) {
            console.log(data)

            // If domain is not available
            if(data[data.length - 1] == "1") {

                buildPopup("Nom de domaine indisponible. Veillez selectionner un autre nom de domaine", true)

                //Reset domain variable
                domain.pop(domain[domain.length - 1])

            } else if(data[data.length - 1] == "0") {

                buildPopup("Nom de domaine ajouté au pannier", false)

                addElement(domain[domain.length - 1])

            }

        }
    });

}

// Add domain to global array

function addToCart() {

    //Get form
    let form = document.getElementById("domain");

    // If empty
    if(form.value.length == 0) {

        buildPopup("Veillez entrer un nom de domaine", true);
        console.log("Empty input")

    } else {

        //If invalid domain
        if(isDomain(form.value) == 0) {

            buildPopup("Nom de domaine invalide", true);
            console.log("Invalid domain")

        } else {

            domain.push(form.value);
            console.log(domain)
            console.log("Domain updated")
            ajaxSetup({action: "addDomain", domain: domain[domain.length - 1]})

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


// If form already send
function ifData(id) {

    //If form has already pass
    if (Object.keys(user).length != 0) {

        //Ask for remove last form
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

        buildPopup("Veillez remplir le formulaire correctement", true)
        console.log("Invalid form")

    } else {

        //Get input selector

        let selector = "#" + id + " input[data-obj='1']";
        let adresseSelector = "#" + id + " input[data-obj='2']";


        //Get all input from form

        let input = document.querySelectorAll(selector);
        let adressInput = document.querySelectorAll(adresseSelector);


        //Get data

        user = Array.from(input).reduce((acc, input) => ({...acc, [input.name]: input.value}), {})
        user['address'] = Array.from(adressInput).reduce((acc, input) => ({...acc, [input.name]: input.value}), {})



        //Get Type of account
        if(id == "business-form") {

            let select = document.getElementById("select").value;

            user["legalForm"] = select

            if(user.legalForm == "1") {

                buildPopup("Type de compte incorrect", true)
                console.log("Type of account invalid")

            }

        } else { //Set default value

            user["legalForm"] = "individual"

        }

        if(select(id) == true) {
            buildPopup("Le formulaire à bien été envoyé", false)
        }


    }

}



//Get Select input

function select(id) {

    if(id == "business-form") {

        var language = document.getElementById("selectLangB")
        var country = document.getElementById("selectCountryB")

    } else {

        var language = document.getElementById("selectLang")
        var country = document.getElementById("selectCountry")

    }


    if(language.value == 1 || country.value == 1) {

        buildPopup("Langue ou pays incorrect", true)
        console.log("Type of Language/Country invalid")

        return false

    } else {

        user["language"] = language.value
        user["address"]["country"] = country.value

        return true
    }


}



//Order function

function order() {

    //If not domain or form send error
    if(domain.length == 0 || Object.keys(user).length == 0) {

        buildPopup("Impossible de valider votre commande.\n Veuillez vérifier que vous avez entré un nom de\n domaine valide et remplis le formulaire.", true)
        console.log("Order invalid. Please enter domain name and complete the form")

    } else {

        buildPopup("Commande envoyé !", false)

        //AJAX
        $.ajax({
            url: './php/index.php',
            data: {user: JSON.stringify(user), domain: JSON.stringify(domain)},
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            type: 'POST',
            success: function(data) {
                console.log(data)

                // If domain is not available
                if(data[data.length - 1] == ">") {

                    buildPopup("Nom de domaine indisponible. Veillez selectionner un autre nom de domaine", true)

                    //Reset domain variable
                    domain = []

                }
            }
        });

    }

}