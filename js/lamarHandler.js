// lamarHandler.js
document.addEventListener("DOMContentLoaded", function () {
    const elseLamarBtn = document.getElementById("elselamar");
    const loginLamarBtn = document.getElementById("loginlamar");

    if (elseLamarBtn) {
        elseLamarBtn.addEventListener("click", function (e) {
            e.preventDefault();
            alert("Hanya Pencari Kerja yang bisa Melamar");
        });
    }

    if (loginLamarBtn) {
        loginLamarBtn.addEventListener("click", function (e) {
            e.preventDefault();
            alert("Tolong Login Dahulu sebelum melamar");
            window.location.href = "login.php";
        });
    }
});
