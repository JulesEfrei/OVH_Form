// Build popup function (Error & Success popup)

function buildPopup(elm, is_error) {

    let div_class = ["alert", "position-fixed", "w-auto", "top-0", "end-0", "mt-4", "me-4", "popanim"];
    let p_class = "mb-0"

    if(is_error == true) {

        //Add Error class to the div
        div_class.push("alert-danger");

    } else {

        //Add Success class to the div
        div_class.push("alert-success");

    }

    // Create Popup
    //Container
    let container = document.createElement("div");

    div_class.forEach(element => {
        container.classList.add(element);
    })
    container.style.zIndex = 2000;

    //Text element
    let text = document.createElement("p");
    text.classList.add(p_class);
    text.innerText = elm;

    //Asign element
    container.appendChild(text)
    document.body.appendChild(container);

    popupAnimation()

}

function popupAnimation() {

    let tl = gsap.timeline()

    tl.from('.popanim', {opacity: 0, duration: .7, x: 300, })
        .to('.popanim', {delay: 3, duration: .7, x: 300, opacity: 0})


    //Reset all popanim container
    setTimeout(() => {
        let popup = document.querySelectorAll(".popanim")

        popup.forEach(elm => {
            elm.remove();
        })
    }, 4400)


}

function addElement(domainName, color) {

    document.getElementById("domainListContainer").style.display = "block"

    if(color == "green") {
        var selector = document.getElementById("domain-item-green");
    } else if(color == "red") {
        var selector = document.getElementById("domain-item-red");
    }

    let title = selector.cloneNode(true)
    title.id = domainName
    title.firstElementChild.innerHTML = title.firstElementChild.innerHTML + domainName

    selector.after(title);

    title.setAttribute('onclick',`deleteDomain('${domainName}')`)
    title.style.display = "flex"

}

function addModalCore() {

    if (domain.length == 0) {

        if(!document.getElementById("anything")) {

            let rm = document.getElementById("modal-body")
            while (rm.firstChild) { rm.removeChild(rm.firstChild); }

            let selector = document.getElementById("modal-body-container")

            let elm = document.createElement("p")
            elm.id = "anything"
            elm.innerHTML = "Aucun nom de domaine ajouté au pannier"

            selector.appendChild(elm)
        }

    } else {

        let selector = document.getElementById("modal-body")

        while (selector.firstChild) { selector.removeChild(selector.firstChild); }
        if(document.getElementById("anything")) {document.getElementById("anything").remove()}


        domain.forEach(domain => {
            let elm = document.createElement("li")
            elm.innerHTML = domain

            selector.appendChild(elm)
        })

    }

}



function addDevModalCore(cartId, contactId) {

    let selector = document.getElementById("devModal-body")
    while (selector.firstChild) { selector.removeChild(selector.firstChild); }

    let cart = document.createElement("li")
    let contact = document.createElement("li")

    cart.innerHTML = "Numéro de pannier : " + cartId
    contact.innerHTML = "Numéro de contact : " + contactId

    selector.appendChild(cart)
    selector.appendChild(contact)

}