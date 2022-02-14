// Loadding animation

window.onload = function () {

    let tl = gsap.timeline();

    tl.from(".navbar", {duration: .5, y: -100, opacity: 0})
        .from(".gsap1", {duration: .5, y: 100, opacity: 0, stagger: .15})
        .from(".bg-danger", {duration: 1.5, ease: "power1.in", opacity: 0}, "<")

}

// Scroll animation

function scrollAnimation() {

    //OVH section
    gsap.from(".gsap2", {
        scrollTrigger: {
            trigger: "#ovh",
            start: "top 95%",
            toggleActions: "restart pause pause"
        },
        y: 50,
        opacity: 0,
        stagger: .1,
        duration: .3
    })

    //Domain section
    gsap.from(".domain-title", {
        scrollTrigger: {
            trigger: "#domain_section",
            start: "top 95%",
            toggleActions: "restart pause pause"
        },
        x: -300,
        opacity: 0,
        stagger: .1,
        duration: .5
    })
    gsap.from(".gsap3", {
        scrollTrigger: {
            trigger: "#domain_section",
            start: "top 95%",
            toggleActions: "restart pause pause"
        },
        x: 300,
        opacity: 0,
        stagger: .1,
        duration: .5
    })

}

scrollAnimation()



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