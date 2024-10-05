let currentQuestion = 0;

function showQuestion(index) {
    const questions = document.querySelectorAll('.question');
    questions.forEach((question, i) => {
        question.style.display = (i === index) ? 'block' : 'none';
    });
}

function nextQuestion() {
    const questions = document.querySelectorAll('.question');
    if (currentQuestion < questions.length - 1) {
        currentQuestion++;
        showQuestion(currentQuestion);
    }
}

function prevQuestion() {
    if (currentQuestion > 0) {
        currentQuestion--;
        showQuestion(currentQuestion);
    }
}

showQuestion(currentQuestion);

// 「その他」を選んだときにテキストボックスを表示する
document.getElementById('otherCheckbox').addEventListener('change', function() {
    const otherText = document.getElementById('otherText');
    if (this.checked) {
        otherText.style.display = 'block';
    } else {
        otherText.style.display = 'none';
    }
});