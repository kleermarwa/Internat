function fetchNotifications() {
    $.ajax({
        url: '../includes/notifications.php',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            updateNotificationDropdown(data);
        },
        error: function (error) {
            console.error('Error fetching notifications:', error);
        }
    });
}


function updateNotificationDropdown(notifications) {
    $('.notification-dropdown').empty();

    notifications.forEach(function (notification) {
        $('.notification-dropdown').append(`
            <div class="notification-item">
                <p>${notification.message}</p>
            </div>
        `);
    });

    $('.notification-dropdown').show();

    $(document).on('click', function (event) {
        if (!$(event.target).closest('.notification-icon').length && !$(event.target).closest('.notification-dropdown').length) {
            $('.notification-dropdown').hide();
        }
    });
}


$('.notification-icon').on('click', function () {
    fetchNotifications();
});
