<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Home</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <label for="cardsPerPage">Cards Per Page:</label>
            <select class="form-control" id="cardsPerPage">
                <option value="6">6</option>
                <option value="9">9</option>
                <option value="12">12</option>
                <option value="24">24</option>
                <option value="48">48</option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="officeFilter">Filter by Office:</label>
            <select class="form-control" id="officeFilter">
                <option value="">All</option>
                <!-- Options for filtering will be added dynamically -->
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="positionFilter">Filter by Position:</label>
            <select class="form-control" id="positionFilter">
                <option value="">All</option>
                <!-- Options for filtering will be added dynamically -->
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="sortBy">Sort By:</label>
            <select class="form-control" id="sortBy">
                <option value="name">Name</option>
                <option value="position">Position</option>
                <option value="office">Office</option>
                <option value="start_date">Start Date</option>
                <option value="salary">Salary</option>
            </select>
        </div>
    </div>
    <div class="row" id="card-container">
        <!-- Cards will be dynamically added here -->
    </div>
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center" id="pagination">
            <!-- Page numbers will be added here -->
        </ul>
    </nav>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    var currentPage = 0;
    var cardsPerPage = 6;
    var data = [];
    var offices = {}; // Object to store unique office locations and their counts
    var positions = {}; // Object to store unique positions and their counts

    $(document).ready(function() {
        // Load JSON data
        $.ajax({
            url: "http://mini-helpers.test/json_data_table/data.json",
            method: "GET",
            success: function(response) {
                data = response.data;
                extractUniqueOffices();
                populateOfficeFilter();
                showCards(currentPage);
                renderPagination();
            }
        });

        $('#cardsPerPage').change(function() {
            cardsPerPage = parseInt($(this).val());
            currentPage = 0; // Reset current page to 0 when changing cards per page
            showCards(currentPage);
            renderPagination();
        });

        $('#sortBy').change(function() {
            var sortBy = $(this).val();
            sortData(sortBy);
            showCards(currentPage);
            renderPagination();
        });

        $('#officeFilter').change(function() {
            populatePositionFilter($(this).val());
            showCards(currentPage);
            renderPagination();
        });

        $('#positionFilter').change(function() {
            showCards(currentPage);
            renderPagination();
        });

        $('#pagination').on('click', 'li.page-item', function() {
            var page = $(this).data('page');
            if (page !== undefined) {
                currentPage = page;
                showCards(currentPage);
                renderPagination();
            }
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

    function extractUniqueOffices() {
        offices = data.reduce(function(acc, curr) {
            acc[curr.office] = acc[curr.office] ? acc[curr.office] + 1 : 1;
            return acc;
        }, {});
    }

    function populateOfficeFilter() {
        var optionsHtml = '<option value="">All</option>';
        Object.keys(offices).forEach(function(office) {
            optionsHtml += '<option value="' + office + '">' + office + ' (' + offices[office] + ')</option>';
        });
        $('#officeFilter').html(optionsHtml);
        populatePositionFilter($('#officeFilter').val());
    }

    function populatePositionFilter(selectedOffice) {
        var positions = {};
        var filteredData = data.filter(function(item) {
            return selectedOffice === '' || item.office === selectedOffice;
        });
        filteredData.forEach(function(item) {
            positions[item.position] = positions[item.position] ? positions[item.position] + 1 : 1;
        });
        var optionsHtml = '<option value="">All</option>';
        Object.keys(positions).forEach(function(position) {
            optionsHtml += '<option value="' + position + '">' + position + ' (' + positions[position] + ')</option>';
        });
        $('#positionFilter').html(optionsHtml);
    }

    function filterData() {
        var filteredData = data;
        var selectedOffice = $('#officeFilter').val();
        var selectedPosition = $('#positionFilter').val();
        if (selectedOffice !== '') {
            filteredData = filteredData.filter(item => item.office === selectedOffice);
        }
        if (selectedPosition !== '') {
            filteredData = filteredData.filter(item => item.position === selectedPosition);
        }
        return filteredData;
    }
</script>

</body>
</html>
