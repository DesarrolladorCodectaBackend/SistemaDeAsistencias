

        function toggleCheckbox(event, id, type) {
            if (event.target.tagName !== 'INPUT') {
                const checkbox = document.getElementById(id);
                checkbox.checked = !checkbox.checked;
                if (type.includes("update")) {
                    updateSubmitButton(type);
                } else if (type.includes("store")) {
                    updateStoreSubmitButton();
                }
            }
            uncheckOthers(id, type);
        }

        function uncheckOthers(id, type) {
            const checkboxes = document.querySelectorAll(`.horario-checkbox-${type}`);
            checkboxes.forEach(checkbox => {
                if (checkbox.id !== id) {
                    checkbox.checked = false;
                }
            });
        }

        function updateSubmitButton(type) {
            const checkboxes = document.querySelectorAll(`.horario-checkbox-${type}`);
            const submitButton = document.getElementById(`submit-button-${type}`);
            let isAnyChecked = false;
            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    isAnyChecked = true;
                }
            });
            submitButton.disabled = !isAnyChecked;
        }

        function updateStoreSubmitButton() {
            const formContainers = document.querySelectorAll('.storeForm');
            let allFormsValid = true;

            formContainers.forEach(container => {
                const checkboxes = container.querySelectorAll('input[type="checkbox"]');
                let isAnyChecked = false;
                checkboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        isAnyChecked = true;
                    }
                });
                if (!isAnyChecked) {
                    allFormsValid = false;
                }
            });

            const submitButton = document.getElementById('submit-store-button');
            submitButton.disabled = !allFormsValid;
        }

        let formCounter = 1;

        function addNewForm() {
            const originalForm = document.querySelector('.storeForm');
            const newForm = originalForm.cloneNode(true);

            const formIndex = formCounter++;

            newForm.querySelectorAll('input[type="checkbox"]').forEach((checkbox, index) => {
                checkbox.checked = false;
                checkbox.classList.remove(`horario-checkbox-store-0`);
                checkbox.classList.add(`horario-checkbox-store-${formIndex}`);
                checkbox.id = checkbox.id.replace('-0', `-${formIndex}`);
            });

            newForm.querySelectorAll('.product-box').forEach((box, index) => {
                const horarioId = box.querySelector('input[type="checkbox"]').value;
                box.setAttribute('onclick', `toggleCheckbox(event, 'checkbox-store-${horarioId}-${formIndex}', 'store-${formIndex}')`);
            });

            newForm.setAttribute('data-form-index', formIndex);

            const deleteButton = document.createElement('button');
            deleteButton.type = 'button';
            deleteButton.className = 'btn btn-danger btn-sm';
            deleteButton.textContent = 'Eliminar';
            deleteButton.setAttribute('onclick', 'removeForm(this)');
            newForm.prepend(deleteButton);

            document.querySelector('#storeFormContainer').appendChild(newForm);

            updateStoreSubmitButton();

        }

        function removeForm(button) {
            const formContainer = button.closest('.storeForm');
            formContainer.remove();
        }



