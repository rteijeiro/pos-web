// calculator.js
let calcDisplay = document.getElementById('calc-display');

function addToCalc(value) {
    calcDisplay.value += value;
}

function calculate() {
    try {
        calcDisplay.value = eval(calcDisplay.value).toFixed(2);
    } catch (error) {
        calcDisplay.value = 'Error';
    }
}

function clearCalc() {
    calcDisplay.value = '';
}

function applyToTotal() {
    const currentTotal = parseFloat(document.getElementById('total-amount').textContent.replace(' €', ''));
    const calcValue = parseFloat(calcDisplay.value) || 0;
    document.getElementById('total-amount').textContent = (currentTotal - calcValue).toFixed(2) + ' €';
    clearCalc();
}