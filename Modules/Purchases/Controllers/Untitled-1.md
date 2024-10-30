https://blog.alfauzikri.my.id/Admin-Template-and-UI-Kit/


<script>
document.addEventListener('DOMContentLoaded', function() {
    const productNameInput = document.getElementById('product_name');
    const productSuggestions = document.getElementById('product_suggestions');
    const productTableBody = document.getElementById('product_table_body');
    const totalAmountDisplay = document.getElementById('total_amount_display');
    const paidAmountField = document.getElementById('paid_amount');
    const remainingAmountDisplay = document.getElementById('remaining_amount_display');
    const totalAmountField = document.querySelector('input[name="total_amount"]');
    const remainingAmountField = document.querySelector('input[name="remaining_amount"]');
    const referenceNoInput = document.getElementById('reference_no');
    const form = document.getElementById('purchase-add');

    // Fetch purchase order number on page load
    fetchPurchaseOrderNumber();

    function fetchPurchaseOrderNumber() {
        fetch('<?= site_url(route_to('purchases.generate_purchase_order_number')) ?>')
            .then(response => response.json())
            .then(data => {
                console.log('Purchase Order Number:', data.reference_no);
                referenceNoInput.value = data.reference_no;
            })
            .catch(error => {
                console.error('Error fetching purchase order number:', error);
            });
    }

    productNameInput.addEventListener('input', function() {
        const query = this.value.trim();
        if (query.length < 2) {
            productSuggestions.innerHTML = '';
            return;
        }

        // AJAX request to fetch product suggestions
        fetch('<?= site_url(route_to('purchases.search')) ?>?query=' + encodeURIComponent(query))
            .then(response => response.json())
            .then(data => {
                console.log('Product Suggestions:', data);

                let suggestions = '';
                if (data.length > 0) {
                    data.forEach(product => {
                        suggestions +=
                            `<button type="button" class="list-group-item list-group-item-action" data-product='${JSON.stringify(product)}'>${product.variation_product_name ? product.variation_product_name : product.product_name}</button>`;
                    });
                } else {
                    suggestions = '<div class="list-group-item">No result</div>';
                }
                productSuggestions.innerHTML = suggestions;
            })
            .catch(error => {
                console.error('Error fetching product suggestions:', error);
            });
    });

    // Handle product suggestion click
    productSuggestions.addEventListener('click', function(e) {
        if (e.target.classList.contains('list-group-item') && e.target.getAttribute('data-product')) {
            const product = JSON.parse(e.target.getAttribute('data-product'));
            addProductToTable(product);
            productNameInput.value = '';
            productSuggestions.innerHTML = '';
        }
    });

    form.addEventListener('submit', function(event) {
        if (!validateProductTable()) {
            event.preventDefault();
        }
    });

    // Function to add product to the table
    function addProductToTable(product) {
        const productId = product.id || product.product_id;
        const productName = product.variation_product_name || product.product_name;
        const productPrice = parseFloat(product.buying_price || product.variation_buying_price || 0);
        const manufactureDate = '';
        const expiryDate = '';

        // Check if the product is already added
        const existingProduct = Array.from(productTableBody.querySelectorAll('tr')).find(row => {
            const existingProductId = row.querySelector('input[name*="[product_id]"]').value;
            return existingProductId === `${productId}`;
        });

        if (existingProduct) {
            alert('This product is already added.');
            return;
        }

        const row = document.createElement('tr');
        const displayProductName = productName.toLowerCase();

        row.innerHTML = `
            <td><input type="hidden" name="products[${productId}][product_id]" value="${productId}" /> ${displayProductName}</td>
            <td>
                <input type="number" name="products[${productId}][quantity]" value="1" min="1" class="form-control quantity-input" />
                <span class="text-danger mt-2 error-message"></span>
            </td>
            <td>
                <input type="number" name="products[${productId}][price]" value="${productPrice}" class="form-control price-input" />
                <span class="text-danger mt-2 error-message"></span>
            </td>
            <td>
                <input type="date" name="products[${productId}][manufacture_date]" value="${manufactureDate}" class="form-control manufacture-date-input" />
                <span class="text-danger mt-2 error-message"></span>
            </td>
            <td>
                <input type="date" name="products[${productId}][expiry_date]" value="${expiryDate}" class="form-control expiry-date-input" />
                <span class="text-danger mt-2 error-message"></span>
            </td>
            <td class="total">${productPrice.toFixed(2)}</td>
            <td><button type="button" class="btn btn-danger btn-sm remove-product">Remove</button></td>
            <input type="hidden" name="products[${productId}][variation_id]" value="${product.variation_id || ''}" />
            <input type="hidden" name="products[${productId}][variation_value_id]" value="${product.variation_value_id || ''}" />
        `;

        productTableBody.appendChild(row);

        row.querySelectorAll('input').forEach(input => {
            input.addEventListener('input', function() {
                if (validateProductRow(row)) {
                    clearValidationError(input);
                }
                updateRowTotal.call(input);
            });
        });

        row.querySelector('.remove-product').addEventListener('click', function() {
            row.remove();
            updateTotalAmount();
        });

        if (!validateProductRow(row)) {
            return;
        }

        updateTotalAmount();
    }

    // Function to validate a product row
    function validateProductRow(row) {
        let isValid = true;

        const quantityInput = row.querySelector('.quantity-input');
        const manufactureDateInput = row.querySelector('.manufacture-date-input');
        const expiryDateInput = row.querySelector('.expiry-date-input');

        if (quantityInput.value <= 0) {
            displayValidationError(quantityInput, 'Quantity must be greater than 0.');
            isValid = false;
        } else {
            clearValidationError(quantityInput);
        }

        const manufactureDate = new Date(manufactureDateInput.value);
        const expiryDate = new Date(expiryDateInput.value);

        if (manufactureDate > expiryDate) {
            displayValidationError(manufactureDateInput, 'Manufacture date must be before the expiry date.');
            displayValidationError(expiryDateInput, 'Expiry date must be after the manufacture date.');
            isValid = false;
        } else {
            clearValidationError(manufactureDateInput);
            clearValidationError(expiryDateInput);
        }

        return isValid;
    }

    // Function to validate the entire product table
    function validateProductTable() {
        let isValid = true;
        const productRows = productTableBody.querySelectorAll('tr');

        if (productRows.length === 0) {
            alert('Please add at least one product.');
        }

        productRows.forEach(row => {
            if (!validateProductRow(row)) {
                isValid = false;
            }
        });

        const totalAmount = parseFloat(totalAmountField.value) || 0;
        const paidAmount = parseFloat(paidAmountField.value) || 0;

        if (paidAmount > totalAmount) {
            displayValidationError(paidAmountField, 'Paid amount cannot be greater than the total amount.');
            isValid = false;
        } else {
            clearValidationError(paidAmountField);
        }

        return isValid;
    }

    // Function to display validation error messages dynamically
    function displayValidationError(element, message) {
        const errorElement = element.closest('td').querySelector('.error-message');
        if (errorElement) {
            errorElement.textContent = message;
        } else {
            const errorMessage = document.createElement('span');
            errorMessage.classList.add('text-danger', 'mt-2', 'error-message');
            errorMessage.textContent = message;
            element.closest('td').appendChild(errorMessage);
        }
    }

    // Function to clear validation error messages
    function clearValidationError(element) {
        const errorElement = element.closest('td').querySelector('.error-message');
        if (errorElement) {
            errorElement.textContent = '';
        }
    }

    // Function to update row total amount
    function updateRowTotal() {
        const row = this.closest('tr');
        const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
        const price = parseFloat(row.querySelector('.price-input').value) || 0;
        const total = quantity * price;
        row.querySelector('.total').textContent = total.toFixed(2);
        updateTotalAmount();
    }

    // Function to update total amount of all products
    function updateTotalAmount() {
        let totalAmount = 0;
        productTableBody.querySelectorAll('tr').forEach(row => {
            const total = parseFloat(row.querySelector('.total').textContent) || 0;
            totalAmount += total;
        });

        totalAmountDisplay.value = totalAmount.toFixed(2);
        totalAmountField.value = totalAmount.toFixed(2);
        updateRemainingAmount();
    }

    // Function to update remaining amount after paid amount change
    function updateRemainingAmount() {
        const paidAmount = parseFloat(paidAmountField.value) || 0;
        const totalAmount = parseFloat(totalAmountField.value) || 0;
        const remainingAmount = totalAmount - paidAmount;

        remainingAmountDisplay.value = remainingAmount.toFixed(2);
        remainingAmountField.value = remainingAmount.toFixed(2);
    }

    // Event listener for paid amount field input
    paidAmountField.addEventListener('input', function() {
        if (paidAmountField.value > parseFloat(totalAmountField.value) || 0) {
            displayValidationError(paidAmountField,
                'Paid amount cannot be greater than the total amount.');
        } else {
            clearValidationError(paidAmountField);
        }
        updateRemainingAmount();
    });

    // Set default value for paid amount
    paidAmountField.value = '0';
});
</script>