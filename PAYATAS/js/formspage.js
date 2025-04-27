function clearForm() {
    document.querySelectorAll('input, textarea, select').forEach(element => {
        if (element.type !== 'file') {
            element.value = '';
        }
    });
    document.getElementById('declaration').checked = false;
    document.getElementById('preview').style.display = 'none';
}

function submitForm() {
    alert("Form submitted successfully!");
}

function previewFile() {
    const file = document.getElementById('file').files[0];
    const preview = document.getElementById('preview');
    if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
            preview.src = event.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
}

