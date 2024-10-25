document.addEventListener("DOMContentLoaded", function (event) {
    $(".datatable").DataTable({
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        language: {
            url: '/assets/js/pages/datatable-es-ES.json',
        }
    }).buttons().container().appendTo("#button_container");
});