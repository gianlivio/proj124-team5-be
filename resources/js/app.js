import "./bootstrap";
import "~resources/scss/app.scss";
import.meta.glob(["../img/**"]);
import * as bootstrap from "bootstrap";


document.addEventListener('DOMContentLoaded', function() {
    // Mostra il modale e imposta l'action da eliminare
    $('#confirmModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var action = button.data('action'); // Extract info from data-* attributes
        var modal = $(this);
        modal.find('#deleteButton').attr('href', action);
    });

    // Gestisce l'eliminazione
    $('#confirmModal').on('click', '#deleteButton', function(e) {
        e.preventDefault();
        window.location.href = $(this).attr('href');
    });
});