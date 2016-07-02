$('.accept, .reject, .unanswer').click(function() {
    if ($(this).hasClass('accept')) {
        $('.accept, .reject').hide();
        $('.accepted, .estimate.admin .unanswer').show();
        $.get(estimateStatusUrl + 'accept');
    } else {
        if ($(this).hasClass('reject')) {
            $('.accept, .reject').hide();
            $('.rejected, .estimate.admin .unanswer').show();
            $.get(estimateStatusUrl + 'reject');
        } else {
            $('.accept, .reject').show();
            $('.accepted, .rejected, .unanswer').hide();
            $.get(estimateStatusUrl);
        }
    }
    return false;
});

$('.rejected, .accepted').click(function() {
    return false;
});