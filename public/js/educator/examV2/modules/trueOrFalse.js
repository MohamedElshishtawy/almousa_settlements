import { asset, createMediaElement } from "../../../models/helper.js";


// Define translations
const translations = {
    en: {
        degree: 'Question Degree:',
        level: 'Question Level:',
        true: 'True',
        false: 'False',
        delete: 'Delete',
        questionPlaceholder: 'Place your question here',
        observationPlaceholder: 'Place your observation here',
        choiceA: 'Choice A',
        choiceB: 'Choice B',
        choiceC: 'Choice C',
        choiceD: 'Choice D',
    },
    ar: {
        degree: 'درجة السؤال:',
        level: 'مستوى السؤال:',
        true: 'صح',
        false: 'خطأ',
        delete: 'حذف',
        questionPlaceholder: 'ضع هنا السؤال',
        observationPlaceholder: 'ضع ملحوظتك علي السؤال',
        choiceA: 'الإختيار ا',
        choiceB: 'الإختيار ب',
        choiceC: 'الإختيار ج',
        choiceD: 'الإختيار د',
    }
};


export function generateTrueOrFalseQuestion(qCounter, questionOl, forReading = -1,lang = 'ar', qData = {}) {
    const t = translations[lang]; // Get translations based on the language

    // For question number
    let newLi = $(`<li class="q-num" id="h${qCounter}"></li>`);
    questionOl.append(newLi);

    let questionDiv = $(`<div class="qus-div" id="${forReading >= 0 ? `ReadingQusDiv${qCounter}` : `qusDiv${qCounter}`}"></div>`);
    newLi.append(questionDiv);

    // Attributes
    questionDiv.append(`<input type="hidden" name="type[${qCounter}]" value="trueOrFalse">`);
    if (forReading >= 0) {
        questionDiv.append(`<input type="hidden" name="forReading[${qCounter}]" value="${forReading}">`);
    }

    // Degree
    let degDiv = $(`<div id="degDiv${qCounter}" class="deg-container"></div>`);
    questionDiv.append(degDiv);
    degDiv.append(`<label for="degInput${qCounter}" class="deg-label">${t.degree}</label>`);
    degDiv.append(`<input type="number" min="1" max="30" class="form-control" id="degInput${qCounter}" value="${qData.points || 1}" name="deg[${qCounter}]">`);

    // Level
    let levelDiv = $(`<div id="levelDiv${qCounter}" class="deg-container"></div>`);
    questionDiv.append(levelDiv);
    levelDiv.append(`<label for="levelInput${qCounter}" class="deg-label">${t.level}</label>`);
    levelDiv.append(`<input type="number" min="1" max="5" class="form-control" id="levelInput${qCounter}" value="${qData.level || 1}" name="level[${qCounter}]">`);

    // Question Container
    let tfContainer = $(`<div class="tf-container" id="tfContainer${qCounter}"></div>`);
    questionDiv.append(tfContainer);

    // for question image
    let imgDiv = $(`<div class="img-div" id="imgDiv${qCounter}"></div>`);
    questionDiv.append(imgDiv);

    if (qData['media_url']) {
        imgDiv.append(`<input type="hidden" class="file-input form-control" id="imgH${qCounter}" value="${qData['media_url']}" name="img[${qCounter}]">`)
            .append(`<input type="file" class="file-input form-control d-none" id="img${qCounter}"  name="img[${qCounter}]">`)
            .append(createMediaElement(asset('storage/' + qData['media_url']),`img_${qCounter}`))
            .append(`<div class="btn btn-danger btn-sm remove-img" id="removeImg${qCounter}" for-img="img_${qCounter}"><i class="fa-solid fa-xmark"></i></div>`);
    } else {
        imgDiv.append(`<input type="file" class="file-input form-control" id="img${qCounter}" name="img[${qCounter}]">`)
            .append(`<input type="hidden" class="file-input form-control" id="imgH${qCounter}" name="img[${qCounter}]">`)
            .append(`<div class="btn btn-danger btn-sm remove-img" id="removeImg${qCounter}" for-img="img_${qCounter}"><i class="fa-solid fa-xmark"></i></div>`);
    }

    // For question input
    let questionTextarea = $(`<textarea type="text" class="form-control q-input" id="exInput${qCounter}" placeholder="${t.questionPlaceholder}" name="q[${qCounter}]">${qData.head || ''}</textarea>`);
    tfContainer.append(questionTextarea);

    // For CheckBox
    let checkBoxes = $(`<div class="tf-check-boxes" id="checkBoxes${qCounter}"></div>`);
    tfContainer.append(checkBoxes);
    checkBoxes.append(`<div class="check-label"><input type="radio" name="answer[${qCounter}]" ${qData['answer'] ? 'checked' : ''} value="1" id="tBox${qCounter}"/><label for="tBox${qCounter}">${t.true}</label></div>`);
    checkBoxes.append(`<div class="check-label"><input type="radio" name="answer[${qCounter}]" ${qData['answer'] !== undefined ? qData['answer']?null:'checked' : null} value="0"/><label for="fBox${qCounter}">${t.false}</label></div>`);

    // For question observation
    let observTextarea = $(`<textarea type="text" class="form-control observ-input" id="observInput${qCounter}" placeholder="${t.observationPlaceholder}" name="obs[${qCounter}]">${qData.observation || ''}</textarea>`);
    questionDiv.append(observTextarea);

    // For observation image
    let obsDiv = $(`<div class="img-div" id="obsDiv${qCounter}"></div>`);
    questionDiv.append(obsDiv);
    if (qData['observation_media']) {
        obsDiv.append(`<input type="hidden" class="file-input form-control" id="obsH${qCounter}" value="${qData['observation_media']}" name="obsImg[${qCounter}]">`)
            .append(`<input type="file" class="file-input form-control d-none" id="obsImg${qCounter}"  name="obsImg[${qCounter}]">`)
            .append(createMediaElement(asset('storage/' + qData['observation_media']), `obs_${qCounter}`))
    } else {
        obsDiv.append(`<input type="file" class="file-input form-control" id="obsImg${qCounter}" name="obsImg[${qCounter}]">`)
            .append(`<input type="hidden" class="file-input form-control" id="obsH${qCounter}" value="${qData.observation_media || ''}" name="obsImg[${qCounter}]">`);
    }
    obsDiv.append(`<div class="btn btn-danger btn-sm remove-img" id="removeObs${qCounter}" for-img="obs_${qCounter}"><i class="fa-solid fa-xmark"></i></div>`);

    // For delete button
    let deleteButton = $(`<button class="btn btn-danger delete-question" type="button" id="delete${qCounter}" for-question="${qCounter}">${t.delete}</button>`);
    questionDiv.append(deleteButton);
}
