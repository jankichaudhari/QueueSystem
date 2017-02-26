/**
 * js to display correct form on customer type selection
 */
var validate = function (value, name, selector) {
    if (!value || (value === undefined) || (value == 'undefined')) {
        selector.html('Invalid ' + name + '!');
        return false;
    }

    return true;
};


$(document).ready(function () {
    //Hide all customer forms
    $('.customer').hide();

    //display html as per customer type
    $('.create_customer .customerType').on('change', function () {

        var idVal = $(this).attr("id");
        var type = $.trim($("label[for='" + idVal + "']").text().toLowerCase());
        $('.customer').hide();
        $('#' + type).show();
    });

    //validation before submit form
    $(".create_customer .form_customer").submit(function () {
        //service selection
        var service = $("input[name='service']:checked").val();
        if (!validate(service, 'Service', $('#msg_service'))) {
            return false;
        }

        //customer type selection
        var customerType = $("input[name='customerType']:checked").val();
        if (!validate(customerType, 'Customer Type', $('#msg_types'))) {
            return false;
        }

        //customer types form
        var customerName = $.trim($("label[for='" + 'type_' + customerType + "']").text().toLowerCase());
        switch (customerName) {
            case 'citizen':
                var firstname = $('#firstname').val();
                if (!validate(firstname, 'First name', $('#msg_firstname'))) {
                    return false;
                }
                break;
            case 'organisation':
                var name = $('#name').val();
                if (!validate(name, 'Organisation name', $('#msg_name'))) {
                    return false;
                }
                break;
        }

        return true;

    });
});