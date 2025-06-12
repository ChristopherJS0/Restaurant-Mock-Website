document.addEventListener('DOMContentLoaded', function () {
    const menuItems = document.querySelectorAll('.menu-item');
    const cart = []; // Holds the items added to cart.
    const cartItemsContainer = document.querySelector('.cart-items');
    console.log('Cart behavior script loaded');

    function renderCart() {
        cartItemsContainer.innerHTML = ''; // Clear existing items

        cart.forEach((item, index) => {
        const itemDiv = document.createElement('div');
        itemDiv.classList.add('cart-item');
        itemDiv.textContent = `${item.name} - $${item.price.toFixed(2)}`;

        // Add remove button
        const removeBtn = document.createElement('button');
        removeBtn.textContent = 'Remove';
        removeBtn.addEventListener('click', () => {
            cart.splice(index, 1);  // Remove item from cart array
            renderCart();           // Re-render cart
        });

        itemDiv.appendChild(removeBtn);
        cartItemsContainer.appendChild(itemDiv);
        });

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
});