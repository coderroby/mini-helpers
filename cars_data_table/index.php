<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Listings</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/styles.css" rel="stylesheet">
</head>

<body>

    <!-- Header Section -->
    <header class="bg-dark text-white text-center py-3">
        <h1>Car Listings</h1>
        <p>Find your next car from our exclusive collection</p>
    </header>

    <!-- Main Content Section -->
    <div class="container my-5">
        <div class="row">
            <!-- <div class="col-md-3">
                <h4>Filter Options</h4>
                 <div class="form-group">
                    <label for="filterBrand">Brand</label>
                    <input type="text" id="filterBrand" class="form-control" placeholder="Search by brand...">
                </div>

                <div class="form-group">
                    <label for="filterPrice">Price Range</label>
                    <select id="filterPrice" class="form-control">
                        <option value="">All</option>
                        <option value="0-20000">Up to $20,000</option>
                        <option value="20000-50000">$20,000 - $50,000</option>
                        <option value="50000-100000">$50,000 - $100,000</option>
                        <option value="100000">Above $100,000</option>
                    </select>
                </div>
                <button id="applyFilters" class="btn btn-primary">Apply Filters</button>
            </div> -->

            <div class="col-md-12">
                <div id="carListings" class="row">
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Section -->
    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2024 Car Dealer Website. All Rights Reserved.</p>
    </footer>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Custom JS -->
    <script src="js/script.js"></script>
</body>

</html>