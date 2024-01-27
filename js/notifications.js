function fetchNotifications() {
    $.ajax({
        url: '../includes/notifications.php',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            console.log(data);
            updateNotificationDropdown(data);
        },
        error: function (error) {
            console.error('Error fetching notifications:', error);
        }
    });
}

function updateNotificationDropdown(notifications) {
    const dropdown = $('.notification-dropdown');
    dropdown.empty();

    if (notifications.length === 0) {
        // Display a message when there are no notifications
        dropdown.append('<div class="notification-item"><p style="text-align:center">Aucune nouvelle notification</p></div>');
    } else {
        notifications.forEach(function (notification) {
            dropdown.append(`
                <div class="notification-item">
                    <p>${notification.message}</p>
                </div>
            `);
        });
    }

    dropdown.show();

    // Attach the click event listener to the document to close the dropdown
    $(document).on('click', function (event) {
        if (!$(event.target).closest('.notification-icon').length && !$(event.target).closest('.notification-dropdown').length) {
            dropdown.hide();
        }
    });
}

// Click event for the notification icon
$('.notification-icon').on('click', function () {
    fetchNotifications();
});
