import "./bootstrap";
import "~resources/scss/app.scss";
import.meta.glob(["../img/**"]);
import * as bootstrap from "bootstrap";

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
                        });
                    });
                })
                .catch(function(error) {
                    console.error('Error during search:', error);
                    // Optionally display an error message to the user
                });
            }, 500); // Debounce time in milliseconds
        } else {
            suggestionsContainer.innerHTML = '';
        }
    });

    // Show modal and set the action to be deleted
    $('#confirmModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); 
        var action = button.data('action');
        var modal = $(this);
        modal.find('#deleteButton').attr('href', action);
    });

    // Handle deletion
    $('#confirmModal').on('click', '#deleteButton', function(e) {
        e.preventDefault();
        window.location.href = $(this).attr('href');
    });
});
