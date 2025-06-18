  const orderTableBody = document.querySelector('#order-table tbody');
  const totalPriceSpan = document.getElementById('total-price');
  const cartDataInput = document.getElementById('cartDataInput');
  const totalPriceInput = document.getElementById('totalPriceInput');

  // Parse cart data from hidden input
  let cart = JSON.parse(cartDataInput.value);

  // Recalculate total price and update display + hidden input
  function updateTotalPrice() {
    const total = cart.reduce((sum, item) => sum + parseFloat(item.price), 0);
    totalPriceSpan.textContent = total.toFixed(2);
    totalPriceInput.value = total.toFixed(2);
  }

  // Remove item from cart by index, update table & inputs
  function removeItem(index) {
    cart.splice(index, 1);
    renderTable();
    updateTotalPrice();
  }

  // Render the table rows dynamically
  function renderTable() {
    orderTableBody.innerHTML = '';

    if (cart.length === 0) {
      orderTableBody.innerHTML = '<tr><td colspan="3">Your cart is empty.</td></tr>';
      cartDataInput.value = JSON.stringify(cart);
      return;
    }

    cart.forEach((item, idx) => {
      const tr = document.createElement('tr');
      tr.setAttribute('data-index', idx);

      const tdName = document.createElement('td');
      tdName.textContent = item.name;

      const tdPrice = document.createElement('td');
      tdPrice.textContent = `$${parseFloat(item.price).toFixed(2)}`;

      const tdRemove = document.createElement('td');
      const btnRemove = document.createElement('button');
      btnRemove.type = 'button';
      btnRemove.textContent = 'Remove';
      btnRemove.classList.add('remove-btn');
      btnRemove.addEventListener('click', () => {
        removeItem(idx);
      });
      tdRemove.appendChild(btnRemove);

      tr.appendChild(tdName);
      tr.appendChild(tdPrice);
      tr.appendChild(tdRemove);

      orderTableBody.appendChild(tr);
    });

    // Update hidden input cartData
    cartDataInput.value = JSON.stringify(cart);
  }

  // Initial render (in case JS needs to update anything)
  renderTable();
  updateTotalPrice();