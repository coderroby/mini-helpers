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
                    <!-- <label for="make-filter" class="form-label">Make</label> -->
                    <select id="make-filter" class="form-select">
                        <option value="">All Makes</option>
                    </select>
                </div>

                <div class="mb-3">
                    <!-- <label for="model-filter" class="form-label">Model</label> -->
                    <select id="model-filter" class="form-select">
                        <option value="">All Models</option>
                    </select>
                </div>

                <div class="mb-3">
                    <!-- <label for="yearMin" class="form-label">Year Minimum</label> -->
                    <select id="yearMin" class="form-select">
                        <option selected="selected" value="0">Maximum Year</option>
                    </select>
                </div>

                <div class="mb-3">
                    <!-- <label for="yearMax" class="form-label">Year Maximum</label> -->
                    <select id="yearMax" class="form-select">
                        <option selected="selected" value="0">Maximum Year</option>
                    </select>
                </div>

                <div class="mb-3">
                    <!-- <label for="priceMin" class="form-label">Price Minimum</label> -->
                    <select id="priceMin" class="form-select">
                        <option selected="selected" value="0">Minimum Price</option>
                        <option value="1000">$1,000</option>
                        <option value="5000">$5,000</option>
                        <option value="10000">$10,000</option>
                        <option value="20000">$20,000</option>
                        <option value="30000">$30,000</option>
                        <option value="50000">$50,000</option>
                    </select>
                </div>

                <div class="mb-3">
                    <!-- <label for="priceMax" class="form-label">Price Maximum</label> -->
                    <select id="priceMax" class="form-select">
                        <option selected="selected" value="0">Maximum Price</option>
                        <option value="10000">$10,000</option>
                        <option value="20000">$20,000</option>
                        <option value="30000">$30,000</option>
                        <option value="50000">$50,000</option>
                        <option value="100000">$100,000</option>
                        <option value="200000">$200,000</option>
                    </select>
                </div>


                <div class="mb-3">
                    <input type="number" id="max-price-filter" class="form-control" placeholder="Enter max price">
                </div>
                <div class="mb-3">
                    <input type="number" id="min-price-filter" class="form-control" placeholder="Enter min price">
                </div>

                <div class="mb-3">
                    <select id="year-filter" class="form-select">
                        <option value="">All Years</option>
                    </select>
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
                    <button id="reset-filters">Reset Filters</button>
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

                // Event listener for pagination clicks
                document.querySelector('.pagination').addEventListener('click', function (e) {
                    if (e.target.tagName === 'A') {
                        const page = parseInt(e.target.getAttribute('data-page'));
                        if (page >= 1 && page <= Math.ceil(filteredCars.length / carsPerPage)) {
                            currentPage = page;
                            displayCars(filteredCars, currentPage);
                        }
                    }
                });


                // Filter cars based on selected values dynamically
                function filterCars() {
                    const maker = document.getElementById('make-filter').value.toLowerCase();
                    const model = document.getElementById('model-filter').value.toLowerCase();
                    const max_car_price = document.getElementById('max-price-filter').value;
                    const min_car_price = document.getElementById('min-price-filter').value;
                    const car_year = document.getElementById('year-filter').value;
                    const car_transmission = document.getElementById('transmission-filter').value.toLowerCase();
                    const car_exterior_color = document.getElementById('color-filter').value.toLowerCase();
                    const car_body = document.getElementById('body-filter').value.toLowerCase();

                    filteredCars = carData.filter(car => {
                        return (!maker || car.maker.toLowerCase().includes(maker)) &&
                            (!model || car.model.toLowerCase().includes(model)) &&
                            (!max_car_price || car.max_car_price <= max_car_price) &&
                            (!min_car_price || car.min_car_price >= min_car_price) &&
                            (!car_year || car.car_year == car_year) &&
                            (!car_transmission || car.car_transmission.toLowerCase().includes(car_transmission)) &&
                            (!car_exterior_color || car.car_exterior_color.toLowerCase().includes(car_exterior_color)) &&
                            (!car_body || car.car_body.toLowerCase().includes(car_body));
                    });

                    

                    //updateFilterFields(); // Update available filter options based on the filtered data
                    currentPage = 1;
                    displayCars(filteredCars, currentPage);
                    updateCarCount(filteredCars.length);
                }

                // Add event listener to update model and year filters when make changes
                document.getElementById('make-filter').addEventListener('change', function() {
                    document.getElementById('model-filter').value = "";
                    document.getElementById('year-filter').value = "";  
                    filterCars();
                    populateModelFilter();
                    populateYearFilter();
                });
                // Add event listener to update year filter when model changes
                document.getElementById('model-filter').addEventListener('change', function() {
                    document.getElementById('year-filter').value = ""; 
                    filterCars();
                    populateYearFilter();
                });
                document.getElementById('year-filter').addEventListener('change', filterCars);
                document.getElementById('max-price-filter').addEventListener('input', filterCars);
                document.getElementById('min-price-filter').addEventListener('input', filterCars);

                document.getElementById('yearMin').addEventListener('change', function () {
                    const minYear = parseInt(this.value);
                    const maxYear = parseInt(document.getElementById('yearMax').value) || Infinity; 

                    const filteredByYear = filteredCars.filter(car => {
                        return (minYear === 0 || car.car_year >= minYear) &&
                            (maxYear === 0 || car.car_year <= maxYear);
                    });

                    currentPage = 1;
                    displayCars(filteredByYear, currentPage);
                });

                document.getElementById('yearMax').addEventListener('change', function () {
                    const maxYear = parseInt(this.value);
                    const minYear = parseInt(document.getElementById('yearMin').value) || 0; 

                    const filteredByYear = filteredCars.filter(car => {
                        return (minYear === 0 || car.car_year >= minYear) &&
                            (maxYear === 0 || car.car_year <= maxYear);
                    });

                    currentPage = 1;
                    displayCars(filteredByYear, currentPage);
                });

                document.getElementById('priceMin').addEventListener('change', function() {
                    const minPrice = parseInt(this.value);
                    filterByPrice(minPrice, 'min');
                });

                document.getElementById('priceMax').addEventListener('change', function() {
                    const maxPrice = parseInt(this.value);
                    filterByPrice(maxPrice, 'max');
                });

                function filterByPrice(value, type) {
                    let filteredCars = carsData;
                    if (type === 'min') {
                        filteredCars = filteredCars.filter(car => car.price >= value);
                    } else if (type === 'max') {
                        filteredCars = filteredCars.filter(car => car.price <= value);
                    }
                    displayCars(filteredCars); 
                }

                document.getElementById('transmission-filter').addEventListener('change', filterCars);
                document.getElementById('color-filter').addEventListener('change', filterCars);
                document.getElementById('body-filter').addEventListener('change', filterCars);



                // Reset filters and reload the full data set
                document.getElementById('reset-filters').addEventListener('click', function () {
                    document.getElementById('make-filter').value = '';
                    document.getElementById('model-filter').value = '';
                    document.getElementById('year-filter').value = '';
                    document.getElementById('max-price-filter').value = '';
                    document.getElementById('min-price-filter').value = '';
                    document.getElementById('yearMin').value = '';
                    document.getElementById('yearMax').value = '';
                    filteredCars = carData;
                    populateFilters();
                    displayCars(filteredCars, currentPage);
                    updateCarCount(filteredCars.length);
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

                // Event listener for search bar
                document.getElementById('search-bar').addEventListener('input', function() {
                    const query = this.value.toLowerCase();

                    // First, apply the filters (make, year, price, etc.)
                    const selectedMake = document.getElementById('make-filter').value.toLowerCase();
                    const selectedYear = document.getElementById('year-filter').value;
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

                // Function to get unique values for dropdowns
                function getUniqueValues(key, data) {
                    return [...new Set(data.map(car => car[key]))];
                }

                // Populate filters dynamically
                function populateFilters() {
                    populateMakeFilter();
                    populateModelFilter();
                    populateYearFilter();
                    populateMinMaxYearFilters();
                    populateTransmissionFilter();
                    populateBodyFilter();
                    populateColorFilter();
                }

                // Populate Make filter
                function populateMakeFilter() {
                    const makeFilter = document.getElementById('make-filter');
                    const currentMake = makeFilter.value;
                    const uniqueMakes = getUniqueValues('maker', carData);
                    makeFilter.innerHTML = '<option value="">All Makes</option>';
                    uniqueMakes.forEach(maker => {
                        makeFilter.innerHTML += `<option value="${maker.toLowerCase()}">${maker}</option>`;
                    });
                    if (!currentMake) {
                        makeFilter.value = "";  // Set value back to empty if no selection
                    }
                }

                // Populate Model filter
                function populateModelFilter() {
                    const modelFilter = document.getElementById('model-filter');
                    const makeFilter = document.getElementById('make-filter').value.toLowerCase();
                    const currentModel = modelFilter.value; // Store the current selected value

                    // Filter cars based on selected make
                    const filteredModels = carData.filter(car => 
                        (!makeFilter || car.maker.toLowerCase() === makeFilter)
                    );

                    const uniqueModels = getUniqueValues('model', filteredModels);
                    modelFilter.innerHTML = '<option value="">All Models</option>';
                    
                    uniqueModels.forEach(model => {
                        modelFilter.innerHTML += `<option value="${model.toLowerCase()}" ${model.toLowerCase() === currentModel ? 'selected' : ''}>${model}</option>`;
                    });

                    // If no value is selected, make sure 'All Models' is selected
                    if (!currentModel) {
                        modelFilter.value = "";  // Set value back to empty if no selection
                    }
                }

                // // Populate Year filter
                function populateYearFilter() {
                    const yearFilter = document.getElementById('year-filter');
                    const modelFilter = document.getElementById('model-filter').value.toLowerCase();
                    const currentYear = yearFilter.value; // Store the current selected value

                    // Filter cars based on selected model
                    const filteredYears = carData.filter(car => 
                        (!modelFilter || car.model.toLowerCase() === modelFilter)
                    );

                    const uniqueYears = getUniqueValues('car_year', filteredYears);
                    yearFilter.innerHTML = '<option value="">All Years</option>';
                    
                    uniqueYears.forEach(car_year => {
                        yearFilter.innerHTML += `<option value="${car_year}" ${car_year === currentYear ? 'selected' : ''}>${car_year}</option>`;
                    });

                    // If no value is selected, make sure 'All Years' is selected
                    if (!currentYear) {
                        yearFilter.value = "";  // Set value back to empty if no selection
                    }
                }

                // Populate MinMaxYear filter
                function populateMinMaxYearFilters() {
                    const currentYear = new Date().getFullYear();
                    const yearMinSelect = document.getElementById('yearMin');
                    const yearMaxSelect = document.getElementById('yearMax');
                    
                    // Start from 2014 (or another start year) to the current year
                    for (let year = 2014; year <= currentYear; year++) {
                        // Create a new option element for yearMin
                        const minOption = document.createElement('option');
                        minOption.value = year;
                        minOption.textContent = year;
                        yearMinSelect.appendChild(minOption);
                        
                        // Create a new option element for yearMax
                        const maxOption = document.createElement('option');
                        maxOption.value = year;
                        maxOption.textContent = year;
                        yearMaxSelect.appendChild(maxOption);
                    }
                }         

                // Populate Transmission filter
                function populateTransmissionFilter() {
                    const transmissionFilter = document.getElementById('transmission-filter');
                    const currentTransmission = transmissionFilter.value;
                    const uniqueTransmission = getUniqueValues('car_transmission', carData);
                    transmissionFilter.innerHTML = '<option value="">Transmission</option>';
                    uniqueTransmission.forEach(transmission => {
                        transmissionFilter.innerHTML += `<option value="${transmission.toLowerCase()}">${transmission}</option>`;
                    });
                    if (!currentTransmission) {
                        transmissionFilter.value = "";  // Set value back to empty if no selection
                    }
                }

                // Populate body filter
                function populateBodyFilter() {
                    const bodyFilter = document.getElementById('body-filter');
                    const currentBody = bodyFilter.value;
                    const uniqueBody = getUniqueValues('car_body', carData);
                    bodyFilter.innerHTML = '<option value="">Body</option>';
                    uniqueBody.forEach(body => {
                        bodyFilter.innerHTML += `<option value="${body.toLowerCase()}">${body}</option>`;
                    });
                    if (!currentBody) {
                        bodyFilter.value = "";  // Set value back to empty if no selection
                    }
                }

                 // Populate color filter
                 function populateColorFilter() {
                    const colorFilter = document.getElementById('color-filter');
                    const currentColor = colorFilter.value;
                    const uniqueColor = getUniqueValues('car_interrior_color', carData);
                    colorFilter.innerHTML = '<option value="">Color</option>';
                    uniqueColor.forEach(body => {
                        colorFilter.innerHTML += `<option value="${body.toLowerCase()}">${body}</option>`;
                    });
                    if (!currentColor) {
                        colorFilter.value = "";  // Set value back to empty if no selection
                    }
                }

                // Function to update total car count
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