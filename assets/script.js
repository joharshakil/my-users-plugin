jQuery(document).ready(function($) {
    $('.user-link').on('click', function(e) {
        e.preventDefault();
        const userId = $(this).data('id');

        $.post(MyUsersPlugin.ajax_url, {
            action: 'fetch_user_details',
            user_id: userId,
        }, function(response) {
            if (response.success) {
                $('#user-details').html('<pre>' + JSON.stringify(response.data, null, 2) + '</pre>');
            } else {
                $('#user-details').html('<p>Error fetching details.</p>');
            }
        });
    });
});
