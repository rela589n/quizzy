$(function () {
    let $editTestForm = $('.edit-test-form');
    let $document = $(document);
    let $questionsContainer = $editTestForm.find('ul.list-group.questions');
    let creator = new QuestionCreator($questionsContainer);

    function QuestionRecord(html) {
        let $question = $(html);
        let variants = [];

        this.changeIndex = function (newIndex) {
            $question.attr('data-question', newIndex);
            $question.children('.question-header').text(creator.questionTextPlaceholder(newIndex));
        };

        this.pushVariant = function (variantRecord) {
            variants.push(variantRecord);
        };

        this.getVariant = function (index) {
            return variants[index];
        };

        this.callNextVariantUpdate = function(nextIndex) {

        }

        this.getResultHtml = function () {
            let $wrapper = $question.find('.variants-wrapper');
            for (let i = 0; i < variants.length; ++i) {
                $wrapper.append(variants[i].getResultHtml());
            }

            return $question;
        }
    }

    function VariantRecord(html, questionRecord) {
        let $variant = $(html);
        let parent = questionRecord;


        this.changeIndex = function ($variant, index) {
            $variant.attr('data-variant', index);
            $variant.find('.variant-text').attr('placeholder', creator.variantTextPlaceholder(index));
            $variant.find('.is-correct').attr('name', creator.generateCheckBoxName(parent.))
            // $('.is-correct', $variant).attr('name', creator.)
        };

        this.getResultHtml = function () {
            return $variant;
        };
    }

    function QuestionCreator($questionsContainer) {
        this.$questionsContainer = $questionsContainer;

        this.appendNewQuestion = function () {
            let newQuestionIndex = (+this.$questionsContainer.children('li:last').attr('data-question') + 1) || 1;
            let $newQuestion = this.createEmptyQuestion(newQuestionIndex);

            let $variant1 = this.createEmptyVariant(1, newQuestionIndex);
            let $variant2 = this.createEmptyVariant(2, newQuestionIndex);

            this.pushVariantToQuestion($newQuestion, $variant1);
            this.pushVariantToQuestion($newQuestion, $variant2);
            this.$questionsContainer.append($newQuestion);
        };

        this.pushVariantToQuestion = function ($question, $variant) {
            $question.find('.variants-wrapper').append($variant);
            return this;
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
                                   name="${this.generateCheckBoxName(variantIndex, questionIndex)}">
                        </label>
                    </div>
                    <div class="col-form-label col-xl-11 col-lg-10 col-sm-9 col-8">
                        <label class="form-check-label d-block">
                            <input type="text" class="form-control form-control-sm variant-text"
                                   name="${this.generateVariantInputName(variantIndex, questionIndex)}"
                                   placeholder="${this.variantTextPlaceholder(variantIndex)}"  required="required">
                        </label>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-outline-danger btn-sm button-delete-variant" tabindex="-1"><i class="fas fa-trash"></i></button>
                    </div>
                </div>`);
        };

        this.changeVariantIndex = function ($variant, index) {
            $variant.attr('data-variant', index);
            $variant.find('.variant-text').attr('placeholder', 'Варіант № ' + index);
            // $('.is-correct', $variant).attr('name', creator.)
        };

        this.variantTextPlaceholder = function (variantIndex) {
            return `Варіант № ${variantIndex}`;
        };

        this.questionTextPlaceholder = function (questionIndex) {
            return 'Питання № ' + questionIndex;
        };

        this.generateCheckBoxName = function (variantIndex, questionIndex) {
            return `q[new][${questionIndex}][v][${variantIndex}][is_right]`;
        };

        this.generateVariantInputName = function (variantIndex, questionIndex) {
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
        creator.appendNewQuestion();
    });


    $document.on('click', '.button-add-variant', function () {
        let $this = $(this);
        let $question = $this.closest('li.question');
        let $variantsWrapper = $this.siblings('.variants-wrapper');

        let newVariantIndex = +$variantsWrapper.children('div:last').attr('data-variant') + 1 || 1;
        let questionIndex = $question.attr('data-question');

        $variantsWrapper.append(creator.createEmptyVariant(newVariantIndex, questionIndex));
    });

    $document.on('click', '.button-delete-variant', function () {
        let $btn = $(this);

        let $thisVariant = $btn.closest('[data-variant]');
        let nextVariantIndex = $thisVariant.attr('data-variant');
        let $nextVariants = $thisVariant.nextAll();

        $nextVariants.each(function (_, variant) {
            changeVariantIndex($(variant), nextVariantIndex++);
        });

        $thisVariant.detach();

        function changeVariantIndex($variant, index) {
            $variant.attr('data-variant', index);
            $variant.find('.variant-text').attr('placeholder', 'Варіант № ' + index);
            // $('.is-correct', $variant).attr('name', creator.)
        }

    });

    $document.on('click', '.button-delete-question', function () {
        let $thisBtn = $(this);

        let $thisQuestion = $thisBtn.closest('.question');
        let nextQuestionIndex = $thisQuestion.attr('data-question');
        let $nextQuestions = $thisQuestion.nextAll('.question');

        $nextQuestions.each(function (_, variant) {
            changeQuestionIndex($(variant), nextQuestionIndex++);
        });

        let questionId = $thisQuestion.attr('data-question-id');
        if (!isNaN(questionId)) {
            $editTestForm.append($(`<input type="hidden" name="q[deleted][]" value="${questionId}">`));
        }

        $thisQuestion.detach();

        function changeQuestionIndex($question, index) {
            $question.attr('data-question', index);
            $question.children('.question-header').text('Питання № ' + index);
        }
    });

    $document.on('change', $editTestForm.find('input[type=text]'), function (e) {
        let $currentInput = $(e.target);
        let $question = $currentInput.closest('.question');
        if (!$question.is('[data-new=true]')) {
            $question.attr('data-modified', 'true');
        }
    });

    $editTestForm.submit(function (e) {
        checkNew();
        checkModified();

        function checkNew() {
            let $new = $questionsContainer.children('[data-new=true]');

            $new.each(function () {
                let $this = $(this);
                let $inputs = $this.find('input');

                let qIndex = creator.generateId();
                $inputs.filter('.question-text').attr('name', `q[new][${qIndex}][name]`);

                $inputs.filter('.is-correct').each(function (index, el) {
                    let $el = $(el);

                    if ($el.is(':checked')) {
                        $el.attr('name', `q[new][${qIndex}][v][correct][${index}]`);
                    }
                });
                $inputs.filter('.variant-text').attr('name', `q[new][${qIndex}][v][text][]`);
            });
        }

        function checkModified() {
            let $modified = $questionsContainer.children('[data-modified=true]');

            $modified.each(function () {
                let $this = $(this);
                let $inputs = $this.find('input');

                let questionId = $this.attr('data-question-id');
                $inputs.filter('.question-text').attr('name', `q[modified][${questionId}][name]`);

                $inputs.filter('.is-correct').each(function (index, el) {
                    let $el = $(el);

                    if ($el.is(':checked')) {
                        $el.attr('name', `q[modified][${questionId}][v][correct][${index}]`);
                    }
                });
                $inputs.filter('.variant-text').attr('name', `q[modified][${questionId}][v][text][]`);
            });

            // e.preventDefault();
        }
    });
});
