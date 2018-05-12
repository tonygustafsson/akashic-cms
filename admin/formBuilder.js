(function () {
    let form = document.getElementById('products');

    form.addEventListener('submit', e => {
        e.preventDefault();

        fetch(form.action, {
            method: 'post',
            body: new FormData(form)
        })
        .then(response => {
            return response.json();
        })
        .then(response => {
            console.log(response);
        });
    });

    fetch('../schemas/product.json')
        .then(response => {
            return response.json();
        })
        .then(json => {
            let formHtml = "";

            Object.keys(json.fieldsets).forEach(fieldsetName => {
                let fieldset = json.fieldsets[fieldsetName];

                formHtml += "<fieldset>";
                formHtml += `<legend>${fieldset.title}</legend>`;

                Object.keys(fieldset.fields).forEach(fieldName => {
                    let field = fieldset.fields[fieldName];

                    formHtml += `<label for="akashic-${fieldName}">${field.title}</label>`;

                    switch (field.formType) {
                        case "textarea":
                            formHtml += "<textarea";
                            break;
                        case "select":
                            formHtml += "<select";
                            break;
                        case "range":
                            formHtml += `<div id="range-value-akashic-${fieldName}">${field.default}/${field.maxValue}</div>`;
                            formHtml += "<input";
                            break;
                        default:
                            formHtml += "<input";
                    }
    
                    formHtml += ` name="akashic-${fieldName}" `;
                    formHtml += ` id="akashic-${fieldName}" `;
    
                    if (field.required) {
                        //formHtml += ` required `;
                    }
    
                    if (field.className) {
                        formHtml += ` class="${field.className}" `;
                    }
    
                    if (field.minLength) {
                        //formHtml += ` minlength="${field.minLength}" `;
                    }
    
                    if (field.maxLength) {
                        //formHtml += ` maxlength="${field.maxLength}" `;
                    }
    
                    if (field.minValue) {
                        //formHtml += ` min="${field.minValue}" `;
                    }
    
                    if (field.maxValue) {
                        //formHtml += ` max="${field.maxValue}" `;
                    }
    
                    if (field.default && field.formType != "checkbox" && field.formType != "select") {
                        formHtml += ` value="${field.default}" `;
                    }
    
                    if (field.placeholder) {
                        formHtml += ` placeholder="${field.placeholder}" `;
                    }
    
                    switch (field.formType) {
                        case "number":
                            formHtml += ` type="number" `;
                            break;
                        case "password":
                            formHtml += ` type="password" `;
                            break;
                        case "checkbox":
                            formHtml += ` type="checkbox" ${field.default && field.default === true ? ' checked ' : ''} `;
                            break;
                        case "textarea":
                            break;
                        case "select":
                            formHtml += ">";
                            break;
                        case "range":
                            formHtml += ` type="range" `;
                            break;
                        default:
                            formHtml += ` type="text" `;
                    }
    
                    switch (field.formType) {
                        case "textarea":
                            formHtml += `>${field.default}`;
                            formHtml += "</textarea>";
                            break;
                        case "select":
                            if (field.values) {
                                field.values.forEach(val => {
                                    formHtml += `<option value="${val}" ${val == field.default ? 'selected': ''}>${val}</option>`;
                                });
                            }
    
                            formHtml += "</select>";
                            break;
                        default:
                            formHtml += "/>";
                    }
                });

                formHtml += "</fieldset>";
            });

            if (json.createSubmitTitle) {
                formHtml += `<button type="submit">${json.createSubmitTitle}</button>`;
            }

            return formHtml;
        })
        .then(formHtml => {
            form.innerHTML = formHtml;

            document.dispatchEvent(new CustomEvent("FormCreated"));
        });
})();