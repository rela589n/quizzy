$(function () {
    if (!Array.prototype.last) {
        Array.prototype.last = function () {
            return this[this.length - 1];
        };
    }


    let $editTestForm = $('.edit-test-form');
    let $document = $(document);
    let $questionsContainer = $editTestForm.find('ul.list-group.questions');
    let questionsManager = new QuestionsManager($questionsContainer);

    function QuestionRecord($html) {
        let $question = $html;
        let $wrapper = $question.find('.variants-wrapper');
        let variants = [];

        this.changeIndex = function (newIndex) {
            $question.attr('data-question', newIndex);

            let questionName = questionsManager.generateQuestionName(this.getIndex());
            //label
            $question.children('.question-header').text(questionsManager.questionTextPlaceholder(newIndex))
                .attr('for', questionName);

            //input
            $question.children('.question-text').attr('name', questionName).attr('id', questionName);
            // console.log('reindex');
            reindexVariants();
        };

        this.pushVariant = function (variantRecord) {
            variants.push(variantRecord);
            $wrapper.append(variantRecord.getDomElement());
        };

        this.variantsSize = function () {
            return variants.length;
        };

        this.getVariant = function (index) {
            return variants[index];
        };

        this.getIndex = function () {
            return parseInt($question.attr('data-question'));
        };

        this.getQId = function () {
            return $question.attr('data-question-id');
        };

        this.deleteVariant = function (delIndex) {
            let currentVariant = variants[delIndex - 1];

            currentVariant.getDomElement().detach();

            variants.splice(delIndex - 1, 1);
            reindexVariants(delIndex - 1);
        };

        function reindexVariants(startFrom = 0, delta = 0) {
            for (let i = startFrom; i < variants.length; ++i) {
                variants[i].changeIndex(i + 1 + delta);
            }
        }

        this.getDomElement = function () {
            return $question;
        };

        this.detach = function () {
            $question.detach();
        };
    }

    function VariantRecord($html, questionRecord) {
        let $variant = $html;
        let parent = questionRecord;

        this.changeIndex = function (index) {
            $variant.attr('data-variant', index);

            // console.log(parent.getIndex());

            $variant.find('.variant-text')
                .attr('placeholder', questionsManager.variantTextPlaceholder(index))
                .attr('name', questionsManager.generateVariantInputName(parent.getIndex(), index));

            $variant.find('.is-correct').attr('name', questionsManager.generateCheckBoxName(parent.getIndex(), index));
        };

        this.getIndex = function () {
            return parseInt($variant.attr('data-variant'));
        };


        this.getDomElement = function () {
            return $variant;
        };
    }

    function QuestionsManager($questionsContainer) {
        this.$questionsContainer = $questionsContainer;
        let questions = [];

        this.appendNewQuestion = function () {
            let newRecord = new QuestionRecord(this.createEmptyQuestion(questions.length + 1));
            questions.push(newRecord);

            this.appendNewVariant(questions.length);
            this.appendNewVariant(questions.length);

            this.$questionsContainer.append(newRecord.getDomElement());
        };

        this.appendNewVariant = function (questionIndex) {
            questions[questionIndex - 1].pushVariant(
                new VariantRecord(this.createEmptyVariant(
                    questions[questionIndex - 1].variantsSize() + 1,
                    questionIndex
                ), questions[questionIndex - 1])
            );
        };

        this.removeQuestion = function (delIndex) {
            let thisQuestion = questions[delIndex - 1];

            let questionId = thisQuestion.getQId();
            if (!isNaN(questionId)) {
                $editTestForm.append($(`<input type="hidden" name="q[deleted][]" value="${questionId}">`));
            }

            thisQuestion.getDomElement().detach();

            questions.splice(delIndex - 1, 1);
            for (let i = delIndex - 1; i < questions.length; ++i) {
                questions[i].changeIndex(i + 1);
            }
        };

        this.removeVariant = function (questionIndex, variantIndex) {
            let thisQuestion = questions[questionIndex - 1];
            thisQuestion.deleteVariant(variantIndex);
        };

        this.createEmptyQuestion = function (questionIndex) {
            return $(`<li class="list-group-item mb-4 question" data-question="${questionIndex}" data-new="true">
                    <label for="q[new][${questionIndex}][name]"
                           class="text-center mb-3 h4 d-block question-header">
                           ${this.questionTextPlaceholder(questionIndex)}
                    </label>

                    <button type="button" class="btn btn-danger position-absolute button-delete-question" tabindex="-1"><i class="fas fa-trash"></i></button>

                    <input type="text"
                           id="q[new][${questionIndex}][name]"
                           name="q[new][${questionIndex}][name]"
                           class="form-control question-text"
                           placeholder="Запитання"
                           required="required">
                    <div class="variants-wrapper">

                    </div>

                    <button type="button" class="btn btn-outline-primary btn-sm button-add-variant mt-2"><i
                                class="fas fa-plus"></i></button>
                </li>`);
        };

        this.createEmptyVariant = function (variantIndex, questionIndex) {

            return $(`<div class="form-row align-items-center" data-variant="${variantIndex}">
                    <div class="col-auto">
                        <label class="form-check d-inline pb-1 mb-0">
                            <input class="form-check-input is-correct" type="checkbox"
                                   name="${this.generateCheckBoxName(questionIndex, variantIndex)}">
                        </label>
                    </div>
                    <div class="col-form-label col-xl-11 col-lg-10 col-sm-9 col-8">
                        <label class="form-check-label d-block">
                            <input type="text" class="form-control form-control-sm variant-text"
                                   name="${this.generateVariantInputName(questionIndex, variantIndex)}"
                                   placeholder="${this.variantTextPlaceholder(variantIndex)}"  required="required">
                        </label>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-outline-danger btn-sm button-delete-variant" tabindex="-1"><i class="fas fa-trash"></i></button>
                    </div>
                </div>`);
        };


        this.variantTextPlaceholder = function (variantIndex) {
            return `Варіант № ${variantIndex}`;
        };

        this.questionTextPlaceholder = function (questionIndex) {
            return 'Питання № ' + questionIndex;
        };

        this.generateQuestionName = function (questionIndex) {
            return `q[new][${questionIndex}][name]`;
        };

        this.generateCheckBoxName = function (questionIndex, variantIndex) {
            return `q[new][${questionIndex}][v][${variantIndex}][is_right]`;
        };

        this.generateVariantInputName = function (questionIndex, variantIndex) {
            return `q[new][${questionIndex}][v][${variantIndex}][text]`;
        };

        this.generateId = function () {
            if (typeof this.counter === "undefined") {
                this.counter = 0;
            }

            return this.counter++;
        }
    }


    $('.button-add-question').click(function () {
        questionsManager.appendNewQuestion();
    });


    $document.on('click', '.button-add-variant', function () {
        let $question = $(this).closest('li.question');

        questionsManager.appendNewVariant($question.attr('data-question'));
    });

    $document.on('click', '.button-delete-variant', function () {

        let $thisVariant = $(this).closest('[data-variant]');
        let $thisQuestion = $thisVariant.closest('li.question');

        questionsManager.removeVariant($thisQuestion.attr('data-question'), $thisVariant.attr('data-variant'))
    });

    $document.on('click', '.button-delete-question', function () {

        let $thisQuestion = $(this).closest('.question');
        let delQuestionId = $thisQuestion.attr('data-question');

        questionsManager.removeQuestion(delQuestionId);
    });

    $document.on('change', $editTestForm.find('input[type=text]'), function (e) {
        let $currentInput = $(e.target);
        let $question = $currentInput.closest('.question');
        if (!$question.is('[data-new=true]')) {
            $question.attr('data-modified', 'true');
        }
    });
});
