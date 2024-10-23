document.addEventListener('DOMContentLoaded', function () {
    fetch('cars_formatted.json')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json(); // Properly return the parsed JSON data here
        })
        .then(data => {
            if (Array.isArray(data)) {
                displayCarListings(data);
            } else {
                console.error('Data is not an array:', data);
                // If your data is not in an array, you can still display it by passing it as an array
                displayCarListings([data]); // Pass the single data object as an array
            }
        })
        .catch(error => {
            console.error('Error fetching car data:', error);
        });
});

// Function to display car listings on the page
function displayCarListings(cars) {
    const carListingsContainer = document.getElementById('carListings');
    carListingsContainer.innerHTML = ''; // Clear existing listings

    cars.forEach(car => {
        const carCard = `
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <a href="${car.slug}">
                        <img src="${car.photo}" class="card-img-top" alt="${car.maker}">
                    </a>

                    <div class="card-body">
                        <h5 class="card-title">${car.maker} ${car.model}</h5>
                        <p class="card-text">Price: $${car.car_price}</p>
                        <p class="card-text">Year: ${car.car_year}</p>
                        <p class="card-text">Mileage: ${car.car_mileage} ${car.car_mileage_unit}</p>
                        <p class="card-text">car trim: ${car.car_trim}</p>
                        <p class="card-text">car vin: ${car.car_vin}</p>
                        <p class="card-text">car transmission: ${car.car_transmission}</p>
                        <p class="card-text">interrior color: ${car.car_interrior_color}</p>
                        <p class="card-text">car certified: ${car.car_certified}</p>
                        <p class="card-text">vehicle type id: ${car.vehicle_type_id}</p>
                        <p class="card-text">status: ${car.post_status}</p>
                        <p class="card-text">price range: ${car.p_range}</p>
                        <p class="card-text">icl_post_language: ${car.icl_post_language}</p>
                        <p class="card-text" style="display:none">guid: ${car.guid}</p>
                        <p class="card-text">stock: ${car.stock}</p>
                        <p class="card-text">condition: ${car.condition}</p>
                        <p class="card-text">dealer_id: ${car.dealer_id}</p>
                        <p class="card-text">car_dealer_id: ${car.car_dealer_id}</p>
                        <p class="card-text">cardealer_dealer_email: ${car.cardealer_dealer_email}</p>
                        <p class="card-text">cardealer_dealer_phone: ${car.cardealer_dealer_phone}</p>
                        <p class="card-text" style="display:none">cardealer_dealer_logo: ${car.cardealer_dealer_logo}</p>
                        <p class="card-text">Dealer website_url: ${car.dealer.website_url}</p>
                        <p class="card-text">bdc_accounts: ${car.dealer.bdc_accounts}</p>
                    </div>
                </div>
            </div>
        `;
        carListingsContainer.insertAdjacentHTML('beforeend', carCard);
    });
}
