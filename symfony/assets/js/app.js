const $ = require('jquery');
const Chart = require('chart.js');

window.j_q = $;

require('../css/app.css');
require('bootstrap/dist/css/bootstrap.css');
require('bootstrap');
require('webpack-jquery-ui/datepicker');
require('webpack-jquery-ui/css');
require('jquery-validation');

$(function() {
    $('.date-class').datepicker({
        dateFormat: 'yy-mm-dd',
        onSelect: function () {
            $(this).change();
        }
    });
});

$.validator.addMethod("synchronousRemote", function (value, element, param) {
    if (this.optional(element)) {
        return "dependency-mismatch";
    }

    var previous = this.previousValue(element);
    if (!this.settings.messages[element.name]) {
        this.settings.messages[element.name] = {};
    }
    previous.originalMessage = this.settings.messages[element.name].remote;
    this.settings.messages[element.name].remote = previous.message;

    param = typeof param === "string" && { url: param } || param;

    if (previous.old === value) {
        return previous.valid;
    }

    previous.old = value;
    const validator = this;
    const data = {};
    const valid = "pending";

    this.startRequest(element);
    data[element.name] = value;
    $.ajax($.extend(true, {
        url: param,
        async: false,
        mode: "abort",
        port: "validate" + element.name,
        dataType: "json",
        data: data,
        success: function (response) {
            validator.settings.messages[element.name].remote = previous.originalMessage;
            const valid = response.is_valid;
            if (valid) {
                const submitted = validator.formSubmitted;
                validator.prepareElement(element);
                validator.formSubmitted = submitted;
                validator.successList.push(element);
                delete validator.invalid[element.name];
                validator.showErrors();
            } else {
                const errors = {};
                const message = response || validator.defaultMessage(element, "remote");
                errors[element.name] = previous.message = $.isFunction(message) ? message(value) : message;
                validator.invalid[element.name] = true;
                validator.showErrors(errors);
            }
            previous.valid = valid;
            validator.stopRequest(element, valid);
        }
    }, param));
    return valid;
}, "Company symbol not found.");

$.validator.addMethod('customDate', function(value, element) {
    return this.optional(element) || /^\d\d\d\d-\d\d-\d\d$/.test(value);
}, "Please specify the date in YYYY-MM-DD format");

const renderError = function (labelFor, errorText) {
    let label = $('label[for="'+ labelFor +'"]');
    let input =$('input#' + labelFor);

    input.addClass('is-invalid');
    label.find('span.invalid-feedback').remove();

    let error = $('<span/>').addClass('invalid-feedback d-block')
        .html(
            $('<span/>')
                .addClass('d-block')
                .html(
                    $('<span/>')
                        .addClass('form-error-icon badge badge-danger text-uppercase')
                        .text('error')
                        .add(
                            $('<span/>')
                                .addClass('form-error-message')
                                .text(errorText)
                        )
                )
        ).clone();

    $(label).append(error);
};

$( "#company_form" ).validate({
    onkeyup: function(element, event) {
        var t = this;
        setTimeout(function() {
            // this is the default function
            var excludedKeys = [
                16, 17, 18, 20, 35, 36, 37,
                38, 39, 40, 45, 144, 225
            ];
            if (event.which === 9 && t.elementValue(element) === "" || $.inArray(event.keyCode, excludedKeys) !== -1) {
                return;
            } else if (element.name in t.submitted || element.name in t.invalid) {
                t.element(element);
            } // end default
        }, 3000);  // 3-second delay
    },
    rules: {
        'company_form_filter[symbol]': {
            required: true,
            synchronousRemote: {
                url: '/companies',
                delay: 1000,
                data: {
                    symbol: function () {
                        return $('#company_form_filter_symbol').val();
                    }
                }
            }
        },
        'company_form_filter[email]': {
            required: true,
            email: true
        },
        'company_form_filter[start_date]': {
            required: true,
            customDate: true,
        },
        'company_form_filter[end_date]': {
            required: true,
            customDate: true,
        },
    },
    errorPlacement: function(error, element) {
        renderError(element.attr('id'), error[0].outerText || 'Please fix this field');
    }
});


$(document).ready(function ($) {
    const data = $('#chart').data('items');

    if (!data) {
        return;
    }

    const ctx = document.getElementById('myChart').getContext('2d');

    const labels = data.map(function (i) {
        return i[0];
    });
    const values = data.map(function (i) {
        return i[5];
    });

    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels,
            datasets: [{
                label: 'My First dataset',
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: values
            }]
        },
    });
});

jQuery('#company_form').on('input change', function () {
    $(this).find('span.invalid-feedback').remove();
    $(this).find('.is-invalid').removeClass('is-invalid');
});
