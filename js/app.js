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

            // If domain is not available
            switch (data[data.length - 1]) {
                case "1":
                    buildPopup("Nom de domaine indisponible.", true)
                    //Reset domain variable
                    addElement(domain[domain.length - 1], "red")
                    domain.pop(domain[domain.length - 1])
                    break;
                case "0":
                    buildPopup("Nom de domaine disponible.", false)
                    addElement(domain[domain.length - 1], "green")
                    break;
                case "2":
                    domain = data.split(",")
                    domain.pop()

                    domain.forEach(elm => {
                        addElement(elm, "green")
                    })
                    break;
                case "3":
                    let infoList = data.split(",")
                    infoList.pop()
                    addDevModalCore(infoList[0], infoList[1])
                    break;
            }

        }
    });

}



//Update domain list onload
window.onload = () => {
    ajaxSetup({action: "updateDomain"})
}



//Press Enter to send domainName
document.getElementById("domain").addEventListener("keyup", (e) => {
    if(document.getElementById("domain").value != "" && e.code == "Enter") {
        addToCart()
    }
})



// Add domain to global array

function addToCart() {

    //Get form
    let form = document.getElementById("domain");

    // If empty
    if(form.value.length == 0) {

        buildPopup("Veillez entrer un nom de domaine", true);

    } else {

        //If invalid domain
        if(isDomain(form.value) == 0) {

            buildPopup("Nom de domaine invalide", true);

        } else {

            domain.push(form.value);
            ajaxSetup({action: "addDomain", domain: domain[domain.length - 1]})
            form.value = ""
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

function deleteDomain(domainName) {

    let index = domain.findIndex(elm => elm === domainName)

    //If domainName is in domain array (If not, it's already not inside the cart)
    if(index != -1) {

        //Ask confirmation
        if(confirm(`Attention, vous allez supprimer ${domainName} de votre pannier`)){

            //Ajax request
            ajaxSetup({action: "removeDomain", domain: domainName})

            //Remove domainName to the global array
            domain.splice(index, 1)

            //Reset sytle of domain container if domain is empty
            if(domain.length == 0){ document.getElementById("domainListContainer").style.display = "none" }

            document.getElementById(domainName).remove()
        }

    } else {

        //Remove domain in front
        document.getElementById(domainName).remove()

    }


}


// If form already send
function witchForm() {

    if(document.getElementById("name").value != "" && document.getElementById("last_name").value != "") {
        getFormData("customer-form")
    } else if(document.getElementById("nameB").value != "" && document.getElementById("last_nameB").value != "") {
        getFormData("business-form")
    } else {
        buildPopup("Veuillez remplir le formulaire", true)
        emptyForm()
        disable()
    }

}



// Get data from form

function getFormData(id) {

    // If the form is not correctly completed
    if(document.getElementById(id).checkValidity() == false) {

        buildPopup("Veillez remplir le formulaire correctement", true)
        emptyForm()
        disable()

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
                emptyForm()
                disable()

                return "ERROR"

            }

        } else { //Set default value

            user["legalForm"] = "individual"

        }

        if(select(id) == true) {

            addModalCore()

        } else {
            emptyForm()
            disable()
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

        return false

    } else {

        user["language"] = language.value
        user["address"]["country"] = country.value

        return true
    }


}



//Order function

function order() {

    let verif = true

    if(domain.length == 0) {
        buildPopup("Veillez entrer un ou plusieurs nom de domaine", true)
        verif = false
    }

    if(Object.keys(user).length == 0) {
        buildPopup("Veuillez remplir le formulaire", true)
        verif = false
    }

    if(verif == true) {
        ajaxSetup({action: "contact", user: JSON.stringify(user)})
        ajaxSetup({action: "validation"})
        buildPopup("Les informations ont bien ??t?? enregistr??", false)
    }

}