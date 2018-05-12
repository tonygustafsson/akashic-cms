(function () {
    let form = document.getElementById('products');

    fetch('../schemas/product.json')
        .then(response => {
            return response.json();
        })
        .then(json => {
            let formInfo = "";

            Object.keys(json.fields).forEach(field => {
                let fieldHtml = "",
                    settings = json.fields[field];

                fieldHtml += `<label for="akashic-${field}">${settings.title}</label>`;

                switch (settings.formType) {
                    case "textarea":
                        fieldHtml += "<textarea";
                        break;
                    case "select":
                        fieldHtml += "<select";
                        break;
                    default:
                        fieldHtml += "<input";
                }

                fieldHtml += ` name="akashic-${field}" `;
                fieldHtml += ` id="akashic-${field}" `;

                if (settings.required) {
                    fieldHtml += ` required `;
                }

                if (settings.className) {
                    fieldHtml += ` class="${settings.className}" `;
                }

                if (settings.minLength) {
                    fieldHtml += ` minlength="${settings.minLength}" `;
                }

                if (settings.maxLength) {
                    fieldHtml += ` maxlength="${settings.maxLength}" `;
                }

                if (settings.minValue) {
                    fieldHtml += ` min="${settings.minValue}" `;
                }

                if (settings.maxValue) {
                    fieldHtml += ` max="${settings.maxValue}" `;
                }

                if (settings.default && settings.formType != "checkbox" && settings.formType != "select") {
                    fieldHtml += ` value="${settings.default}" `;
                }

                if (settings.placeholder) {
                    fieldHtml += ` placeholder="${settings.placeholder}" `;
                }

                switch (settings.formType) {
                    case "number":
                        fieldHtml += ` type="number" `;
                        break;
                    case "checkbox":
                        fieldHtml += ` type="checkbox" ${settings.default && settings.default === true ? ' checked ' : ''} `;
                        break;
                    case "textarea":
                        break;
                    case "select":
                        fieldHtml += ">";
                        break;
                    case "range":
                        fieldHtml += ` type="range" `;
                        break;
                    default:
                        fieldHtml += ` type="text" `;
                }

                switch (settings.formType) {
                    case "textarea":
                        fieldHtml += `>${settings.default}`;
                        fieldHtml += "</textarea>";
                        break;
                    case "select":
                        if (settings.values) {
                            settings.values.forEach(val => {
                                fieldHtml += `<option value="${val}" ${val == settings.default ? 'selected': ''}>${val}</option>`;
                            });
                        }

                        fieldHtml += "</select>";
                        break;
                    default:
                        fieldHtml += "/>";
                }

                formInfo += fieldHtml;
            });

            console.log(formInfo);

            if (json.createSubmitTitle) {
                formInfo += `<button type="submit">${json.createSubmitTitle}</button>`;
            }

            return formInfo;
        })
        .then(formInfo => {
            form.innerHTML = formInfo;
        });
})();