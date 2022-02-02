// Declare data

var domain = [];
var user = {};

// Add domain to the array function

function addToCart(elm) {

    //Get form
    let form = document.getElementById("domain");

    if(form.value.length == 0) {
        alert('Veillez entrer un nom de domaine valide.');
    } else {
        domain.push(form.value);
        console.log("Domain array updated !");
        console.log(domain);
        form.value = "";
    }

}