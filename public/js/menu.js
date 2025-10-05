document.addEventListener("DOMContentLoaded", function () {
    let menu = document.getElementById("menu");
    let menuToggle = document.getElementById("menuToggle");
    let body = document.body;

    menuToggle.addEventListener("click", function () {
        let isOpen = body.classList.contains("menu-open");

        if (isOpen) {
            menu.style.left = "-250px"; // Ocultar menú
            body.classList.remove("menu-open");
            setTimeout(() => {
                menuToggle.style.opacity = "1";
                menuToggle.style.transform = "scale(1)";
            }, 300);
        } else {
            menu.style.left = "0"; // Mostrar menú
            body.classList.add("menu-open");
            menuToggle.style.opacity = "0";
            menuToggle.style.transform = "scale(0)";
        }
    });

    // Cerrar el menú al hacer clic fuera
    document.addEventListener("click", function (event) {
        if (!menu.contains(event.target) && !menuToggle.contains(event.target)) {
            menu.style.left = "-250px";
            body.classList.remove("menu-open");
            setTimeout(() => {
                menuToggle.style.opacity = "1";
                menuToggle.style.transform = "scale(1)";
            }, 300);
        }
    });
});
document.addEventListener("click", function (e) {
    if (e.target.closest('a[href="#logout"]')) {
        e.preventDefault();
        // Crea y envía el formulario POST de logout
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/logout';

        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = '_token';
        input.value = token;

        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
    }
});
