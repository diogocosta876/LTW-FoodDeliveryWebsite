function DarkMode(){
    let button = document.querySelector(".darkmode_toggle #switch")
    button.addEventListener('click', function() {
        let string = "body, nav, header#logo, ul.nav_options > li > a, ul.nav_options > li > a > i, div.ad_banner_label,"
        + " section#cart, section#cart div.cart_info, a.remove_cart_item, article.cart_dish, div.order_info, div.total"
        + ""
        let dark_elements = document.querySelectorAll(string)
        for (let e of dark_elements){
                e.classList.toggle("dark_mode");
            }
    })
}

//Allows scrolling with mousewheel
function HorizontalScroll1(){
    var item = document.getElementById("restaurants");

    window.addEventListener("wheel", function (e) {
        if ($('#restaurants:hover').length != 0){
            if (e.deltaY > 0) item.scrollLeft += 100;
            else item.scrollLeft -= 100;
        }
    });
}

function HorizontalScroll2(){
    var item = document.getElementById("dishes");

    window.addEventListener("wheel", function (e) {
        // TODO em vez do cifrao selecionar DOM
        if ($('#dishes:hover').length != 0){
            if (e.deltaY > 0) item.scrollLeft += 100;
            else item.scrollLeft -= 100;
        }
    });
}

function Favourite_dish(){
    let buttons = document.querySelectorAll(".add_to_favourites_button i")
    for (button of buttons){
        button.addEventListener('click', function(e) {
            console.log("favourite button clicked");
            e.target.classList.toggle("fa-heart-o")
            e.target.classList.toggle("fa-heart")
            })
    }
}

DarkMode()
HorizontalScroll1()
HorizontalScroll2()
Favourite_dish()