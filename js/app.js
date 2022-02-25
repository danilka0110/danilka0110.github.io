let questionNum = 1;
let resultNum = 1;

$(document).on('click', '.addAnswer', function() {
    let question = $(this).data('question');
    let answer = $(this).data('answer');
    let answerBlock = $(this).parents('.answers').find('.answer-items');
    answer++;
    $(this).data('answer', answer);
    
    answerBlock.append(`<div class="row">
    <div class="col-10">
        <label for="answer_text_1_1" class="form-label">Ответ #${answer}</label>
        <input type="text" name="answer_text_${question}_${answer}" id="answer_text_${question}_${answer}" class="form-control">
    </div>
    <div class="col-2">
        <label for="answer_score_1_1" class="form-label">Балл </label>
        <input type="text" name="answer_score_${question}_${answer}" id="answer_score_${question}_${answer}" class="form-control">
    </div>
</div>`);
});
$('.addQuestion').on('click', function() {
    questionNum++;
    let questionBlock = $('.question-items');

    questionBlock.append(`
                <div class="mt-4">
                    <label for="question_${questionNum}" class="form-label">Вопрос #${questionNum}</label>
                    <input type="text" name="question_${questionNum}" id="question_${questionNum}" class="form-control">
                    <div class="answers">
                        <div class="answer-items">
                        </div>
                        <div class="text-center mt-4">
                            <button type="button" class="btn btn-light border addAnswer" data-question="${questionNum}" data-answer="0">Добавить вариант ответа</button>
                        </div>
                    </div>
                </div>`);
});
$(document).on('click', '.addResult', function() {
    resultNum++;
    let resultBlock = $('.result-items');

    resultBlock.append(`
    <div class="mt-4">
    <div class="">
    <label for="result_${resultNum}" class="form-label">Результат #${resultNum}</label>
    <textarea name="result_${resultNum}" id="result_1" class="form-control"></textarea>
    </div>
    <div class="row">
        <div class="col-6 col-md-6 col-lg-6 col-xl-6 mt-2">
            <label for="result_score_min_${resultNum}" class="form-label">Балл (от)</label>
            <input type="text" name="result_score_min_${resultNum}" id="result_score_min_${resultNum}" class="form-control">
        </div>
        <div class="col-6 col-md-6 col-lg-6 col-xl-6 mt-2">
            <label for="result_score_max_${resultNum}" class="form-label">Балл (до)</label>
            <input type="text" name="result_score_max_${resultNum}" id="result_score_max_${resultNum}" class="form-control">
        </div>
    </div>
</div>`);
});