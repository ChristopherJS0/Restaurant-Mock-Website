document.addEventListener('DOMContentLoaded', function () {
    const menuItems = document.querySelectorAll('.menu-item');
    const cart = []; // Holds the items added to cart.
    const cartItemsContainer = document.querySelector('.cart-items');
    console.log('Cart behavior script loaded');

    function renderCart() {
        const totalSpan = document.getElementById('total-amount');
        cartItemsContainer.innerHTML = ''; // Clear existing items

        let totalPrice = 0;

        cart.forEach((item, index) => {
        const itemDiv = document.createElement('div');
        itemDiv.classList.add('cart-item');
        itemDiv.textContent = `${item.name} - $${item.price.toFixed(2)}`;

        // Add remove button
        const removeBtn = document.createElement('button');
        removeBtn.textContent = 'Remove';
        removeBtn.addEventListener('click', () => {
            console.log('Total price is now:', totalPrice.toFixed(2));
            cart.splice(index, 1);  // Remove item from cart array
            renderCart();           // Re-render cart
        });

        itemDiv.appendChild(removeBtn);
        cartItemsContainer.appendChild(itemDiv);
        totalPrice += item.price;
        });

        totalSpan.textContent = totalPrice.toFixed(2);

        // Optional: If cart empty, show message
        if (cart.length === 0) {
        cartItemsContainer.textContent = 'Your cart is empty.';
        }
    }

    // Add click event to each menu item
    menuItems.forEach(item => 
        { item.addEventListener('click', () => {

        const itemName = item.dataset.name;
        const itemPrice = parseFloat(item.dataset.price);

        console.log(`Added ${itemName} to cart`);
        console.log(`Price: ${itemPrice}`);

        // Add item to cart array
        const orderItem = {
            name: itemName,
            price:itemPrice
        };
        cart.push(orderItem);        
        renderCart();

        // Console read messages for testing.
        console.log('Added to cart:', orderItem.name);
        console.log('Cart size is currently:', cart.length);
    });
    });

        // Add this block for handling the form submission
    const orderForm = document.getElementById('order-form');
    if (orderForm) {
        orderForm.addEventListener('submit', function (e) {
            // Serialize cart and total price into hidden inputs
            const cartDataInput = document.getElementById('cart-data');
            const totalPriceInput = document.getElementById('total-amount-input');

            cartDataInput.value = JSON.stringify(cart);

            // Calculate total price again or keep track globally
            let totalPrice = cart.reduce((sum, item) => sum + item.price, 0);
            totalPriceInput.value = totalPrice.toFixed(2);

            // The form will submit normally after this
        });
    }



});