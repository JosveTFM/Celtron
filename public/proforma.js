const container_servicios = document.getElementById("container-servicios")

if(container_servicios){
    container_servicios.addEventListener("change", async (event) => {
        const target = event.target
        let idservicio = target.dataset.idservicio
        const form = new FormData()
        form.append("idservicio", idservicio)
        form.append(target.checked ? "btnAgregarServicio":"btnQuitarServicio", "")
        await fetch("getEmitirProforma.php",{
            method: 'POST',
            body: form
        });
        // const data = await response.json();
        // document.getElementById("precioTotal").innerText = data["precioTotal"]
        // let igv = parseFloat(data["precioTotal"]).toFixed(2) * parseFloat(0.18).toFixed(2)
        // let subtotal = parseFloat(data["precioTotal"]).toFixed(2) - igv

        // igv = parseFloat(igv).toFixed(2)
        // subtotal = parseFloat(subtotal).toFixed(2)
        // document.getElementById("igv").innerText = igv
        // document.getElementById("subtotal").innerText = subtotal
    })
}