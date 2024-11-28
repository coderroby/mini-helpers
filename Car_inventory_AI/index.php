<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="https://images.squarespace-cdn.com/content/v1/524883b7e4b03fcb7c64e24c/1685041480038-AWYM7XXSYNHG53PL43L6/Squarespace+Favicon.jpg?format=1500w" sizes="32x32" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Listings</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom styling */
        .filter-sidebar {
            border-right: 1px solid #ccc;
            height: 100vh;
        }

        .filter-title {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .car-card {
            margin-bottom: 2rem;
        }

        .car-image {
            height: 200px;
            object-fit: cover;
        }

        .pagination {
            justify-content: center;
        }

        .no-results {
            text-align: center;
            margin-top: 2rem;
            font-size: 1.2rem;
            color: red;
        }
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar (Filters) -->
            <div class="col-md-3 filter-sidebar p-4">
                <h4 class="filter-title">Filters</h4>
                <div id="car-count">Cars found: 0</div>
                <div class="mb-3">
                    <label for="ddlSort" class="form-label">Sort By</label>
                    <select id="ddlSort" class="form-control">
                        <option value="0">Sort</option>
                        <option value="oldestentry">Sort: Arrival (most ancient)</option>
                        <option value="newestentry">Sort: Arrival (most recent)</option>
                        <option value="prices">Sort: Price</option>
                        <option value="prices-desc">Sort: Price descending</option>
                        <option value="make">Sort: Make</option>
                        <option value="make-desc">Sort: Make descending</option>
                        <option value="model">Sort: Model</option>
                        <option value="model-desc">Sort: Model descending</option>
                        <option value="year">Sort: Year</option>
                        <option value="year-desc">Sort: Year descending</option>
                    </select>
                </div>
                <div class="mb-3">
                    <select id="make-filter" class="form-select">
                        <option value="">All Makes</option>
                    </select>
                </div>
                <div class="mb-3">
                    <select id="model-filter" class="form-select">
                        <option value="">All Models</option>
                    </select>
                </div>
                <div class="mb-3">
                    <select id="yearMax" class="form-select">
                        <option value="">Maximum Year</option>
                    </select>
                </div>
                <div class="mb-3">
                    <select id="yearMin" class="form-select">
                        <option value="">Minimum Year</option>
                    </select>
                </div>
                <div class="mb-3">
                    <input type="number" id="max-price-filter" class="form-control" placeholder="Enter max price">
                </div>
                <div class="mb-3">
                    <input type="number" id="min-price-filter" class="form-control" placeholder="Enter min price">
                </div>
                <div class="mb-3">
                    <select id="transmission-filter" class="form-select">
                        <option value="">All Transmission</option>
                    </select>
                </div>
                <div class="mb-3">
                    <select id="body-filter" class="form-select">
                        <option value="">All Body</option>
                    </select>
                </div>
                <div class="mb-3">
                    <select id="color-filter" class="form-select">
                        <option value="">All Color</option>
                    </select>
                </div>

                <div class="mb-3">
                    <!-- <button id="apply-filters" class="btn btn-primary w-100">Apply Filters</button> -->
                    <button id="reset-btn">Reset Filters</button>
                </div>
            </div>

            <!-- Main Content (Search and Listings) -->
            <div class="col-md-9 p-4">
                <!-- Search Bar -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <input type="text" id="search-bar" class="form-control" placeholder="Search by Year, Make or Model">
                    </div>
                </div>

                <!-- Vehicle Listings (Grid View) -->
                <div class="row" id="car-listings">
                    <!-- Car cards will be dynamically inserted here -->
                </div>

                <!-- Pagination -->
                <nav>
                    <ul class="pagination" id="pagination">
                        <!-- Pagination items will be dynamically inserted here -->
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <script>

        document.addEventListener('DOMContentLoaded', function() {
            // Fetch car data
            fetch('cars_formatted.json')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(carData => {
                    processCarData(carData);
                })
                .catch(error => {
                    console.error('Error fetching car data:', error);
                });
        });

        function processCarData (data) {
            let carData = data;
            let filteredCars = carData;
            const carsPerPage = 6;
            let currentPage = 1;

            // Function to display cars based on current page
            function displayCars(cars, page = 1) {
                const carListings = document.getElementById('car-listings');
                carListings.innerHTML = '';

                const start = (page - 1) * carsPerPage;
                const end = start + carsPerPage;
                const carsToShow = cars.slice(start, end);

                if (carsToShow.length === 0) {
                    carListings.innerHTML = `<div class="no-results">No results found.</div>`;
                    return;
                }

                carsToShow.forEach(car => {
                    carListings.innerHTML += `
                        <div class="col-md-4 car-card">
                            <div class="card">
                                <img src="${car.photo}" class="card-img-top car-image" alt="${car.maker} ${car.model}">
                                <div class="card-body">
                                    <h5 class="card-title">${car.maker} ${car.model}</h5>
                                    <p class="card-text">Price: $${car.car_price}</p>
                                    <p class="card-text">Year: ${car.car_year}</p>
                                    <p class="card-text">Mileage: ${car.car_mileage} KM</p>
                                </div>
                            </div>
                        </div>
                    `;
                });

                displayPagination(cars.length, page);
            }

            // Function to display pagination with first, previous, next, and last page number
            function displayPagination(totalCars, currentPage) {
                const pagination = document.querySelector('.pagination');
                pagination.innerHTML = '';

                const totalPages = Math.ceil(totalCars / carsPerPage);

                // Show First, Previous, Next, and Last page with a range of 5 pages
                const maxPagesToShow = 5; // Number of pages to display in the middle
                let startPage, endPage;

                // Calculate the page range to display
                if (totalPages <= maxPagesToShow) {
                    startPage = 1;
                    endPage = totalPages;
                } else {
                    const pageOffset = Math.floor(maxPagesToShow / 2);
                    if (currentPage <= pageOffset) {
                        startPage = 1;
                        endPage = maxPagesToShow;
                    } else if (currentPage + pageOffset >= totalPages) {
                        startPage = totalPages - maxPagesToShow + 1;
                        endPage = totalPages;
                    } else {
                        startPage = currentPage - pageOffset;
                        endPage = currentPage + pageOffset;
                    }
                }

                // Create First page button
                pagination.innerHTML += `
                    <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                        <a class="page-link" href="#" data-page="1">1</a>
                    </li>
                `;

                // Create Previous page button
                pagination.innerHTML += `
                    <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                        <a class="page-link" href="#" data-page="${currentPage - 1}">←</a>
                    </li>
                `;

                // Create pagination range (5 pages)
                for (let i = startPage; i <= endPage; i++) {
                    pagination.innerHTML += `
                        <li class="page-item ${i === currentPage ? 'active' : ''}">
                            <a class="page-link" href="#" data-page="${i}">${i}</a>
                        </li>
                    `;
                }

                // Create Next page button
                pagination.innerHTML += `
                    <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                        <a class="page-link" href="#" data-page="${currentPage + 1}">→</a>
                    </li>
                `;

                // Create Last page button with totalPages number
                pagination.innerHTML += `
                    <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                        <a class="page-link" href="#" data-page="${totalPages}">${totalPages}</a>
                    </li>
                `;
            }
            
            // Function to get unique values for dropdowns
            function getUniqueValues(key, data) {
                return [...new Set(data.map(item => item[key]))];
            }

            // Filter cars based on selected values dynamically
            function filterCars() {
                let maker = document.getElementById('make-filter').value.toLowerCase();
                let model = document.getElementById('model-filter').value.toLowerCase();
                let year_min = document.getElementById('yearMin').value;
                let year_max = document.getElementById('yearMax').value;
                let max_car_price = document.getElementById('max-price-filter').value;
                let min_car_price = document.getElementById('min-price-filter').value;
                let car_transmission = document.getElementById('transmission-filter').value.toLowerCase();
                let car_exterior_color = document.getElementById('color-filter').value.toLowerCase();
                let car_body = document.getElementById('body-filter').value.toLowerCase();

                year_min = year_min === 0 ? null : parseInt(year_min);
                year_max = year_max === 0 ? null : parseInt(year_max);  
                
                // Start with all cars
                filteredCars = carData.filter(car => {
                    return (!maker || car.maker.toLowerCase().includes(maker)) &&
                        (!model || car.model.toLowerCase().includes(model)) &&
                        (!max_car_price || car.car_price <= max_car_price) &&
                        (!min_car_price || car.car_price >= min_car_price) &&
                        (!year_min || car.car_year >= year_min) &&
                        (!year_max || car.car_year <= year_max) &&
                        (!car_transmission || car.car_transmission.toLowerCase().includes(car_transmission)) &&
                        (!car_exterior_color || car.car_exterior_color.toLowerCase().includes(car_exterior_color)) &&
                        (!car_body || car.car_body.toLowerCase().includes(car_body));
                });

                currentPage = 1;
                displayCars(filteredCars, currentPage);
                updateCarCount(filteredCars.length);
            }

            // Reset Filters and Re-populate
            function resetBtn() {
                document.getElementById('make-filter').value = "";
                document.getElementById('model-filter').value = "";
                document.getElementById('yearMin').value = "0";
                document.getElementById('yearMax').value = "0";
                document.getElementById('max-price-filter').value = "";
                document.getElementById('min-price-filter').value = "";
                document.getElementById('transmission-filter').value = "";
                document.getElementById('body-filter').value = "";
                document.getElementById('color-filter').value = "";

                populateFilters();
                filterCars();
            }

            // Initialize and populate all filters
            function populateFilters() {
                populateMakeFilter();
                populateModelFilter();
                populateMinMaxYearFilters();
                populateTransmissionFilter();
                populateBodyFilter();
                populateColorFilter();
            }

            // Populate Make filter
            function populateMakeFilter() {
                const makeFilter = document.getElementById('make-filter');
                const uniqueMakes = getUniqueValues('maker', carData);
                makeFilter.innerHTML = '<option value="">All Makes</option>';
                uniqueMakes.forEach(make => {
                    makeFilter.innerHTML += `<option value="${make.toLowerCase()}">${make}</option>`;
                });
                makeFilter.value = ""; // Reset to default
            }

            // Populate Model filter based on selected make
            function populateModelFilter() {
                const makeFilter = document.getElementById('make-filter').value.toLowerCase();
                const modelFilter = document.getElementById('model-filter');
                const filteredModels = carData.filter(car => !makeFilter || car.maker.toLowerCase() === makeFilter);
                const uniqueModels = getUniqueValues('model', filteredModels);
                modelFilter.innerHTML = '<option value="">All Models</option>';
                uniqueModels.forEach(model => {
                    modelFilter.innerHTML += `<option value="${model.toLowerCase()}">${model}</option>`;
                });
                modelFilter.value = ""; // Reset to default
            }

            // Function to populate the min and max year filters
            function populateMinMaxYearFilters() {
                const make = document.getElementById('make-filter').value;
                const model = document.getElementById('model-filter').value;

                let availableYears = [];

                carData.forEach(car => {
                    if ((make === "" || car.maker.toLowerCase().includes(make.toLowerCase())) &&
                        (model === "" || car.model.toLowerCase().includes(model.toLowerCase()))) {
                        availableYears.push(car.car_year);
                    }
                });

                // Remove duplicates and sort the years
                availableYears = [...new Set(availableYears)].sort();

                // Populate yearMin and yearMax filters
                const yearMinSelect = document.getElementById('yearMin');
                const yearMaxSelect = document.getElementById('yearMax');

                yearMinSelect.innerHTML = "<option value='0'>Minimum Year</option>";  
                yearMaxSelect.innerHTML = "<option value='0'>Maximum Year</option>";

                // Populate Minimum Year options (ascending order)
                availableYears.forEach(year => {
                    const minOption = document.createElement('option');
                    minOption.value = year;
                    minOption.textContent = year;
                    yearMinSelect.appendChild(minOption);
                });

                // Populate Maximum Year options (descending order)
                availableYears.slice().reverse().forEach(year => {
                    const maxOption = document.createElement('option');
                    maxOption.value = year;
                    maxOption.textContent = year;
                    yearMaxSelect.appendChild(maxOption);
                });
            }

            // Function to filter cars based on min and max price
            function populateMinMaxPriceFilters() {
                const minPriceInput = document.getElementById('min-price-filter');
                const maxPriceInput = document.getElementById('max-price-filter');

                // Get values from input fields
                const minPrice = parseFloat(minPriceInput.value) || 0; // Default to 0 if empty
                const maxPrice = parseFloat(maxPriceInput.value) || Infinity; // Default to Infinity if empty

                // Filter carData based on the price range
                const filteredCars = carData.filter(car => car.car_price >= minPrice && car.car_price <= maxPrice);

                // Update UI or display the filtered cars
                displayCars(filteredCars, currentPage);
                updateCarCount(filteredCars.length);
            }

            // Populate Transmission filter
            function populateTransmissionFilter() {
                const make = document.getElementById('make-filter').value;
                const model = document.getElementById('model-filter').value;

                let availableTransmissions = [];

                // Iterate through carData to find matching transmissions
                carData.forEach(car => {
                    if ((make === "" || car.maker.toLowerCase().includes(make.toLowerCase())) &&
                        (model === "" || car.model.toLowerCase().includes(model.toLowerCase()))) {
                        availableTransmissions.push(car.car_transmission); // Add transmission type
                    }
                });

                // Remove duplicates by converting the array into a Set, then back to an array
                availableTransmissions = [...new Set(availableTransmissions)];

                // Populate the transmission filter dropdown
                const transmissionSelect = document.getElementById('transmission-filter');
                
                // Reset the dropdown
                transmissionSelect.innerHTML = "<option value=''>All Transmission</option>";

                // Add available transmission options
                availableTransmissions.forEach(transmission => {
                    const option = document.createElement('option');
                    option.value = transmission.toLowerCase();
                    option.textContent = transmission;
                    transmissionSelect.appendChild(option);
                });
            }
            
            // Populate Body filter
            function populateBodyFilter() {
                const make = document.getElementById('make-filter').value;
                const model = document.getElementById('model-filter').value;
                const yearMin = parseInt(document.getElementById('yearMin').value) || 0;
                const yearMax = parseInt(document.getElementById('yearMax').value) || Infinity;
                const priceMin = parseInt(document.getElementById('min-price-filter').value) || 0;
                const priceMax = parseInt(document.getElementById('max-price-filter').value) || Infinity;
                const transmission = document.getElementById('transmission-filter').value;

                let availableBodies = [];

                // Iterate through carData to find matching bodies based on make, model, transmission, and other conditions
                carData.forEach(car => {
                    const carYear = parseInt(car.car_year);
                    const carPrice = parseInt(car.car_price);

                    if (
                        (make === "" || car.maker.toLowerCase().includes(make.toLowerCase())) &&
                        (model === "" || car.model.toLowerCase().includes(model.toLowerCase())) &&
                        (transmission === "" || car.car_transmission.toLowerCase().includes(transmission.toLowerCase())) &&
                        (carYear >= yearMin && carYear <= yearMax) && // Year range filter
                        (carPrice >= priceMin && carPrice <= priceMax) // Price range filter
                    ) {
                        availableBodies.push(car.car_body); // Add body type
                    }
                });

                // Remove duplicates by converting the array into a Set, then back to an array
                availableBodies = [...new Set(availableBodies)];

                // Populate the body filter dropdown
                const bodyFilter = document.getElementById('body-filter');
                
                // Reset the dropdown
                bodyFilter.innerHTML = '<option value="">All Body</option>';

                // Add available body options
                availableBodies.forEach(body => {
                    const option = document.createElement('option');
                    option.value = body.toLowerCase();
                    option.textContent = body;
                    bodyFilter.appendChild(option);
                });
            }

            // Populate Color filter
            function populateColorFilter() {
                const make = document.getElementById('make-filter').value;
                const model = document.getElementById('model-filter').value;
                const yearMin = parseInt(document.getElementById('yearMin').value) || 0;
                const yearMax = parseInt(document.getElementById('yearMax').value) || Infinity;
                const priceMin = parseInt(document.getElementById('min-price-filter').value) || 0;
                const priceMax = parseInt(document.getElementById('max-price-filter').value) || Infinity;
                const transmission = document.getElementById('transmission-filter').value;
                const body = document.getElementById('body-filter').value;

                let availableColors = [];

                // Iterate through carData to find matching colors based on make, model, transmission, and body
                carData.forEach(car => {
                    const carYear = parseInt(car.car_year);
                    const carPrice = parseInt(car.car_price);

                    if (
                        (make === "" || car.maker.toLowerCase().includes(make.toLowerCase())) &&
                        (model === "" || car.model.toLowerCase().includes(model.toLowerCase())) &&
                        (transmission === "" || car.car_transmission.toLowerCase().includes(transmission.toLowerCase())) &&
                        (body === "" || car.car_body.toLowerCase().includes(body.toLowerCase())) &&
                        (carYear >= yearMin && carYear <= yearMax) && // Year range filter
                        (carPrice >= priceMin && carPrice <= priceMax) // Price range filter
                    ) {
                        availableColors.push(car.car_exterior_color); // Add color
                    }
                });

                // Remove duplicates by converting the array into a Set, then back to an array
                availableColors = [...new Set(availableColors)];

                // Populate the color filter dropdown
                const colorFilter = document.getElementById('color-filter');
                
                // Reset the dropdown
                colorFilter.innerHTML = '<option value="">All Color</option>';

                // Add available color options
                availableColors.forEach(color => {
                    const option = document.createElement('option');
                    option.value = color.toLowerCase();
                    option.textContent = color;
                    colorFilter.appendChild(option);
                });
            }
            
            // Listen for changes
            document.getElementById('make-filter').addEventListener('change', function() {
                populateModelFilter();
                populateMinMaxYearFilters();
                populateMinMaxPriceFilters();
                populateTransmissionFilter(); 
                populateBodyFilter(); 
                populateColorFilter(); 
                filterCars();
            });

            document.getElementById('model-filter').addEventListener('change', function() {
                populateMinMaxYearFilters();
                populateMinMaxPriceFilters();
                populateTransmissionFilter();
                populateBodyFilter(); 
                populateColorFilter(); 
                filterCars();
            });

            document.getElementById('yearMax').addEventListener('change', function() {
                populateMinMaxPriceFilters();
                populateTransmissionFilter();
                populateBodyFilter();
                populateColorFilter();
                filterCars();
            });

            document.getElementById('yearMin').addEventListener('change', function() {
                populateMinMaxPriceFilters();
                populateTransmissionFilter();
                populateBodyFilter();
                populateColorFilter();
                filterCars();
            });

            document.getElementById('max-price-filter').addEventListener('input', function() {
                populateTransmissionFilter();
                populateBodyFilter();
                populateColorFilter();
                filterCars(); 
            });

            document.getElementById('min-price-filter').addEventListener('input', function() {
                populateTransmissionFilter();
                populateBodyFilter();
                populateColorFilter();
                filterCars(); 
            });

            document.getElementById('transmission-filter').addEventListener('change', function() {
                populateBodyFilter();
                populateColorFilter();
                filterCars();
            });

            document.getElementById('body-filter').addEventListener('change', function() {
                populateColorFilter();
                filterCars();
            });

            document.getElementById('color-filter').addEventListener('change', function() {
                filterCars();
            });

            document.querySelector('.pagination').addEventListener('click', function (e) {
                if (e.target.tagName === 'A') {
                    const page = parseInt(e.target.getAttribute('data-page'));
                    if (page >= 1 && page <= Math.ceil(filteredCars.length / carsPerPage)) {
                        currentPage = page;
                        displayCars(filteredCars, currentPage);
                    }
                }
            });

            document.getElementById('ddlSort').addEventListener('change', function () {
                const sortType = this.value;  // Get the selected value from the dropdown

                // Sort the cars based on the selected sort type
                filteredCars.sort((a, b) => {
                    switch (sortType) {
                        case 'oldestentry':
                            return new Date(a.arrival_date) - new Date(b.arrival_date); // Oldest arrival date
                        case 'newestentry':
                            return new Date(b.arrival_date) - new Date(a.arrival_date); // Newest arrival date
                        case 'prices':
                            return a.car_price - b.car_price; // Price ascending
                        case 'prices-desc':
                            return b.car_price - a.car_price; // Price descending
                        case 'make':
                            return a.maker.localeCompare(b.maker); // Alphabetical order of maker
                        case 'make-desc':
                            return b.maker.localeCompare(a.maker); // Reverse alphabetical order of maker
                        case 'model':
                            return a.model.localeCompare(b.model); // Alphabetical order of model
                        case 'model-desc':
                            return b.model.localeCompare(a.model); // Reverse alphabetical order of model
                        case 'year':
                            return a.car_year - b.car_year; // Year ascending
                        case 'year-desc':
                            return b.car_year - a.car_year; // Year descending
                        default:
                            return 0; // No sorting (default case)
                    }
                });

                // Reset the page to the first page after sorting
                currentPage = 1;

                // Display the sorted cars
                displayCars(filteredCars, currentPage);
            });

            document.getElementById('search-bar').addEventListener('input', function() {
                const query = this.value.toLowerCase();

                // First, apply the filters (make, year, price, etc.)
                const selectedMake = document.getElementById('make-filter').value.toLowerCase();
                // const selectedYear = document.getElementById('year-filter').value;
                const selectedPriceMax = document.getElementById('max-price-filter').value;
                const selectedPriceMin = document.getElementById('min-price-filter').value;

                // Filter based on active filters like maker, year, price, and search input
                filteredCars = carData.filter(car => {
                    const matchesSearch = car.maker.toLowerCase().includes(query) ||
                        car.model.toLowerCase().includes(query) ||
                        car.car_year.toString().includes(query);

                    const matchesMake = selectedMake ? car.maker.toLowerCase() === selectedMake : true;
                    const matchesYear = selectedYear ? car.car_year.toString() === selectedYear.toString() : true;
                    const matchesMaxPrice = selectedPriceMax ? car.car_price <= selectedPriceMax : true;
                    const matchesMinPrice = selectedPriceMin ? car.car_price >= selectedPriceMin : true;

                    // Return cars matching search query and active filters, including the price range
                    return matchesSearch && matchesMake && matchesYear && matchesMaxPrice && matchesMinPrice;
                });

                currentPage = 1;
                displayCars(filteredCars, currentPage);
                updateCarCount(filteredCars.length); // Update car count after search input
            });

            document.getElementById('reset-btn').addEventListener('click', resetBtn);

            function updateCarCount(count) {
                const carCount = document.getElementById('car-count');
                carCount.textContent = `Total cars: ${count}`;
            }

            populateFilters();
            displayCars(filteredCars, currentPage);
            updateCarCount(filteredCars.length);

        }

    </script>

</body>

</html>