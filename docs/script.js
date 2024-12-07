// script.js

// Function to fetch vehicles from the server
async function fetchVehicles() {
    const vehicleGallery = document.querySelector('.vehicle-gallery');
    const loadingMessage = document.createElement('p');
    loadingMessage.textContent = 'Loading vehicles...';
    loadingMessage.className = 'loading-message';
    vehicleGallery.appendChild(loadingMessage); // Display the loading message

    try {
        const response = await fetch('http://localhost/WEB%20PROJECT/backend/get_vehicles.php');

        if (!response.ok) {
            throw new Error(`Network response was not ok: ${response.statusText}`);
        }

        const vehicles = await response.json();
        displayVehicles(vehicles); // Populate the gallery with fetched vehicles
    } catch (error) {
        console.error('Error fetching vehicles:', error);
        displayError('Failed to load vehicles. Please try again later.'); // Show a friendly error message
    } finally {
        loadingMessage.remove(); // Remove the loading message regardless of success or failure
    }
}

// Function to display vehicles in the vehicle gallery
function displayVehicles(vehicles) {
    const vehicleGallery = document.querySelector('.vehicle-gallery');
    vehicleGallery.innerHTML = ''; // Clear existing vehicles

    vehicles.forEach(vehicle => {
        const vehicleCard = document.createElement('div');
        vehicleCard.className = 'vehicle-card';
        vehicleCard.innerHTML = `
            <img src="${vehicle.image}" alt="${vehicle.name}" onerror="this.onerror=null; this.src='images/default.jpg';">
            <p><strong>${vehicle.name}</strong></p>
            <p>Price: $${vehicle.price}</p>
        `;
        vehicleGallery.appendChild(vehicleCard);
    });
}

// Function to display an error message in the gallery
function displayError(message) {
    const vehicleGallery = document.querySelector('.vehicle-gallery');
    vehicleGallery.innerHTML = ''; // Clear existing content
    const errorMessage = document.createElement('p');
    errorMessage.textContent = message;
    errorMessage.className = 'error-message';
    vehicleGallery.appendChild(errorMessage);
}

// Call fetchVehicles when the page loads
document.addEventListener('DOMContentLoaded', fetchVehicles);


// Function to handle vehicle search
async function searchVehicles(event) {
    event.preventDefault();
    const vehicleType = document.getElementById('vehicleType').value;

    try {
        const response = await fetch(`http://localhost/WEB%20PROJECT/backend/search_vehicles.php?type=${encodeURIComponent(vehicleType)}`);
        const vehicles = await response.json();
        displayVehicles(vehicles);
    } catch (error) {
        console.error('Error searching vehicles:', error);
    }
}


// Function to handle price filtering
async function filterByPrice() {
    const minPrice = document.getElementById('minPriceRange').value;
    const maxPrice = document.getElementById('maxPriceRange').value;

    if (!minPrice || !maxPrice) {
        alert("Please enter both minimum and maximum price.");
        return;
    }

   

    try {
        const response = await fetch(`http://localhost/WEB%20PROJECT/backend/filter_by_price.php?min=${minPrice}&max=${maxPrice}`);
        const vehicles = await response.json();
        displayVehicles(vehicles);
    } catch (error) {
        console.error('Error filtering vehicles:', error);
    }
}

// Add event listeners
document.getElementById('searchForm').addEventListener('submit', searchVehicles);
document.querySelector('.price-filter button').addEventListener('click', filterByPrice);

// Fetch all vehicles on page load
window.onload = fetchVehicles;