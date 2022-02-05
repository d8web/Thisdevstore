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

const showAddress = () => {
    let e = document.getElementById("checkAddressAlternative")
    if(e.checked) {
        document.getElementById("endereco_alternativo").style.display = 'block'
    } else {
        document.getElementById("endereco_alternativo").style.display = 'none'
    }
}

const addressAlternative = (e) => {
    axios({
        method: 'post',
        url: '?a=addressAlternative',
        data: {
            address: document.getElementById("addressAlternative").value,
            city: document.getElementById("cityAlternative").value,
            email: document.getElementById("emailAlternative").value,
            phone: document.getElementById("phoneAlternative").value,
        }
    })
    .then(() => console.log("Ok"));
}