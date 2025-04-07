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

// Show users list
let selectedUserName = null;

function showUsers() {
    fetch('connection/controller.php?action=getAllUser')
        .then(res => res.json())
        .then(users => {
            let html = `
            <div class="user-list-section">
                <h2 style="text-align: center;">User List</h2>
                <div class="user-list-wrapper">`;

            users.forEach(user => {
                html += `
                    <div class="user-card" onclick="selectUser(this, '${user.name}')">
                        <img src="images/app/${user.img}" alt="${user.name}">
                        <div><strong>${user.name}</strong></div>
                    </div>`;
            });

            html += `
                </div>
                <div style="text-align: center; margin-top: 20px;">
                    <button onclick="deleteSelectedUser()" class="delete-user-btn">Delete Selected User</button>
                </div>
            </div>`;

            document.getElementById('main-section').innerHTML = html;
        });
}

function selectUser(element, name) {
    document.querySelectorAll('.user-card').forEach(card => {
        card.classList.remove('selected-user');
    });
    element.classList.add('selected-user');
    selectedUserName = name;
}

function deleteSelectedUser() {
    if (!selectedUserName) {
        alert('Please select a user to delete.');
        return;
    }

    if (confirm(`Are you sure you want to delete user: ${selectedUserName}?`)) {
        fetch('connection/controller.php?action=deleteUser', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ name: selectedUserName })
        })
        .then(res => res.json())
        .then(response => {
            if (response.success) {
                alert('User deleted successfully!');
                showUsers(); // Refresh
            } else {
                alert('Error deleting user.');
            }
        });
    }
}



function showProducts() {
    fetch('connection/controller.php?action=getProducts')
        .then(res => res.json())
        .then(products => {
            let html = `<h2 class="section-title">Product List</h2>
                        <table class='product-table'>
                        <thead><tr>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr></thead><tbody>`;

            products.forEach(p => {
                html += `<tr>
                            <td>${p.name}</td>
                            <td>${p.category_name}</td>
                            <td>${parseFloat(p.price).toFixed(2)} €</td>
                            <td>
                                <button class="delete-btn" onclick="deleteProduct('${p.name}')">Delete</button>
                            </td>
                         </tr>`;
            });

            html += '</tbody></table>';
            document.getElementById('main-section').innerHTML = html;
        });
}

// Delete product by name
function deleteProduct(name) {
    if (confirm(`Are you sure you want to delete "${name}"?`)) {
        fetch(`connection/controller.php?action=deleteProduct&name=${encodeURIComponent(name)}`)
            .then(res => res.json())
            .then(response => {
                if (response.success) {
                    alert("Product deleted successfully.");
                    showProducts(); // Refresh product list
                } else {
                    alert("Error deleting product.");
                }
            });
    }
}


// add products
function showAddProductForm() {
    let html = `
        <div class="form-wrapper" style="text-align: center;">
            <h2 style="margin-bottom: 20px;">Add Product</h2>
            <form id="add-product-form" enctype="multipart/form-data" method="POST">
                <label>Name:</label><br>
                <input type="text" name="name" required><br><br>
                
                <label>Price:</label><br>
                <input type="number" step="0.01" name="price" required><br><br>
                
                <label>Category:</label><br>
                <select name="category_id" required>`;
    
    categories.forEach(cat => {
        html += `<option value="${cat.id}">${cat.name}</option>`;
    });

    html += `</select><br><br>
             <label>Image:</label><br>
             <input type="file" name="img" accept="image/*" required><br><br>
             <button type="submit">Add Product</button>
            </form>
        </div>`;

    document.getElementById('main-section').innerHTML = html;

    // Attach event after DOM insertion
    const form = document.getElementById('add-product-form');
    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        const formData = new FormData(form);
        try {
            const response = await fetch('connection/controller.php?action=addProduct', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();
            if (result.success) {
                alert('Product added successfully!');
                showProducts(); // Refresh product list
            } else {
                alert('Error: ' + (result.message || 'Something went wrong.'));
            }
        } catch (err) {
            alert('Unexpected error: ' + err.message);
        }
    });
}
