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


//Modal Core Object
class ModalCore {

    constructor() {

        this.modalContainer = document.getElementById("modal-body-container")

        ModalCore.removeOldModal()

        let firstText = document.createElement("p")
        let secondText = document.createElement("p")
        let firstList = document.createElement("ul")
        let secondList = document.createElement("ul")

        firstText.id = "firstText"
        secondText.id = "secondText"
        firstList.id = "firstList"
        secondList.id = "secondList"

        this.modalContainer.appendChild(firstText)
        this.modalContainer.appendChild(firstList)
        this.modalContainer.appendChild(secondText)
        this.modalContainer.appendChild(secondList)

    }

    static removeOldModal() {

        this.modalContainer = document.getElementById("modal-body-container")

        if(this.modalContainer.children.length != 0) {

            while (this.modalContainer.firstChild) { this.modalContainer.removeChild(this.modalContainer.firstChild); }

        }

    }

    static invalidForm() {

        ModalCore.removeOldModal()

        let firstText = document.createElement("p")
        firstText.id = "firstText"
        this.modalContainer.appendChild(firstText)

        document.getElementById("firstText").innerHTML = "Le formulaire n'a pas été remplis correctement."
        this.disableValidation()

    }

    static disableValidation() {

        document.getElementById("lastConfirm").style.display = "none";

    }

    static enableValidation() {

        document.getElementById("lastConfirm").style.display = "block";

    }

    static render(user, domainList) {
        let domainCore = new DomainCore(domainList)
        let userCore = new UserCore(user)

        domainCore.render()
        userCore.render()
    }

}

class DomainCore {

    constructor(domainList) {
        this.domain = domainList

        document.getElementById("firstText").innerText = "Vous êtes sur le point d’enregistrer les nom de domaines suivants :"

    }

    render() {

        if(domain.length != 0) {

            this.showDomain()

        } else {

            this.showNoDomain()
            ModalCore.disableValidation()

        }

    }

    showDomain() {

        domain.forEach(domain => {
            let elm = document.createElement("li")
            elm.innerHTML = domain

            document.getElementById("firstList").appendChild(elm)
        })

    }

    showNoDomain() {

        document.getElementById("firstList").innerHTML = "<li>Aucun nom de domaine</li>"

    }

}

class UserCore {

    constructor(user) {
        this.user = user

        document.getElementById("secondText").innerHTML = "Propriétaire déclaré :"

    }

    render() {

        let selector = document.getElementById("secondList")

        Object.keys(this.user).forEach(field => {

            if(field == "address") {

                Object.keys(this.user["address"]).forEach(adressField => {

                    let elm = document.createElement("li")
                    elm.innerHTML = adressField + " : " + this.user[field][adressField]

                    selector.appendChild(elm)

                })

            } else {

                let elm = document.createElement("li")
                elm.innerHTML = field + " : " + this.user[field]

                selector.appendChild(elm)

            }
        })

    }

}