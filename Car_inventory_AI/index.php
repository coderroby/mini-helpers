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
            margin-top: 2rem;
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
                    <label for="make-filter" class="form-label">Make</label>
                    <select id="make-filter" class="form-select">
                        <option value="">All Makes</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="model-filter" class="form-label">Model</label>
                    <select id="model-filter" class="form-select">
                        <option value="">All Models</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="price-filter" class="form-label">Max Price</label>
                    <input type="number" id="price-filter" class="form-control" placeholder="Enter max price">
                </div>

                <div class="mb-3">
                    <!-- <label for="year-filter" class="form-label">Year</label>
                <input type="number" id="year-filter" class="form-control" placeholder="Enter year"> -->
                    <label for="year-filter" class="form-label">Year</label>
                    <select id="year-filter" class="form-select">
                        <option value="">All Years</option>
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
                    <ul class="pagination">
                        <!-- Pagination items will be dynamically inserted here -->
                    </ul>
                    <ul id="pagination">
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
        // Sample JSON data (you will load from your `cars_formatted.json`)
        const carData = [
        { "make": "Toyota", "model": "Corolla", "price": 15000, "year": 2018, "mileage": 40000, "media": "https://via.placeholder.com/350x200?text=Toyota+Corolla" },
        { "make": "Honda", "model": "Civic", "price": 18000, "year": 2019, "mileage": 35000, "media": "https://via.placeholder.com/350x200?text=Honda+Civic" },
        { "make": "BMW", "model": "X5", "price": 45000, "year": 2021, "mileage": 15000, "media": "https://via.placeholder.com/350x200?text=BMW+X5" },
        { "make": "Toyota", "model": "Corolla", "price": 15000, "year": 2018, "mileage": 40000, "media": "https://via.placeholder.com/350x200?text=Toyota+Corolla" },
        { "make": "Honda", "model": "Civic", "price": 18000, "year": 2019, "mileage": 35000, "media": "https://via.placeholder.com/350x200?text=Honda+Civic" },
        { "make": "BMW", "model": "X5", "price": 45000, "year": 2021, "mileage": 15000, "media": "https://via.placeholder.com/350x200?text=BMW+X5" },
        { "make": "Toyota", "model": "Corolla", "price": 15000, "year": 2018, "mileage": 40000, "media": "https://via.placeholder.com/350x200?text=Toyota+Corolla" },
        { "make": "Honda", "model": "Civic", "price": 18000, "year": 2019, "mileage": 35000, "media": "https://via.placeholder.com/350x200?text=Honda+Civic" },
        { "make": "BMW", "model": "X5", "price": 45000, "year": 2021, "mileage": 15000, "media": "https://via.placeholder.com/350x200?text=BMW+X5" },
        { "make": "Toyota", "model": "Corolla", "price": 15000, "year": 2018, "mileage": 40000, "media": "https://via.placeholder.com/350x200?text=Toyota+Corolla" },
        { "make": "Honda", "model": "Civic", "price": 18000, "year": 2019, "mileage": 35000, "media": "https://via.placeholder.com/350x200?text=Honda+Civic" },
        { "make": "BMW", "model": "X5", "price": 45000, "year": 2021, "mileage": 15000, "media": "https://via.placeholder.com/350x200?text=BMW+X5" },
        { "make": "Toyota", "model": "Corolla", "price": 15000, "year": 2018, "mileage": 40000, "media": "https://via.placeholder.com/350x200?text=Toyota+Corolla" },
        { "make": "Honda", "model": "Civic", "price": 18000, "year": 2010, "mileage": 35000, "media": "https://via.placeholder.com/350x200?text=Honda+Civic" },
        { "make": "BMW", "model": "X5", "price": 45000, "year": 2021, "mileage": 15000, "media": "https://via.placeholder.com/350x200?text=BMW+X5" },
        { "make": "Toyota", "model": "Corolla", "price": 15000, "year": 2018, "mileage": 40000, "media": "https://via.placeholder.com/350x200?text=Toyota+Corolla" },
        { "make": "Honda", "model": "Civic", "price": 18000, "year": 2019, "mileage": 35000, "media": "https://via.placeholder.com/350x200?text=Honda+Civic" },
        { "make": "BMW", "model": "X5", "price": 45000, "year": 2021, "mileage": 15000, "media": "https://via.placeholder.com/350x200?text=BMW+X5" },
        { "make": "Toyota", "model": "Corolla", "price": 15000, "year": 2018, "mileage": 40000, "media": "https://via.placeholder.com/350x200?text=Toyota+Corolla" },
        { "make": "Honda", "model": "Civic", "price": 18000, "year": 2021, "mileage": 35000, "media": "https://via.placeholder.com/350x200?text=Honda+Civic" },
        { "make": "BMW", "model": "X5", "price": 45000, "year": 2021, "mileage": 15000, "media": "https://via.placeholder.com/350x200?text=BMW+X5" },
        { "make": "Toyota", "model": "Corolla", "price": 15000, "year": 2018, "mileage": 40000, "media": "https://via.placeholder.com/350x200?text=Toyota+Corolla" },
        { "make": "Honda", "model": "Civic", "price": 18000, "year": 2019, "mileage": 35000, "media": "https://via.placeholder.com/350x200?text=Honda+Civic" },
        { "make": "BMW", "model": "X5", "price": 45000, "year": 2021, "mileage": 15000, "media": "https://via.placeholder.com/350x200?text=BMW+X5" },
        { "make": "Toyota", "model": "Corolla", "price": 15000, "year": 2018, "mileage": 40000, "media": "https://via.placeholder.com/350x200?text=Toyota+Corolla" },
        { "make": "Honda", "model": "Civic", "price": 18000, "year": 2019, "mileage": 35000, "media": "https://via.placeholder.com/350x200?text=Honda+Civic" },
        { "make": "BMW", "model": "X5", "price": 45000, "year": 2021, "mileage": 15000, "media": "https://via.placeholder.com/350x200?text=BMW+X5" },
        { "make": "Toyota", "model": "Corolla", "price": 15000, "year": 2018, "mileage": 40000, "media": "https://via.placeholder.com/350x200?text=Toyota+Corolla" },
        { "make": "Honda", "model": "Civic", "price": 18000, "year": 2000, "mileage": 35000, "media": "https://via.placeholder.com/350x200?text=Honda+Civic" },
        { "make": "BMW", "model": "X5", "price": 45000, "year": 2021, "mileage": 15000, "media": "https://via.placeholder.com/350x200?text=BMW+X5" },
        { "make": "Toyota", "model": "Corolla", "price": 15000, "year": 2018, "mileage": 40000, "media": "https://via.placeholder.com/350x200?text=Toyota+Corolla" },
        { "make": "Honda", "model": "Civic", "price": 18000, "year": 2019, "mileage": 35000, "media": "https://via.placeholder.com/350x200?text=Honda+Civic" },
        { "make": "BMW", "model": "X6", "price": 45000, "year": 2021, "mileage": 15000, "media": "https://via.placeholder.com/350x200?text=BMW+X5" },
        { "make": "Toyota", "model": "Corolla", "price": 15000, "year": 2018, "mileage": 40000, "media": "https://via.placeholder.com/350x200?text=Toyota+Corolla" },
        { "make": "Honda", "model": "Civic", "price": 18000, "year": 2019, "mileage": 35000, "media": "https://via.placeholder.com/350x200?text=Honda+Civic" },
        { "make": "BMWsss", "model": "X5sss", "price": 45001110, "year": 2024, "mileage": 1501100, "media": "https://via.placeholder.com/350x200?text=BMW+X5" },
        { "make": "sss", "model": "1s", "price": 4500, "year": 2024, "mileage": 1501100, "media": "https://via.placeholder.com/350x200?text=BMW+X6" },
        { "make": "aaa", "model": "2s", "price": 4500, "year": 2005, "mileage": 150, "media": "https://via.placeholder.com/350x200?text=BMW+X7" },
        // Add more cars here
        ];

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
                            <img src="${car.media}" class="card-img-top car-image" alt="${car.make} ${car.model}">
                            <div class="card-body">
                                <h5 class="card-title">${car.make} ${car.model}</h5>
                                <p class="card-text">Price: $${car.price}</p>
                                <p class="card-text">Year: ${car.year}</p>
                                <p class="card-text">Mileage: ${car.mileage} miles</p>
                            </div>
                        </div>
                    </div>
                `;
            });

            displayPagination(cars.length, page);
        }

        // Function to display pagination
        function displayPagination(totalCars, currentPage) {
            const pagination = document.querySelector('.pagination');
            pagination.innerHTML = '';

            const totalPages = Math.ceil(totalCars / carsPerPage);

            for (let i = 1; i <= totalPages; i++) {
                pagination.innerHTML += `
                    <li class="page-item ${i === currentPage ? 'active' : ''}">
                        <a class="page-link" href="#" data-page="${i}">${i}</a>
                    </li>
                `;
            }
        }

        // Event listener for pagination clicks
        document.querySelector('.pagination').addEventListener('click', function (e) {
            if (e.target.tagName === 'A') {
                const page = parseInt(e.target.getAttribute('data-page'));
                currentPage = page;
                displayCars(filteredCars, currentPage);
            }
        });

        // Filter cars based on selected values dynamically
        function filterCars() {
            const make = document.getElementById('make-filter').value.toLowerCase();
            const model = document.getElementById('model-filter').value.toLowerCase();
            const price = document.getElementById('price-filter').value;
            const year = document.getElementById('year-filter').value;

            filteredCars = carData.filter(car => {
                return (!make || car.make.toLowerCase().includes(make)) &&
                    (!model || car.model.toLowerCase().includes(model)) &&
                    (!price || car.price <= price) &&
                    (!year || car.year == year);
            });

            updateFilterFields(); // Update available filter options based on the filtered data
            currentPage = 1;
            displayCars(filteredCars, currentPage);
            updateCarCount(filteredCars.length);
        }

        // Event listeners for filter changes
        document.getElementById('make-filter').addEventListener('change', filterCars);
        document.getElementById('model-filter').addEventListener('change', filterCars);
        document.getElementById('year-filter').addEventListener('change', filterCars);
        document.getElementById('price-filter').addEventListener('input', filterCars);

        // Reset filters and reload the full data set
        document.getElementById('reset-filters').addEventListener('click', function () {
            document.getElementById('make-filter').value = '';
            document.getElementById('model-filter').value = '';
            document.getElementById('year-filter').value = '';
            document.getElementById('price-filter').value = '';
            filteredCars = carData;
            populateMakeFilter();
            populateModelFilter();
            populateYearFilter();
            displayCars(filteredCars, currentPage);
            updateCarCount(filteredCars.length);
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
        }

        // Populate Make filter
        function populateMakeFilter() {
            const makeFilter = document.getElementById('make-filter');
            const uniqueMakes = getUniqueValues('make', filteredCars);
            makeFilter.innerHTML = '<option value="">All Makes</option>';
            uniqueMakes.forEach(make => {
                makeFilter.innerHTML += `<option value="${make.toLowerCase()}">${make}</option>`;
            });
        }

        // Populate Model filter
        function populateModelFilter() {
            const modelFilter = document.getElementById('model-filter');
            const uniqueModels = getUniqueValues('model', filteredCars);
            modelFilter.innerHTML = '<option value="">All Models</option>';
            uniqueModels.forEach(model => {
                modelFilter.innerHTML += `<option value="${model.toLowerCase()}">${model}</option>`;
            });
        }

        // Populate Year filter
        function populateYearFilter() {
            const yearFilter = document.getElementById('year-filter');
            const uniqueYears = getUniqueValues('year', filteredCars);
            yearFilter.innerHTML = '<option value="">All Years</option>';
            uniqueYears.forEach(year => {
                yearFilter.innerHTML += `<option value="${year}">${year}</option>`;
            });
        }

        // Update filter fields dynamically based on current selection
        function updateFilterFields() {
            populateMakeFilter();
            populateModelFilter();
            populateYearFilter();
        }

        // Function to update total car count
        function updateCarCount(count) {
            const carCount = document.getElementById('car-count');
            carCount.textContent = `Total cars: ${count}`;
        }

        // Initial setup when the page loads
        document.addEventListener('DOMContentLoaded', function () {
            populateFilters();
            displayCars(filteredCars, currentPage);
            updateCarCount(filteredCars.length);
        });

    </script>

</body>

</html>