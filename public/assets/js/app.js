const addToCart = (id) => {
    
    axios.defaults.withCredentials = true

    axios.get(`?a=addToCart&idProduct=${id}`)
        .then((response) => {

            let total = response.data
            let span = document.getElementById("total")
            span.innerHTML = total
            span.parentElement.classList.add("badge")
            
        })

}

const clearCart = () => {

    axios.defaults.withCredentials = true

    axios.get("?a=clearCart")
        .then((response) => {

            let total = response.data
            let span = document.getElementById("total")
            span.innerHTML = 0
            span.parentElement.classList.remove("badge")
            
        })

}