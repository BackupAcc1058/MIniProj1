// validate-upload.js

document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('uploadForm') || document.querySelector('form');
    form.addEventListener('submit', function (e) {
        const maxSize = 5 * 1024 * 1024; // 5MB in bytes

        const files = [
            { input: document.getElementById('CV'), name: 'CV' },
            { input: document.getElementById('PF'), name: 'Portofolio' },
            { input: document.getElementById('LT'), name: 'Surat Pelamaran' }
        ];

        for (let file of files) {
            if (file.input && file.input.files.length > 0) {
                if (file.input.files[0].size > maxSize) {
                    alert(`${file.name} file must not exceed 5MB.`);
                    e.preventDefault();
                    return;
                }
            }
        }
    });
});
