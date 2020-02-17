$(function () {
    if (!Array.prototype.last) {
        Array.prototype.last = function () {
            return this[this.length - 1];
        };
    }

    let $editTestForm = $('.edit-test-form');
    let $document = $(document);
    let $lastOptionId = $('#last-answer-option-id');

    let $questionsContainer = $editTestForm.find('ul.list-group.questions');
    let questionsManager = new QuestionsManager($questionsContainer, $lastOptionId.val());
    let $labelEmptyQuestionsList = $('.empty-questions-list-label');

    $document.on('click', '.button-add-question', function () {
        questionsManager.appendNewQuestion();
        checkQuestionsCountLabel();
    });

    $document.on('click', '.button-delete-question', function () {

        let $thisQuestion = $(this).closest('.question');
        let delQuestionIndex = $thisQuestion.attr('data-question');

        questionsManager.removeQuestion(delQuestionIndex);

        checkQuestionsCountLabel();
    });

    $document.on('click', '.button-add-variant', function () {
        let $question = $(this).closest('li.question');

        questionsManager.appendNewVariant($question.attr('data-question'))
    });

    $document.on('click', '.button-delete-variant', function () {

        let $thisVariant = $(this).closest('[data-variant]');
        let $thisQuestion = $thisVariant.closest('li.question');

        questionsManager.removeVariant($thisQuestion.attr('data-question'), $thisVariant.attr('data-variant'))
        console.log('deleted!');
    });

    $document.on('change', $editTestForm.find('input[type=text]'), function (e) {
        let $currentInput = $(e.target);
        let $question = $currentInput.closest('li.question');
        if (!$question.is('[data-new=true]')) {
            $question.attr('data-modified', 'true');
        }
    });

    questionsManager.events.on('variantAppended', function(variant) {
        $lastOptionId.val(variant.getVId());
    });

    questionsManager.events.on('questionRemoved', function(questionRecord) {
        let delQuestionId = questionRecord.getQId();
        if (!isNaN(delQuestionId)) {
            $editTestForm.append($(`<input type="hidden" name="q[deleted][]" value="${delQuestionId}">`));
        }
    });

    questionsManager.events.on('variantRemoved', function(variant) {
        let delVariantId = variant.getVId();

        if (!isNaN(delVariantId)) { // todo exclude manually inserted
            $editTestForm.append($(`<input type="hidden" name="v[deleted][]" value="${delVariantId}">`));
        }
    });

    function checkQuestionsCountLabel() {
        if (questionsManager.getQuestionsCount() !== 0) {
            $labelEmptyQuestionsList.slideUp();
        } else {
            $labelEmptyQuestionsList.slideDown();
        }
    }

    function QuestionRecord($html) {
        let context = this;
        let $question = $html;
        let $wrapper = $question.find('.variants-wrapper');
        let variants = parseVariants();
        let type = parseType();

        function parseType() {
            return $question.is('[data-new=true]') ? 'new' : 'modified';
        }

        function parseVariants() {
            let result = [];

            $question.find('[data-variant]').each(function (index, element) {
                result.push(new VariantRecord($(element), context));
            });

            return result;
        }

        this.getNameId = function () {
            return type === 'new' ? context.getIndex() : context.getQId();
        };

        this.getQId = function () {
            return $question.attr('data-question-id');
        };

        this.getQType = function() {
            return type;
        };

        this.getLastVariantIndex = function () {
            let variantsSize = variants.length;
            return (variantsSize === 0) ? 0 : variants.last().getIndex();
        };

        this.changeIndex = function (newIndex) {
            $question.attr('data-question', newIndex);

            //label
            $question.children('.question-header').text(questionsManager.questionTextPlaceholder(newIndex))
                .attr('for', newIndex);

            //input
            $question.children('.question-text').attr('id', newIndex);
            reindexVariants();
        };

        this.pushVariant = function (variantRecord, animationTime = 300) {
            variants.push(variantRecord);
            let domElement = variantRecord.getDomElement();
            $wrapper.append(domElement);
            domElement.hide().slideDown(animationTime);
        };

        this.getIndex = function () {
            return parseInt($question.attr('data-question'));
        };

        this.deleteVariant = function (delIndex) {
            let currentVariant = variants[delIndex - 1];

            currentVariant.getDomElement().slideUp(300, function () {
                $(this).detach();
            });

            variants.splice(delIndex - 1, 1);
            reindexVariants(delIndex - 1);

            return currentVariant;
        };

        function reindexVariants(startFrom = 0, delta = 0) {
            for (let i = startFrom; i < variants.length; ++i) {
                variants[i].changeIndex(i + 1 + delta);
            }
        }

        this.getDomElement = function () {
            return $question;
        };
    }

    function VariantRecord($html, questionRecord) {
        let $variant = $html;
        let parent = questionRecord;
        let type = parseType();

        function parseType() {
            return $variant.is('[data-new=true]') ? 'new' : 'modified';
        }

        this.getVType = function() {
            return type;
        };

        this.changeIndex = function (index) {
            $variant.attr('data-variant', index);

            $variant.find('.variant-text')
                .attr('placeholder', questionsManager.variantTextPlaceholder(index));

            $variant.find('.is-correct');
        };

        this.getIndex = function () {
            return parseInt($variant.attr('data-variant'));
        };

        this.getVId = function () {
            return $variant.attr('data-variant-id');
        };

        this.getDomElement = function () {
            return $variant;
        };
    }

    function QuestionsManager($questionsContainer, lastVariantId) {
        let context = this;
        let $context = $(context);
        this.$questionsContainer = $questionsContainer;
        let questions = parseQuestions();

        this.events = new function() {
            let _triggers = {};

            this.on = function(event,callback) {
                if(!_triggers[event])
                    _triggers[event] = [];
                _triggers[event].push( callback );
            };

            this.trigger = function(event,params) {
                if( _triggers[event] ) {
                    for(let i = 0; i < _triggers[event].length; ++i) {
                        _triggers[event][i].apply(this, params);
                    }
                }
            };
        };

        context.lastVariantId = parseInt(lastVariantId);

        function parseQuestions() {
            let result = [];
            $questionsContainer.find('li.question').each(function (index, element) {
                result.push(new QuestionRecord($(element)));
            });

            return result;
        }

        function getLastQuestionIndex() {
            return (questions.length === 0) ? 0 : questions.last().getIndex();
        }

        this.getQuestionsCount = function () {
            return questions.length;
        };

        this.appendNewQuestion = function (animationTime = 200) {
            let questionIndex = getLastQuestionIndex() + 1;

            let newRecord = new QuestionRecord(context.createEmptyQuestion(questionIndex));
            questions.push(newRecord);

            this.appendNewVariant(questions.length, 0);
            this.appendNewVariant(questions.length, 0);

            let domElement = newRecord.getDomElement();
            this.$questionsContainer.append(domElement);
            domElement.hide().slideDown(animationTime);

            $context.trigger('questionAppended', [newRecord]);
        };

        this.appendNewVariant = function (questionIndex, animationTime = 300) {
            let currentQuestion = questions[questionIndex - 1];
            let variantIndex = currentQuestion.getLastVariantIndex() + 1;
            let newVariantId = context.generateVariantId();

            let variantRecord = new VariantRecord(
                context.createEmptyVariant(
                    variantIndex,
                    newVariantId,
                    currentQuestion.getQId() || currentQuestion.getIndex(),
                    currentQuestion.getQType()
                ),
                currentQuestion);

            currentQuestion.pushVariant(
                variantRecord,
                animationTime
            );

            context.events.trigger('variantAppended', [variantRecord]);
        };

        this.removeQuestion = function (delIndex) {
            let thisQuestion = questions[delIndex - 1];

            thisQuestion.getDomElement().slideUp(200, function () {
                $(this).detach();
            });

            questions.splice(delIndex - 1, 1);
            for (let i = delIndex - 1; i < questions.length; ++i) {
                questions[i].changeIndex(i + 1);
            }

            context.events.trigger('questionRemoved', [thisQuestion]);
        };

        this.removeVariant = function (questionIndex, variantIndex) {
            let thisQuestion = questions[questionIndex - 1];
            let deleted = thisQuestion.deleteVariant(variantIndex);

            context.events.trigger('variantRemoved', [deleted]);
        };

        this.createEmptyQuestion = function (questionId) {
            return $(`<li class="list-group-item mb-4 question" data-question="${questionId}" data-new="true">
                    <label for="${context.generateQuestionName(questionId)}"
                           class="text-center mb-3 h4 d-block question-header">
                           ${context.questionTextPlaceholder(questionId)}
                    </label>

                    <button type="button" class="btn btn-danger position-absolute button-delete-question" tabindex="-1"><i class="fas fa-trash"></i></button>

                    <input type="text"
                           id="${context.generateQuestionName(questionId)}"
                           name="${context.generateQuestionName(questionId)}"
                           class="form-control question-text"
                           placeholder="Запитання"
                           required="required">
                    <div class="variants-wrapper">

                    </div>

                    <button type="button" class="btn btn-outline-primary btn-sm button-add-variant mt-2"><i
                                class="fas fa-plus"></i></button>
                </li>`);
        };

        this.createEmptyVariant = function (variantIndex, variantId, questionId, type = 'new') {

            return $(`<div class="form-row align-items-center" data-variant="${variantIndex}" data-variant-id="${variantId}">
                    <div class="col-auto">
                        <label class="form-check d-inline pb-1 mb-0">
                            <input class="form-check-input is-correct" type="checkbox"
                                   name="${context.generateCheckBoxName(questionId, variantId, type)}">
                        </label>
                    </div>
                    <div class="col-form-label col-xl-11 col-lg-10 col-sm-9 col-8">
                        <label class="form-check-label d-block">
                            <input type="text" class="form-control form-control-sm variant-text"
                                   name="${context.generateVariantInputName(questionId, variantId, type)}"
                                   placeholder="${context.variantTextPlaceholder(variantIndex, type)}"  required="required">
                        </label>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-outline-danger btn-sm button-delete-variant" tabindex="-1"><i class="fas fa-trash"></i></button>
                    </div>
                </div>`);
        };

        this.generateVariantId = function() {
            return ++context.lastVariantId;
        };

        this.variantTextPlaceholder = function (variantIndex) {
            return `Варіант № ${variantIndex}`;
        };

        this.questionTextPlaceholder = function (questionIndex) {
            return 'Питання № ' + questionIndex;
        };

        this.generateQuestionName = function (questionIndex, type = 'new') {
            return `q[${type}][${questionIndex}][name]`;
        };

        this.generateCheckBoxName = function (questionIndex, variantIndex, type = 'new') {
            return `q[${type}][${questionIndex}][v][${variantIndex}][is_right]`;
        };

        this.generateVariantInputName = function (questionIndex, variantIndex, type = 'new') {
            return `q[${type}][${questionIndex}][v][${variantIndex}][text]`;
        };
    }
});
