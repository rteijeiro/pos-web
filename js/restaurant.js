async function loadProducts(categoryId) {
    try {
        const response = await fetch(`connection/controller.php?action=getProducts&category_id=${categoryId}`);
        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
        const products = await response.json();

        const productsContainer = document.getElementById('products-container');
        productsContainer.innerHTML = "";

        products.forEach(item => {
            const div = document.createElement("div");
            div.className = "item";
            div.innerHTML = `
                <div>${item.name}</div>
                <div>${parseFloat(item.price).toFixed(2)} €</div>
            `;
            div.onclick = () => addToOrder(item.name, parseFloat(item.price));
            productsContainer.appendChild(div);
        });

        productsContainer.style.display = 'flex';
    } catch (error) {
        console.error("Error cargando productos:", error);
    }
}

function addToOrder(name, price) {
    const tbody = document.getElementById("order-table-body");
    let existingRow = Array.from(tbody.rows).find(row =>
        row.cells[1].textContent === name
    );

    if (existingRow) {
        let qtyCell = existingRow.cells[0];
        let totalCell = existingRow.cells[3];
        let newQty = parseInt(qtyCell.textContent) + 1;
        qtyCell.textContent = newQty;
        totalCell.textContent = (newQty * price).toFixed(2) + " €";
    } else {
        let row = tbody.insertRow();
        row.innerHTML = `
            <td>1</td>
            <td>${name}</td>
            <td>${price.toFixed(2)} €</td>
            <td>${price.toFixed(2)} €</td>
            <td><button class="remove-btn" onclick="removeOrderRow(this)">X</button></td>
        `;
    }

    calculateTotal();
}

function removeOrderRow(button) {
    const row = button.closest('tr');
    row.remove();
    calculateTotal();
}

function calculateTotal() {
    const rows = document.querySelectorAll("#order-table-body tr");
    let total = 0;
    rows.forEach(row => {
        const cell = row.cells[3];
        if (cell) {
            total += parseFloat(cell.textContent.replace(" €", ""));
        }
    });
    document.getElementById("total-amount").textContent = total.toFixed(2) + " €";
}


function removeOrderItem(button) {
    const item = button.closest('.order-item');
    item.remove();
    calculateTotal();
}
