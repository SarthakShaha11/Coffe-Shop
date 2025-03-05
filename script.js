// Select elements
const searchForm = document.querySelector('.search-form');
const cartContainer = document.querySelector('.cart-items-container');
const navbar = document.querySelector('.navbar');

// Event listeners
document.querySelector('#search-btn').onclick = () => {
  searchForm.classList.toggle('active');
  cartContainer.classList.remove('active');
  navbar.classList.remove('active');
}

window.onscroll = () => {
  searchForm.classList.remove('active');
  cartContainer.classList.remove('active');
  navbar.classList.remove('active');
}

// Product rating stars
const stars = document.querySelectorAll('.stars i');
stars.forEach((star, index1) => {
  star.addEventListener('click', () => {
    stars.forEach((star, index2) => {
      index1 >= index2 ? star.classList.add('active') : star.classList.remove('active');
    });
  });
});

*/regiter-form/*

document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector('.register-form');

    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting

        // Get form values
        const username = form.querySelector('input[type="text"]').value.trim();
        const phone = form.querySelector('input[type="tel"]').value.trim();
        const email = form.querySelector('input[type="email"]').value.trim();
        const password = form.querySelector('input[type="password"]').value.trim();

        // Validate inputs
        if (!validateUsername(username)) {
            alert("Please enter a valid username (at least 3 characters).");
            return;
        }

        if (!validatePhone(phone)) {
            alert("Please enter a valid phone number.");
            return;
        }

        if (!validateEmail(email)) {
            alert("Please enter a valid email address.");
            return;
        }

        if (!validatePassword(password)) {
            alert("Password must be at least 6 characters long.");
            return;
        }

        // If all validations pass
        alert("Registration successful!");
        form.submit(); // Submit the form
    });

    function validateUsername(username) {
        return username.length >= 3;
    }

    function validatePhone(phone) {
        // Basic phone number validation (checks for 10 digits)
        const phoneRegex = /^\d{10}$/;
        return phoneRegex.test(phone);
    }

    function validateEmail(email) {
        // Basic email pattern validation
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    function validatePassword(password) {
        return password.length >= 6;
    }
});

*/login page-form/*

document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector('.login-form');

    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting

        // Get form values
        const username = form.querySelector('input[type="text"]').value.trim();
        const phone = form.querySelector('input[type="tel"]').value.trim();
        const password = form.querySelector('input[type="password"]').value.trim();

        // Validate inputs
        if (!validateUsername(username)) {
            alert("Please enter a valid username (at least 3 characters).");
            return;
        }

        if (!validatePhone(phone)) {
            alert("Please enter a valid phone number.");
            return;
        }

        if (!validatePassword(password)) {
            alert("Password must be at least 6 characters long.");
            return;
        }

        // If all validations pass
        alert("Login successful!");
        form.submit(); // Submit the form
    });

    function validateUsername(username) {
        return username.length >= 3;
    }

    function validatePhone(phone) {
        // Basic phone number validation (checks for 10 digits)
        const phoneRegex = /^\d{10}$/;
        return phoneRegex.test(phone);
    }

    function validatePassword(password) {
        return password.length >= 6;
    }
});

*/Product page/*

document.addEventListener("DOMContentLoaded", function() {
    // Toggling the search bar
    const searchBtn = document.getElementById('search-btn');
    const searchForm = document.querySelector('.search-form');
    const searchBox = document.getElementById('search-box');

    searchBtn.addEventListener('click', function() {
        searchForm.style.display = searchForm.style.display === 'flex' ? 'none' : 'flex';
    });

    // Toggling the menu on small screens
    const menuBtn = document.getElementById('menu-btn');
    const navbar = document.querySelector('.navbar');

    menuBtn.addEventListener('click', function() {
        navbar.classList.toggle('active');
    });

    // Add a click listener for the shopping cart icon (if needed)
    const cartBtn = document.getElementById('cart-btn');

    cartBtn.addEventListener('click', function() {
        alert("Shopping cart feature coming soon!");
    });
});

*/order page/*

// Add item to cart
const addToCartButtons = document.querySelectorAll('.products .btn');
addToCartButtons.forEach(button => {
  button.addEventListener('click', () => {
    const item = button.closest('.box');
    const itemName = item.querySelector('h3').textContent;
    const itemPrice = item.querySelector('.price').textContent;
    const itemImage = item.querySelector('img').src;

  
    // Get form values
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const product = document.getElementById('product').value;
    const quantity = document.getElementById('quantity').value;
    const address = document.getElementById('address').value;

    // Create an order summary
    const orderSummary = `
        Thank you, ${name}, for your order! <br>
        You have ordered <strong>${quantity}</strong> of <strong>${product}</strong>.<br>
        We will deliver it to: <br>
        <strong>${address}</strong><br>
        A confirmation email will be sent to <strong>${email}</strong>.
    `;

    // Display the order summary
    document.getElementById('summaryText').innerHTML = orderSummary;
    document.getElementById('orderSummary').classList.remove('hidden');
    document.getElementById('orderForm').classList.add('hidden');
});

*/Payment page/*

function openCity(evt, cityName) {
  var i, tabcontent, tablinks;

  // Get all elements with class="tabcontent" and hide them
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  // Get all elements with class="tablinks" and remove the class "active"
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }

  // Show the current tab, and add an "active" class to the button that opened the tab
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}

// Automatically click on the default tab when the page loads
document.getElementById("defaultOpen").click();

*/Admin register/*
document.getElementById('registrationForm').addEventListener('submit', function(e) {
    e.preventDefault();

    let username = document.getElementById('username').value;
    let password = document.getElementById('password').value;
    let confirmPassword = document.getElementById('confirmPassword').value;
    let message = document.getElementById('message');

    if (password !== confirmPassword) {
        message.textContent = "Passwords do not match!";
        message.style.color = "red";
        return;
    }

    // Store admin details in localStorage (temporary and only on the client-side)
    localStorage.setItem('adminUsername', username);
    localStorage.setItem('adminPassword', password);

    message.textContent = "Registration successful!";
    message.style.color = "green";

    // Optionally, clear the form
    document.getElementById('registrationForm').reset();
});
*/manage product/*
document.addEventListener('DOMContentLoaded', function () {
    const productForm = document.getElementById('productForm');
    const productList = document.getElementById('productList');

    // Load existing products from localStorage
    let products = JSON.parse(localStorage.getItem('products')) || [];

    // Function to render the product list
    function renderProducts() {
        productList.innerHTML = '';

        products.forEach((product, index) => {
            const productElement = document.createElement('div');
            productElement.className = 'product';
            productElement.innerHTML = `
                <span>${product.name}</span>
                <span>$${product.price.toFixed(2)}</span>
                <button onclick="editProduct(${index})">Edit</button>
                <button onclick="deleteProduct(${index})">Delete</button>
            `;
            productList.appendChild(productElement);
        });
    }

    // Function to add a new product
    productForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const name = document.getElementById('productName').value;
        const price = parseFloat(document.getElementById('productPrice').value);

        products.push({ name, price });
        localStorage.setItem('products', JSON.stringify(products));

        renderProducts();

        // Clear the form
        productForm.reset();
    });


    // Function to edit a product
    window.editProduct = function (index) {
        const product = products[index];

        document.getElementById('productName').value = product.name;
        document.getElementById('productPrice').value = product.price;

        // Update the form submission to handle editing
        productForm.onsubmit = function (e) {
            e.preventDefault();

            products[index].name = document.getElementById('productName').value;
            products[index].price = parseFloat(document.getElementById('productPrice').value);

            localStorage.setItem('products', JSON.stringify(products));
            renderProducts();

            // Reset form submission and form
            productForm.onsubmit = null;
            productForm.reset();
        };
    };

    // Function to delete a product
    window.deleteProduct = function (index) {
        products.splice(index, 1);
        localStorage.setItem('products', JSON.stringify(products));
        renderProducts();
    };

    // Initial render
    renderProducts();
});


*/out of stock*/
document.addEventListener('DOMContentLoaded', function () {
    const productForm = document.getElementById('productForm');
    const productList = document.getElementById('productList');

    // Load existing products from localStorage
    let products = JSON.parse(localStorage.getItem('products')) || [];

    // Function to render the product list
    function renderProducts() {
        productList.innerHTML = '';

        products.forEach((product, index) => {
            const productElement = document.createElement('div');
            productElement.className = 'product';
            productElement.innerHTML = `
                <span class="${product.outOfStock ? 'out-of-stock' : ''}">${product.name}</span>
                <button onclick="toggleStockStatus(${index})">${product.outOfStock ? 'Mark In Stock' : 'Mark Out of Stock'}</button>
                <button onclick="deleteProduct(${index})">Delete</button>
            `;
            productList.appendChild(productElement);
        });
    }

    // Function to add a new product
    productForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const name = document.getElementById('productName').value;

        products.push({ name, outOfStock: false });
        localStorage.setItem('products', JSON.stringify(products));

        renderProducts();

        // Clear the form
        productForm.reset();
    });

    // Function to toggle the stock status
    window.toggleStockStatus = function (index) {
        products[index].outOfStock = !products[index].outOfStock;
        localStorage.setItem('products', JSON.stringify(products));
        renderProducts();
    };

    // Function to delete a product
    window.deleteProduct = function (index) {
        products.splice(index, 1);
        localStorage.setItem('products', JSON.stringify(products));
        renderProducts();
    };

    // Initial render
    renderProducts();
});
*/ Report/*
document.addEventListener('DOMContentLoaded', function () {
    // Load existing products from localStorage
    let products = JSON.parse(localStorage.getItem('products')) || [];

    // Calculate total number of products
    const totalProducts = products.length;

    // Calculate number of out of stock products
    const outOfStockProducts = products.filter(product => product.outOfStock).length;

    // Calculate number of in stock products
    const inStockProducts = totalProducts - outOfStockProducts;

    // Display the report data on the page
    document.getElementById('totalProducts').textContent = totalProducts;
    document.getElementById('outOfStockProducts').textContent = outOfStockProducts;
    document.getElementById('inStockProducts').textContent = inStockProducts;
});

*/cancletion page/*
  document.getElementById('cancelForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const orderNumber = document.getElementById('order-number').value;
            const email = document.getElementById('email').value;
            const reason = document.getElementById('reason').value;

            const data = {
                order_number: orderNumber,
                email: email,
                reason: reason,
                _subject: 'Order Cancellation Request'
            };

            fetch('https://formspree.io/f/your-form-id', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => {
                if (response.ok) {
                    document.querySelector('.success-message').style.display = 'block';
                    document.querySelector('.error-message').style.display = 'none';
                    document.getElementById('cancelForm').reset();
                } else {
                    throw new Error('Network response was not ok.');
                }
            })
            .catch(error => {
                document.querySelector('.success-message').style.display = 'none';
                document.querySelector('.error-message').style.display = 'block';
                console.error('There was a problem with the fetch operation:', error);
            });
        });

document.addEventListener('DOMContentLoaded', function () {
    showSection('dashboard'); // Show the dashboard by default
});

function showSection(sectionId) {
    const sections = document.querySelectorAll('.content-section');
    sections.forEach(section => {
        section.classList.remove('active');
        if (section.id === sectionId) {
            section.classList.add('active');
        }
    });
}

function addUser() {
    const userList = document.getElementById('userList');
    const userName = prompt('Enter the name of the user:');
    if (userName) {
        const li = document.createElement('li');
        li.textContent = userName;
        userList.appendChild(li);
    }
}


