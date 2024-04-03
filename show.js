function togglePasswordVisibility(inputId) {
    var input = document.getElementById(inputId);
    var icon = input.nextElementSibling.querySelector('img');

    if (input.type === "password") {
        input.type = "text";
        icon.src = "show.png";
    } else {
        input.type = "password";
        icon.src = "show.png";
    }
}

