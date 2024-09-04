<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporting & Analytics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
      integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="../style.css" rel="stylesheet">
</head>
<body>
    <?php include 'SAnavbar.php'; ?>
    <div class="container mt-5">
      <h1 class="fw-bold mb-3">Reporting & Analytics</h1>

      <div class="card mb-4">
        <div class="card-header">
          <h2 class="h4 mb-0">Room Usage Report</h2>
        </div>
        <div class="card-body">
          <p>
            Generates reports on room usage, including total bookings, peak
            usage times, and user activity.
          </p>
          <form id="roomUsageForm" class="row g-3">
            <div class="col-md-12 col-lg-4">
              <label for="usageRoom" class="form-label">Room</label>
              <select class="form-select" id="usageRoom">
                <option value="">All Rooms</option>
                <option value="Boardroom A">Boardroom A</option>
                <option value="Conference Room B">Conference Room B</option>
                <option value="Meeting Room C">Meeting Room C</option>
                <option value="Executive Suite">Executive Suite</option>
                <option value="Training Room">Training Room</option>
              </select>
            </div>
            <div class="col-md-12 col-lg-4">
              <label for="usageDateRange" class="form-label">Date Range</label>
              <div class="input-daterange input-group" id="datepicker">
                <input
                  type="text"
                  class="input-sm form-control"
                  name="start"
                  placeholder="Start Date"
                />
                <span class="input-group-text">to</span>
                <input
                  type="text"
                  class="input-sm form-control"
                  name="end"
                  placeholder="End Date"
                />
              </div>
            </div>
            <div class="col-md-12 col-lg-4">
            <label class="form-label">&nbsp;</label>
    <div class="d-grid gap-2 d-md-flex">
      <button
        type="button"
        class="btn btn-outline-danger"
        onclick="generateRoomUsageReport()"
      >
        Generate Report
      </button>
      <button
        type="button"
        class="btn btn-danger"
        onclick="generateRoomUsageReport()"
      >
        Export
      </button>
    </div>
            </div>
          </form>
          <div class="row mb-4">
            <div class="col-md-6 chart-wrapper">
              <br />
              <h3 class="h5 mb-3">Total Bookings</h3>
              <div class="chart-container">
                <canvas id="bookingsChart"></canvas>
              </div>
            </div>
            <!---<div class="col-md-4 chart-wrapper">
              <br />
              <h3 class="h5 mb-3">User Activity</h3>
              <div class="chart-container">
                <canvas id="roomUsageChart"></canvas>
              </div>
            </div>!-->
            <div class="col-md-6 chart-wrapper">
              <br />
              <h3 class="h5 mb-3">Peak Usage Time</h3>
              <div class="chart-container">
                <canvas id="userActivityChart"></canvas>
              </div>
            </div>
          </div>
          <div class="card-header">
            <h2 class="h5 mb-0">Boardroom A</h2>
          </div>

          <div id="roomUsageResult" class="mt-4">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Total Bookings</th>
                  <th>Peak Usage Time</th>
                  <th>User Activity</th>
                </tr>
              </thead>
              <tbody id="reportTableBody">
                <tr>
                  <td>09/01/2024</td>

                  <td>8</td>
                  <td>3 PM</td>
                  <td>High</td>
                </tr>
                <tr>
                  <td>09/02/2024</td>

                  <td>5</td>
                  <td>2 PM</td>
                  <td>Medium</td>
                </tr>
                <tr>
                  <td>09/03/2024</td>

                  <td>12</td>
                  <td>10 AM</td>
                  <td>High</td>
                </tr>
                <tr>
                  <td>09/04/2024</td>

                  <td>3</td>
                  <td>4 PM</td>
                  <td>Low</td>
                </tr>
                <tr>
                  <td>09/05/2024</td>

                  <td>7</td>
                  <td>1 PM</td>
                  <td>Medium</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
      integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    ></script>
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"
      integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    ></script>
    <script>
      $(document).ready(function () {
        $(".input-daterange").datepicker({
          format: "mm/dd/yyyy",
          autoclose: true,
        });
      });

      function extractTableData() {
        const labels = [];
        const bookingsData = [];
        const peakUsageData = [];
        const userActivityData = [];

        const rows = document.querySelectorAll("#reportTableBody tr");
        rows.forEach((row) => {
          const cells = row.querySelectorAll("td");
          labels.push(cells[0].innerText);
          bookingsData.push(parseInt(cells[1].innerText)); // Ensure correct index
          peakUsageData.push(cells[2].innerText); // Ensure correct index
          userActivityData.push(cells[3].innerText); // Ensure correct index
        });
        return {
          labels,
          bookingsData,
          peakUsageData,
          userActivityData,
        };
      }

      document.addEventListener("DOMContentLoaded", function () {
        const data = extractTableData();

        var ctxBookings = document
          .getElementById("bookingsChart")
          .getContext("2d");
        new Chart(ctxBookings, {
          type: "bar",
          data: {
            labels: data.labels,
            datasets: [
              {
                label: "Total Bookings",
                data: data.bookingsData,
                backgroundColor: "rgba(75, 192, 192, 0.2)",
                borderColor: "rgba(75, 192, 192, 1)",
                borderWidth: 1,
              },
            ],
          },
          options: {
            responsive: true,
            scales: {
              y: {
                beginAtZero: true,
              },
            },
          },
        });

        var ctxUserActivity = document
          .getElementById("userActivityChart")
          .getContext("2d");
        new Chart(ctxUserActivity, {
          type: "line",
          data: {
            labels: data.labels,
            datasets: [
              {
                label: "User Activity",
                data: data.userActivityData.map((activity) => {
                  switch (activity) {
                    case "High":
                      return 3;
                    case "Medium":
                      return 2;
                    case "Low":
                      return 1;
                    default:
                      return 0;
                  }
                }),
                backgroundColor: [
                  "rgba(255, 99, 132, 0.2)",
                  "rgba(54, 162, 235, 0.2)",
                  "rgba(75, 192, 192, 0.2)",
                ],
                borderColor: [
                  "rgba(255, 99, 132, 1)",
                  "rgba(54, 162, 235, 1)",
                  "rgba(75, 192, 192, 1)",
                ],
                borderWidth: 1,
              },
            ],
          },
          options: {
            responsive: true,
          },
        });
      });
    </script>
</body>
</html>