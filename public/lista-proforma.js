
const table_productos_lista = document.getElementById("table_productos_lista")

if(table_productos_lista){
    table_productos_lista.addEventListener("click", async (event) => {
        event.preventDefault();
        const target = event.target
        if(target.closest('button') != undefined){
            let idproducto = target.closest('button').dataset.idproducto

            let nombreProducto = target.closest('button').parentNode.nextElementSibling.innerText
            document.getElementById('modal-nombre_producto').innerText = nombreProducto
            document.querySelector('.modal-bg').classList.add('modal-bg--active');
            document.querySelector('.modal').addEventListener('click', async (event) => {
                event.preventDefault();
                const targetModal = event.target
                if(targetModal.closest('.modal__action--cancelar') != undefined){
                    document.querySelector('.modal-bg').classList.remove('modal-bg--active');
                }
                if(targetModal.closest('.modal__action--continuar') != undefined){
                    document.querySelector('.modal-bg').classList.remove('modal-bg--active');
                    target.closest('button').parentNode.parentNode.remove()
                    const form = new FormData()
                    form.append("idproducto", idproducto)
                    form.append("btnQuitarProducto","")
                    const response = await fetch('../moduloVentas/getEmitirProforma.php',{
                        method: 'POST',
                        body: form
                    })
                    const data = await response.json()
                    document.getElementById("precioTotal").innerText = data["precioTotal"]
                    let igv = parseFloat(data["precioTotal"]).toFixed(2) * parseFloat(0.18).toFixed(2)
                    let subtotal = parseFloat(data["precioTotal"]).toFixed(2) - igv
            
                    igv = parseFloat(igv).toFixed(2)
                    subtotal = parseFloat(subtotal).toFixed(2)
                    document.getElementById("igv").innerText = igv
                    document.getElementById("subtotal").innerText = subtotal
                }
            })
        }
        if(target.closest('.input-counter') != undefined){
            let idproducto = target.closest('.input-counter').dataset.idproducto
            let value = target.closest('.input-counter').value
            const form = new FormData()
            form.append("idproducto", idproducto)
            form.append("cantidad", value)
            form.append("btnCounterProducto", "")
            const response = await fetch("getEmitirProforma.php",{
                method: 'POST',
                body: form
            });
            const data = await response.json();
            [ ...document.querySelectorAll('.input-result') ].forEach(element => {
                let precioUnitario = parseFloat(element.parentNode.previousElementSibling.previousElementSibling.firstElementChild.value)
                let cantidad = parseFloat(element.parentNode.previousElementSibling.firstElementChild.value).toFixed(2)
                element.value = parseFloat(precioUnitario*cantidad).toFixed(2);
            });
            document.getElementById("precioTotal").innerText = data["precioTotal"]
            let igv = parseFloat(data["precioTotal"]).toFixed(2) * parseFloat(0.18).toFixed(2)
            let subtotal = parseFloat(data["precioTotal"]).toFixed(2) - igv

            igv = parseFloat(igv).toFixed(2)
            subtotal = parseFloat(subtotal).toFixed(2)
            document.getElementById("igv").innerText = igv
            document.getElementById("subtotal").innerText = subtotal
        }
    })
}