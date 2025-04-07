let selectedMesa = null;

function openModal(mesa) {
    selectedMesa = mesa;
    const savedOrder = localStorage.getItem('mesa_' + mesa);
    
    if (savedOrder) {
        const usuario = new URLSearchParams(window.location.search).get("users");
        window.location.href = `restaurant.php?mesa=${mesa}&user=${encodeURIComponent(usuario)}&comensales=0`;
    } else {
        document.getElementById("mesaModal").style.display = "flex";
        document.getElementById("comensalesInput").focus();
    }
}

function appendNumber(num) {
    document.getElementById("comensalesInput").value += num;
}

function clearInput() {
    document.getElementById("comensalesInput").value = "";
}

function confirmMesa() {
    const comensales = document.getElementById("comensalesInput").value;
    if (comensales === "") {
        alert("Introduce un número de comensales");
        return;
    }
    const usuario = new URLSearchParams(window.location.search).get("users");
    window.location.href = `restaurant.php?mesa=${selectedMesa}&user=${encodeURIComponent(usuario)}&comensales=${comensales}`;
}

// Close modal when clicking outside
window.addEventListener("click", function (event) {
    const modal = document.getElementById("mesaModal");
    if (event.target === modal) {
      modal.style.display = "none";
      clearInput();
    }
  });

// Event listeners
window.addEventListener("click", function(event) {
    const modal = document.getElementById("mesaModal");
    if (event.target === modal) {
        modal.style.display = "none";
        clearInput();
    }
});

document.addEventListener("keydown", function(event) {
    const modal = document.getElementById("mesaModal");
    const input = document.getElementById("comensalesInput");

    if (modal.style.display === "flex") {
        if (event.key >= "0" && event.key <= "9") {
            appendNumber(event.key);
        } else if (event.key === "Backspace") {
            input.value = input.value.slice(0, -1);
            event.preventDefault();
        } else if (event.key === "Enter") {
            confirmMesa();
        } else if (event.key === "Escape") {
            modal.style.display = "none";
            clearInput();
        }
    }
});

document.addEventListener("DOMContentLoaded", () => {
    const mesas = document.querySelectorAll(".mesa-link");
    
    mesas.forEach(mesaEl => {
        const mesaId = mesaEl.getAttribute("data-mesa");
        const isOccupied = localStorage.getItem('mesa_' + mesaId + '_ocupada') === 'true';

        // Update class according to status
        if (isOccupied) {
            mesaEl.classList.add("ocupada");
        } else {
            mesaEl.classList.remove("ocupada"); // Make sure to remove the class if it is not busy
        }

        mesaEl.onclick = function() {
            if (isOccupied) {
                const usuario = new URLSearchParams(window.location.search).get("users");
                window.location.href = `restaurant.php?mesa=${mesaId}&user=${encodeURIComponent(usuario)}&comensales=0`;
            } else {
                openModal(mesaId);
            }
        };
    });
});