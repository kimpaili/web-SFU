function task1() {
    const number = parseInt(document.getElementById('primeInput').value);
    const result = isPrime(number);
    document.getElementById('primeResult').textContent = result ? `${number} - Простое число` : `${number} - Не простое число`;
}

function isPrime(num) {
    if (num <= 1) return false;
    for (let i = 2; i < num; i++) {
        if (num % i === 0) return false;
    }
    return true;
}

function task2() {
    const numbers = document.getElementById('arrayInput').value.split(',').map(Number);
    let sum = 0;
    for (let i = 0; i < numbers.length; i++) {
        sum += numbers[i];
        if (Math.sin(numbers[i]) > 0) {
            break;
        }
    }
    document.getElementById('arrayResult').textContent = `Сумма элементов: ${sum}`;
}

function task3() {
    const numbers = document.getElementById('deleteInput').value.split(',').map(Number);
    const result = numbers.filter(num => {
        const absInt = Math.abs(Math.trunc(num));
        const digits = absInt.toString().split('');
        return !digits.every(digit => parseInt(digit) % 2 === 0);
    });
    document.getElementById('deleteResult').textContent = `Результат: ${result.join(', ')}`;
}

function task4() {
    const word = document.getElementById('wordInput').value;
    const vowels = ['а', 'е', 'ё', 'и', 'о', 'у', 'ы', 'э', 'ю', 'я'];
    const syllables = word.split('').filter(letter => vowels.includes(letter.toLowerCase()));
    const count = syllables.length;
    document.getElementById('syllableResult').textContent = `Количество слогов: ${count}`;
}
