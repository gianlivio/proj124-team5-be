import "./bootstrap";
import "~resources/scss/app.scss";
import.meta.glob(["../img/**"]);
import * as bootstrap from "bootstrap";

<<<<<<< HEAD
document.addEventListener("DOMContentLoaded", function () {
    const addressInput = document.getElementById("address");
    const suggestionsContainer = document.getElementById("suggestions");
    let lastQuery = "";
    let timeout;

    addressInput.addEventListener("input", function () {
        let query = this.value;
        console.log(`Query: ${query}, Last Query: ${lastQuery}`);
        if (query !== lastQuery && query.length >= 4) {
            
            timeout = setTimeout(function () {
                axios
                    .get("/api/autocomplete", {
                        params: {
                            query: query,
                        },
                    })
                    .then(function (response) {
                        suggestionsContainer.innerHTML = "";
                        response.data.forEach(function (item) {
                            let suggestion = document.createElement("a");
                            suggestion.href = "#";
                            suggestion.classList.add(
                                "list-group-item",
                                "list-group-item-action",
                                "suggestion-item"
                            );
                            suggestion.textContent = item.address;
                            suggestionsContainer.appendChild(suggestion);

                            suggestion.addEventListener("click", function () {
                                addressInput.value = item.address;
                                suggestionsContainer.innerHTML = "";
                                clearInterval(timeout);
                            });
=======
document.addEventListener('DOMContentLoaded', function() {
    const addressInput = document.getElementById('address');
    const suggestionsContainer = document.getElementById('suggestions');
    let timeout;

    addressInput.addEventListener('input', function() {
        let query = this.value;

        // Clear previous timeout to prevent multiple timeouts
        if (timeout) clearTimeout(timeout);

        if (query.length >= 4) {
            timeout = setTimeout(function() {
                axios.get('/api/autocomplete', {
                    params: {
                        query: query
                    }
                })
                .then(function(response) {
                    suggestionsContainer.innerHTML = '';
                    response.data.forEach(function(item) {
                        let suggestion = document.createElement('a');
                        suggestion.href = '#';
                        suggestion.classList.add('list-group-item', 'list-group-item-action', 'suggestion-item');
                        suggestion.textContent = item.address;
                        suggestionsContainer.appendChild(suggestion);

                        suggestion.addEventListener('click', function(event) {
                            event.preventDefault();
                            addressInput.value = item.address;
                            suggestionsContainer.innerHTML = '';
>>>>>>> origin/test-js-function
                        });
                    })
                    .catch(function (error) {
                        console.error("Errore durante la ricerca:", error);
                    });
<<<<<<< HEAD
                lastQuery = query;
            }, 500);
=======
                })
                .catch(function(error) {
                    console.error('Error during search:', error);
                    // Optionally display an error message to the user
                });
            }, 500); // Debounce time in milliseconds
>>>>>>> origin/test-js-function
        } else {
            suggestionsContainer.innerHTML = "";
        }
    });

<<<<<<< HEAD
    // Mostra il modale e imposta l'action da eliminare
    $("#confirmModal").on("show.bs.modal", function (event) {
        var button = $(event.relatedTarget);
        var action = button.data("action");
=======
    // Show modal and set the action to be deleted
    $('#confirmModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); 
        var action = button.data('action');
>>>>>>> origin/test-js-function
        var modal = $(this);
        modal.find("#deleteButton").attr("href", action);
    });

<<<<<<< HEAD
    // Gestisce l'eliminazione
    $("#confirmModal").on("click", "#deleteButton", function (e) {
=======
    // Handle deletion
    $('#confirmModal').on('click', '#deleteButton', function(e) {
>>>>>>> origin/test-js-function
        e.preventDefault();
        window.location.href = $(this).attr("href");
    });
});
