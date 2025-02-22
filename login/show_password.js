function passwordToggle() {
    var x = document.getElementById("passShow");
    var y = document.getElementById("cPassShow");
    if (x.type === "password") {
        x.type = "text";
        y.type = "text";
    } else {
        x.type = "password";
        y.type = "password";
    }
}