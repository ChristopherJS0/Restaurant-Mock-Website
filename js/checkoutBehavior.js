  const orderTableBody = document.querySelector('#order-table tbody');
  const totalPriceSpan = document.getElementById('total-price');
  const cartDataInput = document.getElementById('cartDataInput');
  const totalPriceInput = document.getElementById('totalPriceInput');
  const tdNote = document.createElement('td');


  // Parse cart data from hidden input
  let cart = JSON.parse(cartDataInput.value);

  // Recalculate total price and update display + hidden input
  function updateTotalPrice() {
    const total = cart.reduce((sum, item) => sum + parseFloat(item.price), 0);
    totalPriceSpan.textContent = total.toFixed(2);
    totalPriceInput.value = total.toFixed(2);
  }
  // Remove row on button click and update cart
  orderTableBody.querySelectorAll('.remove-btn').forEach((button, index) => {
    button.addEventListener('click', () => {
      cart.splice(index, 1);
      button.closest('tr').remove();
      cartDataInput.value = JSON.stringify(cart);
      updateTotalPrice();
    });
  });

updateTotalPrice();