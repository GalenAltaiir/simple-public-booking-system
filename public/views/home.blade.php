<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="/public/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.9/dist/flatpickr.min.js"></script>


</head>

<body>
    <!-- Frontend based on a Tailwindui.com template -->

    <div class="container mx-auto p-4 max-w-7xl">
        <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
            <aside class="px-2 py-6 sm:px-6 lg:col-span-3 lg:px-0 lg:py-0">
                <nav class="space-y-1">
                    <a href="#"
                        class="bg-gray-50 text-indigo-700 hover:bg-white hover:text-indigo-700 group flex items-center rounded-md px-3 py-2 text-sm font-medium"
                        aria-current="page">
                        <svg class="text-indigo-500 group-hover:text-indigo-500 -ml-1 mr-3 h-6 w-6 flex-shrink-0"
                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="truncate">Book an Appointment</span>
                    </a>
                </nav>
            </aside>

            <div class="space-y-6 sm:px-6 lg:col-span-9 lg:px-0">
                <form action="" method="POST" id="appointment-form">
                    <div class="shadow sm:overflow-hidden sm:rounded-md">
                        <div class="space-y-6 bg-white px-4 py-6 sm:p-6">
                            <div>
                                <h3 class="text-base font-semibold leading-6 text-gray-900">Hello, please book your
                                    appointment below</h3>
                                <p class="mt-1 text-sm text-gray-500">You can book 1 appointment per day.</p>
                            </div>

                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="first-name"
                                        class="block text-sm font-medium leading-6 text-gray-900">First name</label>
                                    <input type="text" name="first-name" id="first-name" autocomplete="given-name"
                                        class="mt-2 block w-full rounded-md border-0 px-3 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    <span id="first-name-error" class="error-message text-sm text-red-300"></span>
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="last-name"
                                        class="block text-sm font-medium leading-6 text-gray-900">Last name</label>
                                    <input type="text" name="last-name" id="last-name" autocomplete="family-name"
                                        class="mt-2 block w-full rounded-md border-0 px-3 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    <span id="last-name-error" class="error-message text-sm text-red-300"></span>
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="phone-number"
                                        class="block text-sm font-medium leading-6 text-gray-900">Phone (Mobile)</label>
                                    <input type="text" name="phone-number" id="phone-number" autocomplete="phone"
                                        class="mt-2 block w-full rounded-md border-0 px-3 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    <span id="phone-number-error" class="error-message text-sm text-red-300"></span>
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="email-address"
                                        class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
                                    <input type="text" name="email-address" id="email-address" autocomplete="email"
                                        class="mt-2 block w-full rounded-md border-0 px-3 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    <span id="email-address-error" class="error-message text-sm text-red-300"></span>
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="appointment-date"
                                        class="block text-sm font-medium leading-6 text-gray-900">Appointment
                                        Date</label>
                                    <input type="text" placeholder="Select Day" id="appointment-date"
                                        name="appointment-date"
                                        class="mt-2 block w-full rounded-md border-0 px-3 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    <span id="appointment-date-error" class="error-message text-sm text-red-300"></span>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">
                            <button type="submit" id="submit-form"
                                class="inline-flex justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
