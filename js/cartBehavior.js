document.addEventListener('DOMContentLoaded', function () {
    const menuItems = document.querySelectorAll('.menu-item');
    const cart = []; // Holds the items added to cart.

    console.log('Cart behavior script loaded');
    
    // Add click event to each menu item

    menuItems.forEach(item => 
        { item.addEventListener('click', () => {
        const itemName = item.dataset.name;
        const itemPrice = parseFloat(item.dataset.price);

        console.log(`Added ${itemName} to cart`);
        console.log(`Price: ${itemPrice}`);

        const orderItem = {
            name: itemName,
            price:itemPrice
        };

        //Adding to cart.
        cart.push(orderItem);
        console.log('Added to cart:', orderItem.name);
        
        //Size of Cart
        console.log('Cart size is currently:', cart.length);
    });
    });
});