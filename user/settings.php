<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Settings & Preferences</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"
    ></script>
    <link href="../style.css" rel="stylesheet">
</head>
<body>
      <?php include 'navbar.php'; ?>
    <div class="container mt-5">
    <h1 class="fw-bold mb-3">Settings & Preferences</h1>
    <form id="preferencesForm">
        <div class="mb-4">
        <h5 class="fw-bold">Notification Settings</h5>
        <div class="form-check">
            <input
            class="form-check-input"
            type="checkbox"
            id="bookingConfirmation"
            checked
            />
            <label class="form-check-label" for="bookingConfirmation">
            Booking Confirmation
            </label>
        </div>
        <div class="form-check">
            <input
            class="form-check-input"
            type="checkbox"
            id="reminderNotifications"
            />
            <label class="form-check-label" for="reminderNotifications">
            Booking Reminders
            </label>
        </div>
        <div class="form-check">
            <input
            class="form-check-input"
            type="checkbox"
            id="cancellationNotifications"
            />
            <label class="form-check-label" for="cancellationNotifications">
            Cancellation Notifications
            </label>
        </div>
        </div>
        <div class="mb-4">
        <h5 class="fw-bold">Default Booking Duration</h5>
        <select class="form-select" id="defaultDuration">
            <option value="60">Set Duration</option>
            <option value="60">1 hour</option>
            <option value="120">2 hours</option>
            <option value="120">3 hours</option>
            <option value="120">4 hours</option>
        </select>
        </div>
        <button type="submit" class="btn btn-success">Save Changes</button>
    </form>
    </div>
</body>
</html>
