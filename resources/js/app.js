import "./bootstrap";
import "~resources/scss/app.scss";
import.meta.glob(["../img/**"]);
import * as bootstrap from "bootstrap";
import axios from "axios";

document.addEventListener("DOMContentLoaded", function () {
    const addressInput = document.getElementById("address");
    const suggestionsContainer = document.getElementById("suggestions");
    const submitButton = document.getElementById("submit");

    if (addressInput && suggestionsContainer && submitButton) {
        addressInput.addEventListener("input", function () {
            let query = this.value;

            if (query.length === 0) {
                submitButton.disabled = true;
            }

            if (timeout) clearTimeout(timeout);

            if (query.length >= 4) {
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

                                suggestion.addEventListener(
                                    "click",
                                    function (event) {
                                        event.preventDefault();
                                        addressInput.value = item.address;
                                        suggestionsContainer.innerHTML = "";
                                        submitButton.disabled = false;
                                    }
                                );

                                if (!response.data.some(data => data.address === query)) {
                                    submitButton.disabled = true;
                                }
                            });
                        })
                        .catch(function (error) {
                            console.error("Error during search:", error);
                        });
                }, 500);
            } else {
                suggestionsContainer.innerHTML = "";
            }
        });
    }

    const confirmModal = document.getElementById('confirmModal');
    if (confirmModal) {
        confirmModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const action = button.getAttribute('data-action');
            const form = document.getElementById('deleteForm');
            form.setAttribute('action', action);
        });
    }

    const deleteButton = document.getElementById('deleteButton');
    if (deleteButton) {
        deleteButton.addEventListener('click', function (e) {
            e.preventDefault();
            const form = document.getElementById('deleteForm');
            form.submit();
        });
    }

    const dropdown = document.getElementById('dropdown');
    const dropdownMenu = document.getElementById('dropdownMenu');
    const dropdownToggle = document.getElementById('dropdownToggle');

    if (dropdown && dropdownMenu && dropdownToggle) {
        dropdown.addEventListener('mouseenter', function () {
            dropdownMenu.classList.add('show');
            dropdownToggle.setAttribute('aria-expanded', 'true');
        });

        dropdown.addEventListener('mouseleave', function () {
            dropdownMenu.classList.remove('show');
            dropdownToggle.setAttribute('aria-expanded', 'false');
        });
    }
});
