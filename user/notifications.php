<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="../style.css" rel="stylesheet">
</head>
<body>
    <?php include 'navbar.php';
        $notifications = [
            [
                'id' => 1,
                'type' => 'booking_created',
                'message' => 'Your booking for Conference Room B on 2023-05-20 at 10:00 AM has been created.',
                'date' => '2023-05-18 09:30:00',
                'is_read' => false
            ],
            [
                'id' => 2,
                'type' => 'booking_updated',
                'message' => 'Your booking for Meeting Room C on 2023-05-22 has been updated to 2:00 PM.',
                'date' => '2023-05-19 14:15:00',
                'is_read' => false
            ],
            [
                'id' => 3,
                'type' => 'booking_cancelled',
                'message' => 'Your booking for Boardroom A on 2023-05-21 at 11:00 AM has been cancelled.',
                'date' => '2023-05-20 10:45:00',
                'is_read' => true
            ],
            [
                'id' => 4,
                'type' => 'reminder',
                'message' => 'Reminder: You have a booking for Training Room on 2023-05-23 at 3:00 PM.',
                'date' => '2023-05-23 14:00:00',
                'is_read' => false
            ]
        ];
        
        // Sort notifications by date (most recent first)
        usort($notifications, function($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });
    ?>
    <div class="container mt-5">
        <h1 class="fw-bold mb-3">Notifications</h1>
        <div id="notificationsContainer">
            <?php if (empty($notifications)): ?>
                <p>You have no notifications.</p>
            <?php else: ?>
                <?php foreach ($notifications as $notification): ?>
                    <div class="notification-item <?php echo $notification['is_read'] ? '' : 'unread'; ?>" data-notification-id="<?php echo $notification['id']; ?>">
                        <div class="notification-content" data-bs-toggle="modal" data-bs-target="#viewNotificationModal" data-notification-id="<?php echo $notification['id']; ?>">
                            <p class="mb-1"><?php echo htmlspecialchars($notification['message']); ?></p>
                            <p class="notification-date mb-0">
                                <?php echo date('F j, Y, g:i a', strtotime($notification['date'])); ?>
                            </p>
                        </div>
                        <span class="delete-notification" onclick="deleteNotification(event, <?php echo $notification['id']; ?>)">X</span>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- View Notification Modal -->
    <div class="modal fade" id="viewNotificationModal" tabindex="-1" aria-labelledby="viewNotificationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewNotificationModalLabel">Notification Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="notificationMessage"></p>
                    <p id="notificationDate" class="text-muted"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast container -->
    <div class="toast-container"></div>

    <script>
        // JavaScript to handle populating the view notification modal
        var viewNotificationModal = document.getElementById('viewNotificationModal')
        viewNotificationModal.addEventListener('show.bs.modal', function (event) {
            var notificationItem = event.relatedTarget
            var notificationId = notificationItem.getAttribute('data-notification-id')
            
            // Here you would typically fetch the notification data from the server
            // For this example, we'll just use the data we already have in the page
            var notification = <?php echo json_encode($notifications); ?>.find(n => n.id == notificationId);
            
            var modalBody = viewNotificationModal.querySelector('.modal-body')
            modalBody.querySelector('#notificationMessage').textContent = notification.message
            modalBody.querySelector('#notificationDate').textContent = 'Sent on: ' + new Date(notification.date).toLocaleString()

            // Here you would typically send a request to mark the notification as read
            console.log('Marking notification ' + notificationId + ' as read')
            
            // Update the UI to reflect that the notification has been read
            notificationItem.classList.remove('unread');
        })

        // Function to delete a notification
        function deleteNotification(event, notificationId) {
            event.stopPropagation(); // Prevent the modal from opening
            
            // Here you would typically send a request to delete the notification from the server
            console.log('Deleting notification ' + notificationId);
            
            // Remove the notification from the UI
            const notificationItem = document.querySelector(`.notification-item[data-notification-id="${notificationId}"]`);
            if (notificationItem) {
                notificationItem.remove();
            }

            // Check if there are any notifications left
            const remainingNotifications = document.querySelectorAll('.notification-item');
            if (remainingNotifications.length === 0) {
                const notificationsContainer = document.getElementById('notificationsContainer');
                notificationsContainer.innerHTML = '<p>You have no notifications.</p>';
            }
        }

        // Function to create and show a toast notification
        function showToast(message) {
            const toastContainer = document.querySelector('.toast-container');
            const toastElement = document.createElement('div');
            toastElement.classList.add('toast');
            toastElement.setAttribute('role', 'alert');
            toastElement.setAttribute('aria-live', 'assertive');
            toastElement.setAttribute('aria-atomic', 'true');
            
            toastElement.innerHTML = `
                <div class="toast-header">
                    <strong class="me-auto">New Notification</strong>
                    <small>Just now</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    ${message}
                </div>
            `;
            
            toastContainer.appendChild(toastElement);
            const toast = new bootstrap.Toast(toastElement);
            toast.show();
        }

        // Function to simulate random notifications
        function simulateNotification() {
            const notifications = <?php echo json_encode($notifications); ?>;
            const randomNotification = notifications[Math.floor(Math.random() * notifications.length)];
            showToast(randomNotification.message);
        }

        // Set interval to show random notifications every 10 seconds
        setInterval(simulateNotification, 10000);
    </script>
</body>
</html>