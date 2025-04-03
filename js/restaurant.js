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
                <div>${item.price.toFixed(2)} €</div>
            `;
            div.onclick = () => addToOrder(item.name, item.price);
            productsContainer.appendChild(div);
        });

        productsContainer.style.display = 'flex';
    } catch (error) {
        console.error("Error cargando productos:", error);
    }
}

function addToOrder(name, price) {
    const orderList = document.getElementById("order-list");
    let itemExistente = Array.from(orderList.children).find(item =>
        item.querySelector(".order-name").textContent === name
    );

    if (itemExistente) {
        const cantidad = itemExistente.querySelector(".order-quantity");
        const total = itemExistente.querySelector(".order-total");
        const nuevaCantidad = parseInt(cantidad.textContent) + 1;
        cantidad.textContent = nuevaCantidad;
        total.textContent = (nuevaCantidad * price).toFixed(2) + " €";
    } else {
        const div = document.createElement("div");
        div.className = "order-item";
        div.innerHTML = `
            <span class="order-quantity">1</span>
            <span class="order-name">${name}</span>
            <span class="order-total">${price.toFixed(2)} €</span>
            <button class="remove-btn" onclick="removeOrderItem(this)">X</button>
        `;
        orderList.appendChild(div);
    }
    calculateTotal();
}

function calculateTotal() {
    const totales = Array.from(document.querySelectorAll(".order-total"))
        .reduce((sum, item) => sum + parseFloat(item.textContent.replace(' €', '')), 0);
    document.getElementById("total-amount").textContent =
        totales.toFixed(2) + " €";
}


function removeOrderItem(button) {
    const item = button.closest('.order-item');
    item.remove();
    calculateTotal(); 
}