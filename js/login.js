    const togglePassword = document.getElementById("togglePassword");
    const password = document.getElementById("password");
    const icon = document.getElementById("icono-ojo");

    togglePassword.addEventListener("click", function() {
      const tipo = password.getAttribute("type") === "password" ? "text" : "password";
      password.setAttribute("type", tipo);
      icon.classList.toggle("bi-eye");
      icon.classList.toggle("bi-eye-slash");
    });