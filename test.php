<?php
    include 'connect.php';

    $productQuery = "SELECT * FROM product";
    $products = $conn->query($productQuery);

    $specQuery = "SELECT * FROM specification";
    $specifications = $conn->query($specQuery);

    $valueQuery = "SELECT * FROM specificationvalue";
    $values = $conn->query($valueQuery);

    $categoryQuery = "SELECT * FROM productcategories";
    $categories = $conn->query($categoryQuery);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="css/styles.css">
    <script src="js/adminPage.js"></script>
</head>
<body>
    <!--Add Specification Modal-->
    <div class="modal fade" id="addSpecModal" tabindex="-1" aria-labelledby="addSpecModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="addSpecModalLabel">Add Specification</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form id="addSpecForm">
                <div class="mb-3">
                  <label for="specName" class="form-label">Specification Name</label>
                  <input type="text" class="form-control" id="specName" required>
                </div>
                <button type="submit" id="saveSpecButton" class="btn btn-primary">Add Specifiaction</button>
              </form>
            </div>
          </div>
        </div>
    </div>
    
    <!--Add Value Modal-->
    <div class="modal fade" id="addValueModal" tabindex="-1" aria-labelledby="addValueModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="addValueModalLabel">Add Value</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form id="addSpecForm">
                <div class="mb-3">
                  <label for="valueName" class="form-label">Value Name</label>
                  <input type="text" class="form-control" id="valueName" required>
                </div>
                <div class="mb-3">
                    <label for="stock" class="form-label">Stock</label>
                    <input type="text" class="form-control" id="stock" required>
                </div>
                <div class="mb-3 d-none">
                    <input type="text" class="form-control" id="specificationName" required>
                </div>
                <button type="submit" class="btn btn-primary" id="saveValueBtn">Add Value</button>
              </form>
            </div>
          </div>
        </div>
    </div>

    <!--Edit Modal-->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" id="editProductForm" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="productID" id="editProductID">
                        <div class="mb-3">
                            <label for="editProductName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="editProductName" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="editDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="editDescription" rows="3" name="description"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editCategory" class="form-label">Category</label>
                            <select class="form-select" id="editCategory" name="category"></select>
                        </div>
                        <div class="mb-3">
                            <label for="editProductImage" class="form-label">Product Image</label>
                            <input class="form-control" type="file" id="editProductImage" name="productImage">
                        </div>
                        <div class="mb-2">
                            <label for="editPrice" class="form-label">Price</label>
                            <div class="input-group">
                                <span class="input-group-text">Rs.</span>
                                <input type="text" class="form-control" id="editPrice" name="price">
                            </div>
                        </div>
                        <div class="mb-2">
                            <label for="editDiscountedPrice" class="form-label">Discounted Price</label>
                            <div class="input-group">
                                <span class="input-group-text">Rs.</span>
                                <input type="text" class="form-control" id="editDiscountedPrice" name="discountedPrice">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Specifications</label>
                            <div id="editSpecList" class="row gap-3"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <h2>Product Management</h2>
    <form method="POST" class="container" id="addProdForm" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" rows="3" name="description"></textarea>
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select class="form-select" aria-label="Default select example" name="category">
                
            <?php
                if (!$categories) {
                    error_log("Query Error: " . mysqli_error($conn));
                    echo "<option value=''>No categories available</option>";
                } else if (mysqli_num_rows($categories) > 0) {
                    while ($row = mysqli_fetch_assoc($categories)) {
                        $categoryID = htmlspecialchars($row['categoryID'], ENT_QUOTES, 'UTF-8');
                        $categoryName = htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8');
                        echo "<option value='{$categoryID}'>{$categoryName}</option>";
                    }
                } else {
                    echo "<option value=''>No categories available</option>";
                }                             
            ?>

            </select>
        </div>
        <div class="mb-3">
            <label for="formFile" class="form-label">Product Image</label>
            <input class="form-control" type="file" id="formFile" name="productImage">
        </div>
        <div class="mb-2">
            <label for="price" class="form-label">Price</label>
            <div class="input-group">
                <span class="input-group-text">0.00</span>
                <span class="input-group-text">Rs.</span>
                <input type="text" class="form-control" name="price" aria-label="Dollar amount (with dot and two decimal places)">
            </div>
        </div>
        <div class="mb-2">
            <label for="discountedPrice" class="form-label">Discount Price</label>
            <div class="input-group">
                <span class="input-group-text">0.00</span>
                <span class="input-group-text">Rs.</span>
                <input type="text" class="form-control" name="discountedPrice" aria-label="Dollar amount (with dot and two decimal places)">
            </div>
        </div>
        <div class="mb-2">
            <label for="" class="form-label">Specification</label>
            <button class="btn" id="addSpecBtn">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-square" viewBox="0 0 16 16">
                    <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                </svg>
            </button>
            <div class="mb-2 specificationsForm row gap-3" id="specList">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Add Product</button>
    </form>

    <div class="container my-5">
        <form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
        <div class="row my-5">
            <?php
                if (!$products) {
                    error_log("Query Error: " . mysqli_error($conn));
                    echo "<span>No Products Founnd!</span>";
                } else if (mysqli_num_rows($products) > 0) {
                    while ($row = mysqli_fetch_assoc($products)) {
                        $productID = htmlspecialchars($row['productID'], ENT_QUOTES, 'UTF-8');
                        $productName = htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8');
                        $description = htmlspecialchars($row['description'], ENT_QUOTES, 'UTF-8');
                        $categoryID = htmlspecialchars($row['categoryID'], ENT_QUOTES, 'UTF-8');

                        $categoryQuery = "SELECT * FROM productcategories WHERE categoryID = '$categoryID'";
                        $categoryResult = mysqli_query($conn, $categoryQuery);

                        if (!$categoryResult) {
                            error_log("Category Query Error: " . mysqli_error($conn));
                            $categoryName = "Unknown Category";
                        } else if (mysqli_num_rows($categoryResult) > 0) {
                            $categoryRow = mysqli_fetch_assoc($categoryResult);
                            $categoryID = htmlspecialchars($categoryRow['categoryID'], ENT_QUOTES, 'UTF-8');
                            $categoryName = htmlspecialchars($categoryRow['name'], ENT_QUOTES, 'UTF-8');
                        } else {
                            $categoryName = "Unknown Category";
                        }

                        $specificationQuery = "SELECT * FROM specification WHERE productID = '$productID'";
                        $specificationResult = mysqli_query($conn, $specificationQuery);

                        if (!$specificationResult) {
                            error_log("Specification Query Error: " . mysqli_error($conn));
                            $specifications = [];
                        } else {
                            $specifications = [];
                            while ($specRow = mysqli_fetch_assoc($specificationResult)) {
                                $specID = $specRow['specID'];
                                $specName = htmlspecialchars($specRow['specName'], ENT_QUOTES, 'UTF-8');

                                $valueQuery = "SELECT * FROM specificationValue WHERE specID = '$specID'";
                                $valueResult = mysqli_query($conn, $valueQuery);

                                $values = [];
                                if ($valueResult && mysqli_num_rows($valueResult) > 0) {
                                    while ($valueRow = mysqli_fetch_assoc($valueResult)) {
                                        $values[] = [
                                            'valueID' => $valueRow['valueID'],
                                            'specValue' => htmlspecialchars($valueRow['specValue'], ENT_QUOTES, 'UTF-8'),
                                            'stock' => intval($valueRow['stock']),
                                        ];
                                    }
                                }

                                $specifications[] = [
                                    'specID' => $specID,
                                    'specName' => $specName,
                                    'values' => $values,
                                ];
                            }
                        }

                        $picture = htmlspecialchars($row['picture'], ENT_QUOTES, 'UTF-8');
                        $price = htmlspecialchars($row['price'], ENT_QUOTES, 'UTF-8');
                        $discountedPrice = htmlspecialchars($row['discountedPrice'], ENT_QUOTES, 'UTF-8');
                        echo "
                            <div class='productCard col-lg-3 col-md-4 col-sm-6'>
                                <div class='adminCard'>
                                    <img src='" . htmlspecialchars($picture, ENT_QUOTES, 'UTF-8') . "' class='card-img-top' alt='Working boot' id='productImage'>
                                    <div class='card-body'>
                                        <h5 class='card-title name'>" . htmlspecialchars($productName, ENT_QUOTES, 'UTF-8') . "</h5>
                                        <p class='card-text description'>" . htmlspecialchars($description, ENT_QUOTES, 'UTF-8') . "</p>
                                        <p class='card-text price'>Rs. " . htmlspecialchars($price, ENT_QUOTES, 'UTF-8') . "</p>
                                        <p class='card-text discountedPrice'>Rs. " . htmlspecialchars($discountedPrice, ENT_QUOTES, 'UTF-8') . "</p>
                                        <p class='card-text category'>" . htmlspecialchars($categoryName, ENT_QUOTES, 'UTF-8') . "</p>
                        ";

                        if (!empty($specifications)) {
                            foreach ($specifications as $spec) {
                                echo "<p class='card-text specification'>" . htmlspecialchars($spec['specName'], ENT_QUOTES, 'UTF-8') . "</p>";
                                
                                if (!empty($spec['values'])) {
                                    foreach ($spec['values'] as $value) {
                                        echo "<p class='card-text mx-2 my-0 py-0 value'>" . htmlspecialchars($value['specValue'], ENT_QUOTES, 'UTF-8') . "</p>";
                                    }
                                } else {
                                    echo "<p class='card-text mx-2 my-0 py-0 value'>No values available</p>";
                                }
                            }
                        } else {
                            echo "<p class='card-text mx-2 my-0 py-0 value'>No specifications available</p>";
                        }

                        echo "
                                </div>
                                <ul class='list-group list-group-flush'>
                                    <li class='list-group-item center'><button class='btn' onclick='editProduct({$productID})'>Edit</button></li>
                                    <li class='list-group-item center'><button class='btn' onclick='deleteProduct({$productID})'>Delete</button></li>
                                </ul>
                            </div>
                        </div>
                        ";

                    }
                } else {
                    echo "<option value=''>No categories available</option>";
                }
                             
            ?>
        </div>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li class="page-item">
                    <a class="page-link">Previous</a>
                </li>
                <li class="page-item"><a class="page-link active" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Modify Modal -->
    <div class="modal fade" id="modifyModal" tabindex="-1" aria-labelledby="modifyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modifyModalLabel">Modify Record</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="modifyForm">
                        <input type="hidden" id="recordType" name="type">
                        <input type="hidden" id="recordId" name="id">
                        <div class="mb-3">
                            <label for="modalUsername" class="form-label">Username</label>
                            <input type="text" class="form-control" id="modalUsername" name="username">
                        </div>
                        <div class="mb-3" id="emailField">
                            <label for="modalEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="modalEmail" name="email">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submitModifyForm()">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Modal -->
    <div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="alertModalLabel">Alert</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="alertModalMessage">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="alertModalOkButton" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <script>
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
            // Fetch the product details from the server
            fetch(`getProductDetails.php?productID=${productID}`)
                .then(response => response.json())
                .then(data => {
                    // Populate the modal fields
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

                    // Populate specifications
                    const specList = document.getElementById('editSpecList');
                    specList.innerHTML = ''; // Clear existing specifications

                    // Render each specification with its values
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
                return; // Stop if no matching element is found
            }
            specDiv.remove();
        }

    </script>
</body>
</html>
