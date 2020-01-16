/*
 * jQuery liTranslit v 1.4
 * http://masscode.ru/index.php/k2/item/28-litranslit
 *
 * Copyright 2013, Linnik Yura
 * Free to use
 *
 * Last Update 25.10.2014
 */

(function ($) {
    let methods = {
        init: function (options) {
            let o = {
                eventType: 'keyup blur copy paste cut start',
                elAlias: $(this),				//Элемент, в который будет записываться результат транслитерации или false
                reg: '"зг"="zgh"',							//'" "="-","ж"="zzzz"' or false or ''
                translated: function (el, text, eventType) {
                },
                caseType: 'inherit',				// lower(default), upper, inherit - регистр выходных данных
                replaceSpaces: " ",
                status: true,
                string: ''						//используется для транслита строковой переменной
            };
            if (options) {
                $.extend(o, options);
            }
            let general = $(this);
            if (!general.length) {
                general = $('<div>').text(o.string);
            }

            return general.each(function () {

                let
                    elName = $(this),
                    elAlias = o.elAlias.length ? o.elAlias.css({wordWrap: 'break-word'}) : general.css({wordWrap: 'break-word'}),
                    nameVal;

                elName.data({
                    status: o.status
                });

                let inser_trans = function (result, e) {

                    if (o.caseType === 'upper') {
                        result = result.toUpperCase();
                    }
                    if (o.caseType === 'lower') {
                        result = result.toLowerCase();
                    }
                    if (elName.data('status') && o.elAlias) {
                        if (elAlias.val()) {
                            elAlias.val(result);
                        } else {
                            elAlias.html(result);
                        }
                    }
                    if (result !== '') {
                        if (o.translated !== undefined) {
                            let type;
                            if (e === undefined) {
                                type = 'no event';
                            } else {
                                type = e.type;
                            }
                            o.translated(elName, result, type);
                        }
                    }
                };

                let customReg = function (str) {
                    let customArr = o.reg.split(',');
                    for (let i = 0; i < customArr.length; i++) {
                        let customItem = customArr[i].split('=');
                        let regi = customItem[0].replace(/"/g, '');
                        let newstr = customItem[1].replace(/"/g, '');
                        let re = new RegExp(regi, "ig");
                        str = str.replace(re, newstr)
                    }
                    return str
                };

                let tr = function (el, e) {
                    if (el.prop("value") !== undefined) {
                        nameVal = el.val();
                    } else {
                        nameVal = el.text();
                    }
                    if (o.reg && o.reg !== '') {

                        nameVal = customReg(nameVal)

                    }
                    inser_trans(get_trans(nameVal), e);
                };
                elName.on(o.eventType, function (e) {
                    let el = $(this);
                    setTimeout(function () {
                        tr(el, e);
                    }, 50)
                });
                tr(elName);

                function get_trans() {
                    en_to_ru = {
                        'а': 'a',
                        'б': 'b',
                        'в': 'v',
                        'г': 'h',
                        'ґ': 'g',
                        'д': 'd',
                        'е': 'e',
                        'є': 'ie',
                        'ё': 'jo',
                        'ж': 'zh',
                        'з': 'z',
                        'и': 'y',
                        'і': 'i',
                        'ї': 'i',
                        'й': 'i',
                        'к': 'k',
                        'л': 'l',
                        'м': 'm',
                        'н': 'n',
                        'о': 'o',
                        'п': 'p',
                        'р': 'r',
                        'с': 's',
                        'т': 't',
                        'у': 'u',
                        'ф': 'f',
                        'х': 'kh',
                        'ц': 'ts',
                        'ч': 'ch',
                        'ш': 'sh',
                        'щ': 'shch',
                        'ъ': '',
                        'ы': 'y',
                        'ь': '',
                        'э': 'e',
                        'ю': 'iu',
                        'я': 'ia',

                        'і': 'i',
                        'ї': 'i',

                        'А': 'A',
                        'Б': 'B',
                        'В': 'V',
                        'Г': 'H',
                        'Ґ': 'G',
                        'Д': 'D',
                        'Е': 'E',
                        'Ё': 'Jo',
                        'Ж': 'Zh',
                        'З': 'Z',
                        'И': 'Y',
                        'Й': 'Y',
                        'К': 'K',
                        'Л': 'L',
                        'М': 'M',
                        'Н': 'N',
                        'О': 'O',
                        'П': 'P',
                        'Р': 'R',
                        'С': 'S',
                        'Т': 'T',
                        'У': 'U',
                        'Ф': 'F',
                        'Х': 'Kh',
                        'Ц': 'Ts',
                        'Ч': 'Ch',
                        'Ш': 'Sh',
                        'Щ': 'Shch',
                        'Ъ': '',
                        'Ы': 'Y',
                        'Ь': '',
                        'Э': 'E',
                        'Ю': 'Yu',
                        'Я': 'Ya',
                        '’': '',

                        'І': 'I',
                        'Ї': 'Yi',
                        'Є': 'Ye'
                    };


                    nameVal = trim(nameVal);
                    nameVal = nameVal.split("");

                    let trans = String();


                    for (let i = 0; i < nameVal.length; i++) {
                        for (let key in en_to_ru) {
                            let val = en_to_ru[key];
                            if (key === nameVal[i]) {
                                trans += val;
                                break;
                            } else if (key === "Є") {
                                trans += nameVal[i]
                            }

                        }

                    }

                    return trans;
                }

                function trim(string) {
                    //Удаляем пробел в начале строки и ненужные символы
                    string = string.replace(/(^\s+)|'|"|=|`|~|<|>|!|\||@|#|$|%|^|\^|\$|\\|\/|&|\*|\(|\)|\|\/|;|\+|№|,|\?|:|{|}|\[|]/g, "");

                    // удаляем пробелы
                    // console.log(`[\\s|${o.replaceSpaces}]+`);
                    string = string.replace(new RegExp(`[\\s${o.replaceSpaces}]+`, 'g'), o.replaceSpaces);

                    //Делает заглавную букву в верхний регистр
                    string = string.split(" ").map(function (i) {
                        if (i === "") {
                            return "";
                        }
                        return i[0].toUpperCase() + i.substring(1)
                    }).join(" ");
                    return string;

                }
            })
        },
        disable: function () {
            $(this).data({
                status: false
            })
        },
        enable: function () {
            $(this).data({
                status: true
            })
        }
    };
    $.fn.liTranslit = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Метод ' + method + ' в jQuery.liTranslit не существует');
        }
    };
})($);
