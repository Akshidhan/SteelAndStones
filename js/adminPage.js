document.addEventListener("DOMContentLoaded", () => {
    const alertModal = new bootstrap.Modal(document.getElementById('alertModal'));
    const alertMessageElement = document.getElementById('alertModalMessage');
    const alertOkButton = document.getElementById('alertModalOkButton');

    const navLinks = document.querySelectorAll('.nav-link[data-bs-toggle="tab"]');
    const lastActiveTab = sessionStorage.getItem('lastActiveTab');
    if (lastActiveTab) {
        const lastTab = document.querySelector(`.nav-link[href="${lastActiveTab}"]`);
        if (lastTab) lastTab.click();
    }

    navLinks.forEach(link => {
        link.addEventListener("click", () => {
            sessionStorage.setItem('lastPage', window.location.href);
        });
    });

    document.querySelectorAll('[data-bs-target="#modifyModal"]').forEach(button => {
        button.addEventListener('click', () => {
            const recordType = button.getAttribute('data-type');
            const recordId = button.getAttribute('data-id');
            const username = button.getAttribute('data-username');
            const email = button.getAttribute('data-email');

            document.getElementById('recordType').value = recordType;
            document.getElementById('recordId').value = recordId;
            document.getElementById('modalUsername').value = username;
            document.getElementById('modalEmail').value = email;

            const emailField = document.getElementById('emailField');
            emailField.style.display = recordType === 'admin' ? 'none' : 'block';
        });
    });

    window.showAlert = (message, reload = false) => {
        alertMessageElement.textContent = message;
        alertModal.show();

        alertOkButton.onclick = () => {
            if (reload) location.reload();
        };
    };
});

function sortTable(section, column) {
    location.href = `test.php?sort=${section}&column=${column}`;
}

function deleteRecord(type, id) {
    fetch('delete_record.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ type, id }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert(data.message, true);
        } else {
            showAlert(data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}

function submitModifyForm() {
    const form = document.getElementById('modifyForm');
    const formData = new FormData(form);

    fetch('modify_record.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert("Error: " + data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}

function clearSessionStorage() {
    sessionStorage.clear();
}

//Product codes

specifications = [];
        const specNameInput = document.getElementById('specName');
        const addSpecModal = new bootstrap.Modal(document.getElementById('addSpecModal'));
        
        const addValueModal = new bootstrap.Modal(document.getElementById('addValueModal'));
        const valueNameInput = document.getElementById('valueName');
        const stockInput = document.getElementById('stock');
        const specificationName = document.getElementById('specificationName');
        const addProductForm = document.getElementById('addProdForm');


        document.getElementById('addSpecBtn').addEventListener('click', function (event) {
            event.preventDefault();
            specNameInput.value = '';
            addSpecModal.show();
        });

        document.getElementById('saveSpecButton').addEventListener('click', function (event){
            event.preventDefault();
            specName = specNameInput.value;
            specifications.push({"specName": specName, "value": []})
            specList = document.getElementById('specList');
            rerenderSpecs();

            addSpecModal.hide();
        });

        
        document.getElementById('saveValueBtn').addEventListener('click', function(event){
            event.preventDefault();

            const specName = specificationName.value;
            const valueName = valueNameInput.value;
            const stock = parseInt(stockInput.value, 10);

            const spec = specifications.find(spec => spec.specName === specName);

            if (spec) {
                spec.value.push({ valueName, stock });

                valueNameInput.value = '';
                stockInput.value = '';
                addValueModal.hide();
                rerenderSpecs();
            } else {
                alert('Specification not found!');
            }
        });

        function removeSpec(name, event) {
            if(event){
                event.preventDefault();
            }
            specifications = specifications.filter(spec => spec.specName !== name);
            rerenderSpecs();
        }

        function addValue(name, event){
            if(event){
                event.preventDefault();
            }
            valueNameInput.value="";   
            stockInput.value="";
            specificationName.value = name;
            addValueModal.show();
        }

        function removeValue(specName, valName, event){
            debugger;
            if(event){
                event.preventDefault();
            }

            const spec = specifications.find(spec => spec.specName === specName);
            if (spec){
                specifications = specifications.filter(spec => spec.value.valueName !== valName);
            }

            rerenderSpecs();
        }

        function rerenderSpecs(){
            const specificationContainer = document.getElementById('specList');
            specificationContainer.innerHTML = "";

            specifications.forEach(spec => {
                const specDiv = document.createElement('div');
                specDiv.classList.add('specificationForm', 'col');

                const specNameSpan = document.createElement('span');
                specNameSpan.textContent = spec.specName;
                specDiv.appendChild(specNameSpan);

                const addValueBtn = document.createElement('button');
                addValueBtn.classList.add('addValueBtn', 'btn', 'd-inline');
                addValueBtn.onclick = function(event) {
                    addValue(spec.specName ,event);
                }
                addValueBtn.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-square" viewBox="0 0 16 16">
                    <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                </svg>
                `;
                specDiv.appendChild(addValueBtn);

                const removeSpecBtn = document.createElement('button');
                removeSpecBtn.classList.add('removeSpecBtn', 'btn', 'd-inline');
                removeSpecBtn.onclick = function(event) {
                    removeSpec(spec.specName, event);
                };
                removeSpecBtn.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash-square" viewBox="0 0 16 16">
                    <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                    <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8"/>
                </svg>
                `;
                specDiv.appendChild(removeSpecBtn);

                const valuesFormDiv = document.createElement('div');
                valuesFormDiv.classList.add('valuesForm', 'my-2');

                spec.value.forEach(val => {
                const valueDiv = document.createElement('div');
                valueDiv.classList.add('valueEntry');
                valueDiv.innerHTML = `${val.valueName} (Stock: ${val.stock})
                    <button class="removeValueBtn d-inline" onclick="removeValue(${spec.valueName}, ${val.valueName}, event)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash-square" viewBox="0 0 16 16">
                            <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                            <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8"/>
                        </svg>
                    </button>
                `;
                valuesFormDiv.appendChild(valueDiv);
                });

                specDiv.appendChild(valuesFormDiv);
                specificationContainer.appendChild(specDiv);
            });
        }

        addProductForm.addEventListener('submit', function (event) {
            event.preventDefault();

            const formData = new FormData(this);

            const specificationsJSON = JSON.stringify(specifications);
            formData.append('specifications', specificationsJSON);

            fetch('add_product.php', {
                method: 'POST',
                body: formData,
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Product added successfully:', data);
                    alert('Product added successfully!');
                })
                .catch(error => {
                    console.error('There was a problem with the submission:', error);
                    alert('Failed to add product. Please try again.', error);
                });
        });

        function editProduct(productID) {
            fetch(`getProductDetails.php?productID=${productID}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('editProductID').value = data.productID;
                    document.getElementById('editProductName').value = data.name;
                    document.getElementById('editDescription').value = data.description;
                    document.getElementById('editCategory').innerHTML = data.categories.map(category => `
                        <option value="${category.categoryID}" ${category.categoryID === data.categoryID ? 'selected' : ''}>
                            ${category.name}
                        </option>
                    `).join('');
                    document.getElementById('editPrice').value = data.price;
                    document.getElementById('editDiscountedPrice').value = data.discountedPrice;

                    const specList = document.getElementById('editSpecList');
                    specList.innerHTML = '';

                    data.specifications.forEach(spec => {
                        const specDiv = document.createElement('div');
                        specDiv.id = `spec-${spec.specID}`;
                        specDiv.classList.add('col', 'specificationForm');
                        specDiv.innerHTML = `
                            <input type="text" class="form-control mb-2" value="${spec.specName}" name="specifications[${spec.specID}][name]" placeholder="Specification Name">
                            <div class="specValues">
                                ${spec.values.map((value, index) => `
                                    <div class="d-flex align-items-center mb-1" id="value-${spec.specID}-${value.valueID}">
                                        <input type="text" class="form-control me-2" value="${value.specValue}" name="specifications[${spec.specID}][values][${value.valueID}][name]" placeholder="Value">
                                        <input type="number" class="form-control" value="${value.stock}" name="specifications[${spec.specID}][values][${value.valueID}][stock]" placeholder="Stock">
                                        <button type="button" class="btn btn-danger btn-sm ms-2" onclick="removeValue(${spec.specID}, ${value.valueID})">Remove Value</button>
                                    </div>
                                `).join('')}
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="addValueToSpec(${spec.specID})">Add New Value</button>
                            <button type="button" class="btn btn-danger btn-sm mt-2" onclick="removeSpec(${spec.specID})">Delete Specification</button>
                        `;
                        specList.appendChild(specDiv);
                    });

                    // Add a button to add a new specification
                    const addSpecBtn = document.createElement('button');
                    addSpecBtn.classList.add('btn', 'btn-outline-success', 'mt-3');
                    addSpecBtn.textContent = "Add New Specification";
                    addSpecBtn.onclick = (function(event){
                        event.preventDefault();
                        addSpec();
                    })
                    specList.appendChild(addSpecBtn);

                    // Show the modal
                    const editProductModal = new bootstrap.Modal(document.getElementById('editProductModal'));
                    editProductModal.show();
                })
                .catch(error => console.error('Error fetching product details:', error));
        }

        function addSpec() {
            const specList = document.getElementById('editSpecList');
            if (!specList) {
                console.error('Specification list container not found!');
                return;
            }

            const newSpecID = Date.now();

            const newSpecDiv = document.createElement('div');
            newSpecDiv.id = `spec-${newSpecID}`;
            newSpecDiv.classList.add('col', 'specificationForm', 'mb-3');

            newSpecDiv.innerHTML = `
                <input type="text" class="form-control mb-2" name="specifications[new-${newSpecID}][name]" placeholder="Specification Name">
                <div class="specValues">
                    <!-- Values will be added here dynamically -->
                </div>
                <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="addValueToSpec('new-${newSpecID}')">Add New Value</button>
                <button type="button" class="btn btn-danger btn-sm mt-2" onclick="removeSpec('new-${newSpecID}')">Delete Specification</button>
            `;

            specList.appendChild(newSpecDiv);
        }

        function addValueToSpec(specID) {
            // Find the appropriate container for the values
            const specDiv = specID === 'new' 
                ? document.querySelector('.specificationForm:last-child .specValues') 
                : document.querySelector(`#spec-${specID} .specValues`);
            
            if (!specDiv) {
                console.error(`Specification container not found for specID: ${specID}`);
                return; // Stop if no matching container is found
            }

            // Create a new value row
            const newValueDiv = document.createElement('div');
            newValueDiv.classList.add('d-flex', 'align-items-center', 'mb-1');
            const uniqueID = Date.now(); // Generate a unique ID for new values
            newValueDiv.id = `value-${specID}-${uniqueID}`;
            newValueDiv.innerHTML = `
                <input type="text" class="form-control me-2" name="specifications[${specID}][values][new-${uniqueID}][name]" placeholder="Value">
                <input type="number" class="form-control" name="specifications[${specID}][values][new-${uniqueID}][stock]" placeholder="Stock">
                <button type="button" class="btn btn-danger btn-sm ms-2" onclick="removeValue('${specID}', 'new-${uniqueID}')">Remove Value</button>
            `;
            specDiv.appendChild(newValueDiv);
        }

        // Function to remove a value from a specification
        function removeValue(specID, valueID) {
            const valueDiv = document.getElementById(`value-${specID}-${valueID}`);
            valueDiv.remove();
        }

        function removeSpec(specID) {
            const specDiv = document.querySelector(`#spec-${specID}`);
            if (!specDiv) {
                console.error(`Specification element not found for specID: ${specID}`);
                return;
            }
            specDiv.remove();
        }

        function saveProductChanges(event) {
            event.preventDefault();

            const productID = document.getElementById('editProductID').value;
            const productName = document.getElementById('editProductName').value;
            const description = document.getElementById('editDescription').value;
            const categoryID = document.getElementById('editCategory').value;
            const price = document.getElementById('editPrice').value;
            const discountedPrice = document.getElementById('editDiscountedPrice').value;

            const specifications = [];

            document.querySelectorAll('.specificationForm').forEach(spec => {
                const specID = spec.id.split('-')[1];
                const specNameElement = spec.querySelector(`input[name="specifications[${specID}][name]"]`);
                const specName = specNameElement ? specNameElement.value : null;
                
                const values = [];
                
                spec.querySelectorAll('.specValues > div').forEach(valueDiv => {
                    const valueID = valueDiv.id.split('-')[2];
                    
                    const valueNameElement = valueDiv.querySelector(`input[name="specifications[${specID}][values][${valueID}][name]"]`);
                    const valueName = valueNameElement ? valueNameElement.value : null;
                    
                    const stockElement = valueDiv.querySelector(`input[name="specifications[${specID}][values][${valueID}][stock]"]`);
                    const stock = stockElement ? stockElement.value : null;
                    
                    if (valueName !== null && stock !== null) {
                        values.push({ valueName, stock });
                    } else {
                        console.warn(`Missing data for specification value ID: ${valueID}`);
                    }
                });

                if (specName) {
                    specifications.push({ specName, values });
                } else {
                    console.warn(`Specification ID: ${specID} is missing name or values.`);
                }
            });

            // Prepare the payload
            const payload = {
                productID,
                name: productName,
                description,
                categoryID,
                price,
                discountedPrice,
                specifications, // Send the specifications without specID
            };

            // Send the updated data via fetch
            fetch('updateProductDetails.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(payload),
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Product details updated successfully!');
                        location.reload();
                    } else {
                        alert('Failed to update product details.');
                        console.error(data.error);
                    }
                })
                .catch(error => {
                    console.error('Error updating product details:', error);
                });
        }