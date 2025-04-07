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

 // Function to get the total updated from the page
function getTotalPrice() {
  return parseFloat(
    document.getElementById("total-amount").textContent.replace("€", "").trim()
  );
}

let calcInput = "";

function addToCalc(val) {
  if (val === '%' || val === '€') return;
  calcInput += val;
  document.getElementById("calc-display").value = calcInput;
}

function setDiscount(type) {
  if (type === '%') {
    calcInput += '%';
  } else if (type === '€') {
    calcInput += '€';
  }
  document.getElementById("calc-display").value = calcInput;
}

function clearCalc() {
  calcInput = "";
  document.getElementById("calc-display").value = "";
}

function applyToTotal() {
  try {
    let totalPrice = getTotalPrice(); // Get the updated total price from the page
    let newTotal = totalPrice;

    // Apply percentage discount
    if (calcInput.includes('%')) {
      const discountPercent = parseFloat(calcInput.replace('%', '')) / 100;
      newTotal = totalPrice - totalPrice * discountPercent;
    } 
    // Apply fixed discount in euros
    else if (calcInput.includes('€')) {
      const discountEuro = parseFloat(calcInput.replace('€', ''));
      newTotal = totalPrice - discountEuro;
    } 
    // If it is not a percentage or euro, we treat it as a direct price
    else {
      newTotal = parseFloat(calcInput);
      if (isNaN(newTotal)) throw new Error("Invalid number");
    }

    // Validate that the new total is a valid number and is not negative
    if (isNaN(newTotal)) throw new Error("Invalid operation");
    if (newTotal < 0) newTotal = 0;  // Do not allow negative values

    // Update the total on the page
    document.getElementById("total-amount").textContent = newTotal.toFixed(2) + " €";

    // Clean the calculator
    clearCalc();
  } catch (e) {
    alert("Operación inválida");
    clearCalc();
  }
}
