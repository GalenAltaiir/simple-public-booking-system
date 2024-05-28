var host = window.location.hostname;

// normally this would be an ENV in node or similar, but for the sake of this example, I will just hardcode it here
var yourToken = "avcdefghijklmnopqrstuvwxyz";
console.log(host);

$(document).ready(function () {
  // Initialize the date and time picker
  var twoMonthsFromNow = new Date();
  twoMonthsFromNow.setMonth(twoMonthsFromNow.getMonth() + 2);

  $("#appointment-date").flatpickr({
    dateFormat: "Y-m-d H:i", // 24-hour clock
    maxDate: twoMonthsFromNow,
    disable: [
      function (date) {
        // Disable weekends
        return date.getDay() === 0 || date.getDay() === 6;
      },
    ],
    minDate: "today",
    enableTime: true,
    time_24hr: true, // 24-hour clock
    minTime: "08:00",
    maxTime: "17:00",
    minuteIncrement: 30, // Minutes increase in 30s
    // Disable dates that are already booked
    onChange: function (selectedDates, dateStr, instance) {
      if (selectedDates.length === 0) {
        $("#appointment-date-error").text("Please select a date and time");
        $('button[type="submit"]')
          .prop("disabled", true)
          .addClass("bg-gray-300 hover:bg-gray-300 cursor-not-allowed");
      } else {
        $("#appointment-date-error").text("");
        $('button[type="submit"]')
          .prop("disabled", false)
          .removeClass("bg-gray-300 hover:bg-gray-300 cursor-not-allowed");

        $.ajax({
          url: "http://"+host+"/api/v1/available-times",
          type: "GET",
          headers: {
            'Authorization': 'Bearer ' + yourToken,
        },
          success: function (data) {
            var date = new Date(dateStr);
            var formattedDate =
              date.getFullYear() +
              "-" +
              ("0" + (date.getMonth() + 1)).slice(-2) +
              "-" +
              ("0" + date.getDate()).slice(-2);
            var formattedTime =
              ("0" + date.getHours()).slice(-2) +
              ":" +
              ("0" + date.getMinutes()).slice(-2) +
              ":" +
              "00";
            var currentSlot = formattedDate + " " + formattedTime;

            var isTaken = data.some(function (slot) {
              var bookedSlots = slot.date + " " + slot.time;
              return currentSlot === bookedSlots;
            });

            if (isTaken) {
              $('button[type="submit"]')
                .prop("disabled", true)
                .addClass("bg-gray-300 hover:bg-gray-300 cursor-not-allowed");
              $("#appointment-date-error").text(
                "Date and time is already taken. Please select another date and time"
              );
            }
          },
          error: function (jqXHR, textStatus, errorThrown) {
            console.log("An error occurred:", errorThrown);
          },
        });
      }
    },
  });

  // default form state

  $('button[type="submit"]')
    .prop("disabled", true)
    .addClass("bg-gray-300 hover:bg-gray-300 cursor-not-allowed");

  // Form validation
  $(
    "#first-name, #last-name, #phone-number, #email-address, #appointment-date"
  ).on("input change", function (event) {
    event.preventDefault();

    var firstName = $("#first-name").val();
    var lastName = $("#last-name").val();
    var phoneNumber = $("#phone-number").val().replace(/\D/g, "");
    var emailAddress = $("#email-address").val();
    var dateStr = $("#appointment-date").val();

    // Clear all error messages
    $(".error-message").text("");

    // Check all fields
    if (firstName.length < 2) {
      $("#first-name-error").text("First name must be at least 2 characters");
    } else if (lastName.length < 2) {
      $("#last-name-error").text("Last name must be at least 2 characters");
    } else if (
      !/^(?:(?:00)?44|0)7(?:[45789]\d{2}|624)\d{6}$/.test(phoneNumber)
    ) {
      $("#phone-number-error").text(
        "Please enter a valid UK mobile phone number"
      );
    } else if (!/^\S+@\S+\.\S+$/.test(emailAddress)) {
      $("#email-address-error").text("Please enter a valid email address");
    } else if (dateStr.length === 0) {
      $("#appointment-date-error").text("Please select a date and time");
    } else {
      // If all checks pass, enable the submit button
      $('button[type="submit"]')
        .prop("disabled", false)
        .removeClass("bg-gray-300 hover:bg-gray-300 cursor-not-allowed");
      return;
    }

    // If any check fails, disable the submit button
    $('button[type="submit"]')
      .prop("disabled", true)
      .addClass("bg-gray-300 hover:bg-gray-300 cursor-not-allowed");
  });

  // Form submission handler
  $("form").on("submit", function (event) {
    event.preventDefault();

    var firstName = $("#first-name").val();
    var lastName = $("#last-name").val();
    var phoneNumber = $("#phone-number").val().replace(/\D/g, "");
    var emailAddress = $("#email-address").val();
    var dateStr = $("#appointment-date").val();

    var data = {
      firstName: firstName,
      lastName: lastName,
      phoneNumber: phoneNumber,
      emailAddress: emailAddress,
      dateStr: dateStr,
    };

    $.ajax({
      url: "http://" + host + "/api/v1/create-appointment",
      type: "POST",
      data: data,
      success: function (response) {
        alert(
          "Form submitted successfully. Response: " + JSON.stringify(response)
        );

        if (response.status === 422) {
          $('#submit-form').prop("disabled", true).addClass("bg-gray-300 hover:bg-gray-300 cursor-not-allowed");
          $("#appointment-date-error").text(
            "Seems you've already booked a meeting today. Please book another one tomorrow."
          );
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log("An error occurred:", errorThrown);
      },
    });
  });
});
