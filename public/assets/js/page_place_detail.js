(function ($) {
    'use strict';

    $('.star-item').click(function () {
        let value = $(this).attr('data-value');
        $('input[name=score]').val(value);
    });

    $('#submit_review').submit(function (event) {
        event.preventDefault();
        let $form = $(this);
        let formData = getFormData($form);
        $('#btn_submit_review').html(`<i class="fa fa-spinner fa-spin"></i>`).prop('disabled', true);
        $.ajax({
            type: "POST",
            url: "/review",
            data: formData,
            dataType: 'json',
            success: function (response) {
                $('#btn_submit_review').html('Submit').prop('disabled', false);
                console.log("review:", response);
                if (response.code === 200) {
                    location.reload();
                } else {
                    $('#review_error').show().text(response.message);
                }
            },
            error: function (jqXHR) {
                $('#btn_submit_review').html('Submit').prop('disabled', false);
                var response = $.parseJSON(jqXHR.responseText);
                if (response.message) {
                    alert(response.message);
                }
            }
        });
    });

})(jQuery);
