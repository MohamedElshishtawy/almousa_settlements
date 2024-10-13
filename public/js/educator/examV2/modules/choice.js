import { asset, createMediaElement } from '../../../models/helper.js';

// Function to get translations based on the language
function getTranslation(key, lang) {
    const translations = {
        ar: {
            degree_label: 'درجة السؤال:',
            level_label: 'مستوى السؤال:',
            question_placeholder: 'ضع هنا السؤال',
            choice_a: 'الإختيار ا',
            choice_b: 'الإختيار ب',
            choice_c: 'الإختيار ج',
            choice_d: 'الإختيار د',
            observation_placeholder: 'ضع ملحوظتك علي السؤال',
            delete: 'حذف'
        },
        en: {
            degree_label: 'Question Degree:',
            level_label: 'Question Level:',
            question_placeholder: 'Place the question here',
            choice_a: 'Choice A',
            choice_b: 'Choice B',
            choice_c: 'Choice C',
            choice_d: 'Choice D',
            observation_placeholder: 'Place your observation on the question',
            delete: 'Delete'
        }
    };
    return translations[lang][key];
}


export function generateChoice(qCounter, questionsOl, forReading = -1, lang = 'ar', qData = {}) {
    // for question number
    let newLi = $(`<li class="q-num" id="h${qCounter}"></li>`);
    questionsOl.append(newLi);

    let questionDiv = $(`<div class="qus-div" id="${forReading >= 0 ? `ReadingQusDiv${qCounter}` : `qusDiv${qCounter}`}"></div>`);
    newLi.append(questionDiv);

    // Attributes
    questionDiv.append(`<input type="hidden" name="type[${qCounter}]" value="choice">`);
    if (forReading >= 0) {
        questionDiv.append(`<input type="hidden" name="forReading[${qCounter}]" value="${forReading}">`);
    }

    // Degree
    let degDiv = $(`<div id="degDiv${qCounter}" class="deg-container"></div>`);
    questionDiv.append(degDiv);
    degDiv.append(`<label for="degInput${qCounter}" class="deg-label">${getTranslation('degree_label', lang)}</label>`);
    degDiv.append(`<input type="number" min="1" max="30" class="form-control" id="degInput${qCounter}" value="${qData.points || 1}" name="deg[${qCounter}]">`);

    // Level
    let levelDiv = $(`<div id="levelDiv${qCounter}" class="deg-container"></div>`);
    questionDiv.append(levelDiv);
    levelDiv.append(`<label for="levelInput${qCounter}" class="deg-label">${getTranslation('level_label', lang)}</label>`);
    levelDiv.append(`<input type="number" min="1" max="5" class="form-control" id="levelInput${qCounter}" value="${qData.level || 1}" name="level[${qCounter}]">`);

    // for question input
    let questionTextarea = $(`<textarea type="text" class="form-control q-input" id="exInput${qCounter}" placeholder="${getTranslation('question_placeholder', lang)}" name="q[${qCounter}]">${qData.head || ''}</textarea>`);
    questionDiv.append(questionTextarea);

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

    // for answers inputs
    for (let ans = 0; ans < 4; ans++) {
        let ansDiv = $(`<div id="ansDiv${qCounter}${ans}" class="ans-div"></div>`);
        questionDiv.append(ansDiv);
        ansDiv.append(`<input type="radio" class="rd-input" usage="trueAns" id="radio${qCounter}${ans}" name="at[${qCounter}]" value="a${ans}" ${ qData.choices?.[ans]?.true_ans ? 'checked' : ''}>`);

        let inputVal;
        switch (ans) {
            case 0:
                inputVal = getTranslation('choice_a', lang);
                break;
            case 1:
                inputVal = getTranslation('choice_b', lang);
                break;
            case 2:
                inputVal = getTranslation('choice_c', lang);
                break;
            case 3:
                inputVal = getTranslation('choice_d', lang);
                break;
        }
        let choiceText = qData.choices?.[ans]?.text || inputVal;
        ansDiv.append(`<input type="text" class="form-control a-input" id="exInput${qCounter}_ans${ans}" name="a[${qCounter}][]" value="${choiceText}">`);
    }

    // for question observation
    let observTextarea = $(`<textarea type="text" class="form-control observ-input" id="observInput${qCounter}" placeholder="${getTranslation('observation_placeholder', lang)}" name="obs[${qCounter}]">${qData.observation || ''}</textarea>`);
    questionDiv.append(observTextarea);

    // for observation image
    let obsDiv = $(`<div class="img-div" id="obsDiv${qCounter}"></div>`);
    questionDiv.append(obsDiv);
    if (qData['observation_media']) {
        obsDiv.append(`<input type="hidden" class="file-input form-control" id="obsH${qCounter}" value="${qData['observation_media']}" name="obsImg[${qCounter}]">`)
            .append(`<input type="file" class="file-input form-control d-none" id="obsImg${qCounter}" name="obsImg[${qCounter}]">`)
            .append(createMediaElement(asset('storage/' + qData['observation_media']), `obs_${qCounter}`))
    } else {
        obsDiv.append(`<input type="file" class="file-input form-control" id="obsImg${qCounter}" name="obsImg[${qCounter}]">`)
            .append(`<input type="hidden" class="file-input form-control" id="obsH${qCounter}" value="${qData.observation_media || ''}" name="obsImg[${qCounter}]">`);
    }
    obsDiv.append(`<div class="btn btn-danger btn-sm remove-img" id="removeObs${qCounter}" for-img="obs_${qCounter}"><i class="fa-solid fa-xmark"></i></div>`);

    // for delete button
    let deleteButton = $(`<button class="btn btn-danger delete-question" type="button" id="delete${qCounter}" for-question="${qCounter}">${getTranslation('delete', lang)}</button>`);
    questionDiv.append(deleteButton);
}
