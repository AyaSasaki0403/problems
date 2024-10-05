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

function toggleInput() {
    var checkbox = document.getElementById("activateInput");
    var inputField = document.getElementById("freeTextInput");
    inputField.disabled = !checkbox.checked;
}
