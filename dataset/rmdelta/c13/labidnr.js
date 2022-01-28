'use strict'

import { default as ajaxTemplate } from "/e107_plugins/ajaxModules/Components/Template/ajaxTemplates.js";

(function () {

    window['ajaxTemplates'] = [];

    document.addEventListener('DOMContentLoaded', () => {

        const templates = document.querySelectorAll('div[data-ajax="template"]');
        templates.forEach((element, key) => {
            var templateOptions = {
                parseResponse: function (response) {
                    const data = response.data;
                    const dataset = response.data.dataset[0];
                    const records = data["records"];
                    const totalrecords = data["totalrecords"];
                    delete data.dataset;
                    delete data.records;
                    delete data.totalrecords;
                    return { data, dataset, records, totalrecords };
                },
            }
            window["ajaxTemplates"][key] = new ajaxTemplate(element, key, templateOptions);
        })

    });

})()