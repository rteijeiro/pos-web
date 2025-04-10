
if (!selectedMesa) {
    console.error("No se ha seleccionado ninguna mesa");
    //Redirect or handle the error
  }
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
                <img src="carta_seccion_3/${item.img}" alt="${item.name}" />
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
      markTableOccupied(selectedMesa); // Mark the table as occupied
      // Recover the saved order or initialize a new one
      let order = localStorage.getItem('mesa_' + selectedMesa);
      order = order ? JSON.parse(order) : [];
    
      if (existingRow) {
        let qtyCell = existingRow.cells[0];
        let totalCell = existingRow.cells[3];
        let newQty = parseInt(qtyCell.textContent) + 1;
        qtyCell.textContent = newQty;
        totalCell.textContent = (newQty * price).toFixed(2) + " €";
        
        // Update the product in the order object
        order = order.map(item => {
          if (item.name === name) {
            item.qty += 1;
            item.total = (item.qty * price);
          }
          return item;
        });
      } else {
        let row = tbody.insertRow();
row.innerHTML = `
    <td>1</td>
    <td>${name}</td>
    <td>${price.toFixed(2)} €</td>
    <td>${price.toFixed(2)} €</td>
    <td><button class="remove-btn" onclick="removeOrderRow(this)">X</button></td>
`;

        // Add new product to order
        order.push({ name, price, qty: 1, total: price });
      }
    
      // Save the updated order to localStorage
      localStorage.setItem('mesa_' + selectedMesa, JSON.stringify(order));
      calculateTotal();
    
    }
  
    function removeOrderRow(button) {
      const row = button.closest('tr');
      const name = row.cells[1].textContent;
      row.remove();
      calculateTotal();
      
      // Update the order in the localStorage
      let order = localStorage.getItem('mesa_' + selectedMesa);
      if (order) {
        order = JSON.parse(order).filter(item => item.name !== name);
        localStorage.setItem('mesa_' + selectedMesa, JSON.stringify(order));
      }
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
  
  function loadSavedOrder() {
      if (!selectedMesa) return;
  
      let order = localStorage.getItem('mesa_' + selectedMesa);
      if (!order) return;
  
      try {
          order = JSON.parse(order);
      } catch (e) {
          console.error("Error parseando el pedido:", e);
          order = [];
      }
      
      // Ensure that 'order' is an array
      if (!Array.isArray(order)) {
          order = [];
      }
  
      const tbody = document.getElementById("order-table-body");
      tbody.innerHTML = ""; // Clean the table before load
  
      order.forEach(item => {
          let row = tbody.insertRow();
          row.innerHTML = `
              <td>${item.qty}</td>
              <td>${item.name}</td>
              <td>${parseFloat(item.price).toFixed(2)} €</td>
              <td>${parseFloat(item.total).toFixed(2)} €</td>
              <td><button class="remove-btn" onclick="removeOrderRow(this)">X</button></td>
          `;
      });
  
      calculateTotal();
  }
  
  document.addEventListener("DOMContentLoaded", () => {
      loadSavedOrder();
  });
  function markTableOccupied(mesa) {
      localStorage.setItem('mesa_' + mesa + '_ocupada', 'true');
  }
  