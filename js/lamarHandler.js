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
        });
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const btnLamar = document.getElementById('btnlamar');

    if (btnLamar) {
        btnLamar.addEventListener('click', (e) => {
            if (typeof sudahMelamar !== 'undefined' && sudahMelamar) {
                e.preventDefault();
                alert('Anda sudah pernah melamar di lowongan ini.');
            }
        });
    }
});