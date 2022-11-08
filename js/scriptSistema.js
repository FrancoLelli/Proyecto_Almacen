/* Agregar clase o quitar a icono */
const logoHamburguesa = document.querySelector(".barra");
const lista = document.querySelector(".navegation ul")

logoHamburguesa.addEventListener("click", ()=>{
    lista.classList.toggle("show")
})

