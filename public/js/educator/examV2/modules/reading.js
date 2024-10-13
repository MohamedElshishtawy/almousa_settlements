import { generateChoice } from './choice.js';
import { generateTrueOrFalseQuestion } from "./trueOrFalse.js";
import { asset, createMediaElement } from "../../../models/helper.js";

// Define translations
const translations = {
    en: {
        questionPlaceholder: 'Place your question here',
        choiceQuestion: 'Choice Question',
        trueOrFalseQuestion: 'True or False Question',
        delete: 'Delete',
    },
    ar: {
        questionPlaceholder: 'ضع هنا السؤال',
        choiceQuestion: 'سؤال إختر',
        trueOrFalseQuestion: 'سؤال صح و خطا',
        delete: 'حذف',
    }
};

export function GenerateReading(qCounter, ExamOl, lang = 'ar',  qData = []) {
    const t = translations[lang]; // Get translations based on the language
    console.log(lang)
    // For question number
    let newLi = $(`<li class="q-num" id="h${qCounter}"></li>`);
    ExamOl.append(newLi);

    let questionDiv = $(`<div class="qus-div" id="qusDiv${qCounter}"></div>`);
    $(newLi).append(questionDiv);

    // Attributes
    questionDiv.append('<input type="hidden" name="type[' + qCounter + ']" value="reading">');

    // For question input
    questionDiv.append('<textarea type="text" class="form-control q-input" id="exInput' + qCounter + '" placeholder="' + t.questionPlaceholder + '" name="q[' + qCounter + ']">' + (qData['head'] || '') + '</textarea>');

    // For question image
    let imgDiv = $(`<div class="img-div" id="imgDiv${qCounter}"></div>`);
    questionDiv.append(imgDiv);
    if (qData['media_url']) {
        imgDiv.append(`<input type="hidden" class="file-input form-control" id="imgH${qCounter}" value="${qData['media_url']}" name="img[${qCounter}]">`)
            .append(`<input type="file" class="file-input form-control d-none" id="img${qCounter}" name="img[${qCounter}]">`)
            .append(createMediaElement(asset('storage/' + qData['media_url']),`img_${qCounter}`))
            .append(`<div class="btn btn-danger btn-sm remove-img" id="removeImg${qCounter}" for-img="img_${qCounter}"><i class="fa-solid fa-xmark"></i></div>`);
    } else {
        imgDiv.append(`<input type="file" class="file-input form-control" id="img${qCounter}" name="img[${qCounter}]">`)
            .append(`<input type="hidden" class="file-input form-control" id="imgH${qCounter}" name="img[${qCounter}]">`)
            .append(`<div class="btn btn-danger btn-sm remove-img" id="removeImg${qCounter}" for-img="img_${qCounter}"><i class="fa-solid fa-xmark"></i></div>`);
    }

    // Order List for the questions
    let newOl = $(`<ol id="readingQuestions${qCounter}"></ol>`);
    questionDiv.append(newOl);
    let readingQuestionIndex = qCounter;
    if (qData['questions']) {
        const readingIndex = qCounter++;

        for (let q = 0; q < qData['questions'].length; q++) {
            let question = qData['questions'][q];
            let questionType = question.type;

            switch (questionType) {
                case 'choice':
                    generateChoice(qCounter++, newOl, readingIndex, lang, question);
                    break;
                case 'trueOrFalse':
                    generateTrueOrFalseQuestion(qCounter++, newOl, readingIndex, lang, question);
                    break;
            }
        }
    }

    // Adding Questions buttons
    const qControls = $(`<div class="question-controll" id="qControls${qCounter}"></div>`);
    questionDiv.append(qControls);
    $(qControls)
        .append(`<div class="btn btn-success btn-lg" choice-for-reading="${readingQuestionIndex}" id="addChoiceReading${readingQuestionIndex}">${t.choiceQuestion}</div>`)
        .append(`<div class="btn btn-success btn-lg" true-or-false-for-reading="${readingQuestionIndex}" id="addTrueOrFalseReading${readingQuestionIndex}">${t.trueOrFalseQuestion}</div>`)
        .append(`<div class="btn btn-danger btn-lg" data-deletereading="${readingQuestionIndex}" id="deleteReading${readingQuestionIndex}">${t.delete}</div>`);
}
