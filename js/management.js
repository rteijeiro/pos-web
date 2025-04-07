// Toggle dropdown menus
function toggleDropdown(id) {
    document.querySelectorAll('.dropdown-content').forEach(el => {
        if (el.id !== id) {
            el.style.display = 'none';
        }
    });
    const dropdown = document.getElementById(id);
    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
}

// Close dropdowns when clicking outside
window.onclick = function (e) {
    if (!e.target.matches('.dropbtn')) {
        document.querySelectorAll('.dropdown-content').forEach(el => {
            el.style.display = 'none';
        });
    }
};

// Show product list
function showProducts() {
    fetch('connection/controller.php?action=getProducts')
        .then(res => res.json())
        .then(products => {
            let html = `<h2>Product List</h2><table class='product-table'>
                        <thead><tr><th>Name</th><th>Category</th><th>Price</th></tr></thead><tbody>`;
            products.forEach(p => {
                html += `<tr><td>${p.name}</td><td>${p.category_name}</td><td>${parseFloat(p.price).toFixed(2)} €</td></tr>`;
            });
            html += '</tbody></table>';
            document.getElementById('main-section').innerHTML = html;
        });
}

// Show add product form
function showAddProductForm() {
    let html = `<div class="form-wrapper">
                <h2>Add Product</h2>
                <form id="add-product-form" enctype="multipart/form-data" method="POST" action="connection/add_product.php">
                    <label>Name:</label><input type="text" name="name" required><br>
                    <label>Price:</label><input type="number" step="0.01" name="price" required><br>
                    <label>Category:</label><select name="category_id" required>`;
    categories.forEach(cat => {
        html += `<option value="${cat.id}">${cat.name}</option>`;
    });
    html += `</select><br>
             <label>Image:</label><input type="file" name="img" accept="image/*" required><br>
             <button type="submit">Add Product</button>
             </form></div>`;

    document.getElementById('main-section').innerHTML = html;
}
