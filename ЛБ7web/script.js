var display = document.getElementById('display');
var memory = 0;
var isOn = true;

function appendNumber(num) {
    if (isOn) display.value += num;
}

function appendOperator(operator) {
    if (isOn) display.value += operator;
}

function clearAll() {
    display.value = '';
}

function backspace() {
    if (isOn) display.value = display.value.slice(0, -1);
}

function calculate(operation) {
    if (!isOn) return;
    let value = parseFloat(display.value);
    switch (operation) {
        case 'sqrt':
            display.value = Math.sqrt(value);
            break;
        case '%':
            display.value = value / 100;
            break;
        default:
            break;
    }
}

function calculateResult() {
    if (isOn) {
        try {
            display.value = eval(display.value);
        } catch {
            display.value = 'Error';
        }
    }
}

function memoryAdd() {
    if (isOn) memory += parseFloat(display.value) || 0;
}

function memorySubtract() {
    if (isOn) memory -= parseFloat(display.value) || 0;
}

function memoryRecall() {
    if (isOn) display.value = memory;
}

function turnOff() {
    isOn = false;
    display.value = '';
    display.classList.add('off');
}

function togglePower() {
    isOn = true;
    display.value = '';
    display.classList.remove('off');
}
