const addToCart = (id) => {
    axios.defaults.withCredentials = true
    axios.get(`?a=addToCart&idProduct=${id}`)
        .then((response) => {
            if(response.data != "") {
                let total = response.data
                let span = document.getElementById("total")
                span.innerHTML = total
                span.parentElement.classList.add("badge")
            }
        })
}

const clearCart = () => {
    let e = document.getElementById("confirm-clear-cart")
    e.style.display = "inline"
}

const clearCartOff = () => {
    let e = document.getElementById("confirm-clear-cart")
    e.style.display = "none"
}