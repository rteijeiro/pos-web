let selectedMesa = null;

function openModal(mesa) {
    selectedMesa = mesa;
    document.getElementById('mesaModal').style.display = 'flex';
    document.getElementById('comensalesInput').focus();
}

function appendNumber(num) {
    document.getElementById('comensalesInput').value += num;
}

function clearInput() {
    document.getElementById('comensalesInput').value = '';
}

function confirmMesa() {
    const comensales = document.getElementById('comensalesInput').value;
    if (comensales === '') {
        alert('Introduce un número de comensales');
        return;
    }
    const usuario = new URLSearchParams(window.location.search).get('users');
    window.location.href = `restaurant.php?mesa=${selectedMesa}&user=${encodeURIComponent(usuario)}&comensales=${comensales}`;
}

// Close modal when clicking outside
window.addEventListener('click', function (event) {
    const modal = document.getElementById('mesaModal');
    if (event.target === modal) {
        modal.style.display = 'none';
        clearInput();
    }
});

// Keyboard support: numbers, Backspace, Enter
document.addEventListener('keydown', function (event) {
    const modal = document.getElementById('mesaModal');
    const input = document.getElementById('comensalesInput');

    if (modal.style.display === 'flex') {
        if (event.key >= '0' && event.key <= '9') {
            appendNumber(event.key);
        } else if (event.key === 'Backspace') {
            input.value = input.value.slice(0, -1);
            event.preventDefault(); // prevent browser back
        } else if (event.key === 'Enter') {
            confirmMesa();
        } else if (event.key === 'Escape') {
            modal.style.display = 'none';
            clearInput();
        }
    }
});
