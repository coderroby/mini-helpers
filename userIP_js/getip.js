// Send an AJAX request to a server-side script to get the user's IP address
const xhr = new XMLHttpRequest();

xhr.onreadystatechange = function() {
    if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
            console.log('User IP Address (JavaScript):', xhr.responseText);
        } else {
            console.error('Error fetching IP address:', xhr.statusText);
        }
    }
};

// Replace 'your-server-script.php' with the actual path to your server-side script
xhr.open('GET', 'your-server-script.php', true);
xhr.send();