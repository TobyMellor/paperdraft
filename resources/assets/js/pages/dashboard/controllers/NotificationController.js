class NotificationController {
    // notificationContent is the message e.g. 'hello' (string)
    // type is the display type e.g. 'error' or 'success' (string)
    handleNotification(notificationContent, type, timeout = 7500) {
        var n = noty({
            text:   notificationContent,
            layout: 'topRight',
            type:   type
        });

        setTimeout(function() {
            n.close();
        }, timeout);
    }
}