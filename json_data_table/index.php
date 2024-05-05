<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        #card-container {
            padding-top: 30px;
        }

        .card-body {
            min-height: 250px;
        }
    </style>

</head>

<body>

    <div class="container">
        <div class="row" id="top-filters-box">
        </div>
        <div class="row">
            <div class="col-md-3" id="filter">
                <button id="resetFilters" class="btn btn-primary mt-3">Reset Filters</button>
                <label for="cardsPerPage" class="filterby">Cards Per Page:</label>
                <select class="form-control" id="cardsPerPage">
                    <option value="6">6</option>
                    <option value="9">9</option>
                    <option value="12">12</option>
                    <option value="24">24</option>
                    <option value="48">48</option>
                </select>

                <label for="salaryRange" class="filterby">Filter by Salary:</label>

                <input type="range" class="form-control-range" id="salaryRange">
                <div class="mt-2">
                    <span id="selectedSalaryRange"></span>
                </div>

                <label for="sortBy" class="filterby">Sort By:</label>
                <select class="form-control" id="sortBy">
                    <option value="name">Name</option>
                    <option value="position">Position</option>
                    <option value="office">Office</option>
                    <option value="start_date">Start Date</option>
                    <option value="salary">Salary</option>
                </select>

                <label for="officeFilter" class="filterby">Filter by Office:</label>
                <div id="officeFilter">
                    <!-- Options for filtering will be added dynamically -->
                </div>

                <label for="positionFilter" class="filterby">Filter by Position:</label>
                <div id="positionFilter">
                    <!-- Options for filtering will be added dynamically -->
                </div>
            </div>
            <div class="col-md-9" id="filtered_result">
                <div class="row" id="card-container">
                    <!-- Cards will be dynamically added here -->
                </div>
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center" id="pagination">
                        <!-- Page numbers will be added here -->
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        var currentPage = 0;
        var cardsPerPage = 9;
        var data = [];
        var offices = {};
        var positions = {};

        $(document).ready(function() {
            // Load JSON data
            $.ajax({
                url: "http://mini-helpers.test/json_data_table/data.json",
                method: "GET",
                success: function(response) {
                    data = response.data.map(function(item) {
                        item.salary = parseInt(item.salary.replace(/[$,]/g, ''));
                        return item;
                    });
                    extractUniqueData();
                    populateFilters();
                    showCards(currentPage);
                    renderPagination();
                    setSalaryRange();
                }
            });

            $('#cardsPerPage').change(function() {
                cardsPerPage = parseInt($(this).val());
                currentPage = 0;
                showCards(currentPage);
                renderPagination();
            });

            $('#sortBy').change(function() {
                var sortBy = $(this).val();
                sortData(sortBy);
                showCards(currentPage);
                renderPagination();
            });

            $('#officeFilter, #positionFilter').change(function() {
                showCards(currentPage);
                renderPagination();
            });

            $('#salaryRange').on('input', function() {
                showCards(currentPage);
                renderPagination();
                updateSelectedSalaryRange();
            });

            $('#pagination').on('click', 'li.page-item', function() {
                var page = $(this).data('page');
                if (page !== undefined) {
                    currentPage = page;
                    showCards(currentPage);
                    renderPagination();
                }
            });

            $('#resetFilters').click(function() {
                // Uncheck all checkboxes
                $('#officeFilter input[type="checkbox"]').prop('checked', false);
                $('#positionFilter input[type="checkbox"]').prop('checked', false);
                // Reset salary range
                $('#salaryRange').val($('#salaryRange').attr('min'));
                showCards(currentPage);
                renderPagination();
                updateSelectedSalaryRange();
            });
        });

        function showCards(page) {
            var startIndex = page * cardsPerPage;
            var endIndex = startIndex + cardsPerPage;
            var filteredData = filterData();
            var cardsHtml = '';
            for (var i = startIndex; i < endIndex && i < filteredData.length; i++) {
                var item = filteredData[i];
                cardsHtml += '<div class="col-md-4 mb-3">';
                cardsHtml += '<div class="card">';
                cardsHtml += '<div class="card-body">';
                cardsHtml += '<h5 class="card-title">' + item.name + '</h5>';
                cardsHtml += '<p class="card-text">Position: ' + item.position + '</p>';
                cardsHtml += '<p class="card-text">Office: ' + item.office + '</p>';
                cardsHtml += '<p class="card-text">Start Date: ' + item.start_date + '</p>';
                cardsHtml += '<p class="card-text">Salary: ' + item.salary + '</p>';
                cardsHtml += '</div>';
                cardsHtml += '</div>';
                cardsHtml += '</div>';
            }
            $('#card-container').html(cardsHtml);
        }

        function renderPagination() {
            var filteredData = filterData();
            var totalPages = Math.ceil(filteredData.length / cardsPerPage);
            var paginationHtml = '';
            for (var i = 0; i < totalPages; i++) {
                var pageNumber = i + 1;
                paginationHtml += '<li class="page-item';
                if (i === currentPage) {
                    paginationHtml += ' active';
                }
                paginationHtml += '" data-page="' + i + '">';
                paginationHtml += '<a class="page-link" href="#">' + pageNumber + '</a>';
                paginationHtml += '</li>';
            }
            $('#pagination').html(paginationHtml);
            $('#next-page').prop('disabled', currentPage === totalPages - 1);
        }

        function sortData(sortBy) {
            data.sort(function(a, b) {
                if (a[sortBy] < b[sortBy]) return -1;
                if (a[sortBy] > b[sortBy]) return 1;
                return 0;
            });
        }

        function extractUniqueData() {
            data.forEach(function(item) {
                offices[item.office] = offices[item.office] ? offices[item.office] + 1 : 1;
                positions[item.position] = positions[item.position] ? positions[item.position] + 1 : 1;
            });
        }

        function populateFilters() {
            populateOfficeFilter();
            populatePositionFilter();
        }

        function populateOfficeFilter() {
            var optionsHtml = '';
            Object.keys(offices).forEach(function(office) {
                optionsHtml += '<div class="form-check">';
                optionsHtml += '<input class="form-check-input" type="checkbox" value="' + office + '" id="office_' + office + '">';
                optionsHtml += '<label class="form-check-label" for="office_' + office + '">' + office + ' (' + offices[office] + ')</label>';
                optionsHtml += '</div>';
            });
            $('#officeFilter').html(optionsHtml);
        }

        function populatePositionFilter() {
            var optionsHtml = '';
            Object.keys(positions).forEach(function(position) {
                optionsHtml += '<div class="form-check">';
                optionsHtml += '<input class="form-check-input" type="checkbox" value="' + position + '" id="position_' + position + '">';
                optionsHtml += '<label class="form-check-label" for="position_' + position + '">' + position + ' (' + positions[position] + ')</label>';
                optionsHtml += '</div>';
            });
            $('#positionFilter').html(optionsHtml);
        }

        function setSalaryRange() {
            var minSalary = Math.min.apply(Math, data.map(function(item) {
                return item.salary;
            }));
            var maxSalary = Math.max.apply(Math, data.map(function(item) {
                return item.salary;
            }));
            $('#salaryRange').attr('min', minSalary);
            $('#salaryRange').attr('max', maxSalary);
            $('#salaryRange').val(minSalary);
            $('#lowestSalary').text(minSalary);
            $('#highestSalary').text(maxSalary);
            updateSelectedSalaryRange();
        }

        function updateSelectedSalaryRange() {
            var minSalary = Math.min.apply(Math, data.map(function(item) {
                return item.salary;
            }));
            var selectedMinSalary = parseInt($('#salaryRange').val());
            var selectedMaxSalary = parseInt($('#salaryRange').attr('max'));
            if (selectedMinSalary > minSalary) {
                $('#selectedSalaryRange').text(minSalary + ' - ' + selectedMinSalary);
            } else $('#selectedSalaryRange').text(selectedMinSalary + ' - ' + selectedMaxSalary);
            // console.log(selectedMinSalary);
        }

        function filterData() {
            var filteredData = data;
            var selectedOffices = [];
            $('#officeFilter input:checked').each(function() {
                selectedOffices.push($(this).val());
            });
            var selectedPositions = [];
            $('#positionFilter input:checked').each(function() {
                selectedPositions.push($(this).val());
            });
            var minSalary = parseInt($('#salaryRange').val());
            filteredData = filteredData.filter(function(item) {
                return (selectedOffices.length === 0 || selectedOffices.includes(item.office)) &&
                    (selectedPositions.length === 0 || selectedPositions.includes(item.position)) &&
                    item.salary >= minSalary;
            });
            return filteredData;
        }
    </script>

</body>

</html>