function countSubtotal() {
  let data = JSON.parse(localStorage.getItem('cart'));

  let subtotal = 0;
  data = JSON.parse(localStorage.getItem('cart'));

  data.map((item) => {
    subtotal += item.quantity * item.price.replace('Rs. ', '');

    document.querySelector('.subtotal').innerHTML = 'Total: ' + subtotal;
  });

  if (data.length < 1) {
    document.querySelector('.subtotal').remove();
    document.querySelector('#place-order').remove();

    document.querySelector('.empty-cart-warning').style.display = 'block';
  } else {
    document.querySelector('.empty-cart-warning').style.display = 'none';
  }
}

function handleAddToCart(event, id) {
  event.preventDefault();

  console.log(id);

  const parent = document.querySelector(`[data-id="${id}"]`);
  let title = parent.querySelector('#item-title').innerText;
  let image = parent.querySelector('#item-image').getAttribute('src');
  let quantity = parseInt(parent.querySelector('#item-quantity').value);
  let price = parent.querySelector('#item-price').innerText;

  const item = { id, title, image, quantity, price };

  if (localStorage.getItem('cart')) {
    let data = JSON.parse(localStorage.getItem('cart'));

    const itemToUpdate = data.find((item) => item.id === id);

    if (itemToUpdate) {
      itemToUpdate.quantity += quantity;
    } else {
      data.push(item);
    }
    localStorage.setItem('cart', JSON.stringify(data));
  } else {
    localStorage.setItem('cart', JSON.stringify([item]));
  }

  alert('Item added to cart');

  updateCart();
}

function updateCart() {
  if (!localStorage.getItem('cart')) {
    return;
  }

  let data = JSON.parse(localStorage.getItem('cart'));

  const parent = document.querySelector('.cart-items');

  data.map((item) => {
    parent.insertAdjacentHTML(
      'afterbegin',
      `<div class="item" data-id="${item.id}">
              <img id="cart-item-image" src="${item.image}" alt="${item.title}">
              <div>
                  <h3 id="cart-item-title">${item.title}</h3>
                  <p id="cart-item-price">${item.price}</p>
                  <span>${item.quantity}</span>
                  <input type="submit" value="Remove from cart" onclick="handleRemoveFromCart(event, ${item.id});">
              </div>
            </div>`
    );
  });

  countSubtotal();
}
if (document.querySelector('.cart-items')) {
  updateCart();
}

function handleRemoveFromCart(event, id) {
  event.preventDefault();

  if (localStorage.getItem('cart')) {
    let data = JSON.parse(localStorage.getItem('cart'));

    const itemToUpdate = data.find((item) => item.id === id);

    if (itemToUpdate) {
      if (itemToUpdate.quantity === 1) {
        const parent = document.querySelector(`[data-id="${id}"]`);
        parent.remove();

        data = data.filter((item) => item.id !== id);
      } else {
        itemToUpdate.quantity -= 1;

        const parent = document.querySelector(`[data-id="${id}"]`);
        let quantity = parent.querySelector('span').innerText;
        parent.querySelector('span').innerText = +quantity - 1;
      }
    } else {
      data.push(item);
    }

    localStorage.setItem('cart', JSON.stringify(data));
  } else {
    localStorage.setItem('cart', JSON.stringify([item]));
  }

  countSubtotal();
}

function handlePlaceOrder() {
  let data = JSON.parse(localStorage.getItem('cart'));
  const req = { data: data };

  fetch('place-order.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json; charset=utf-8',
    },
    body: JSON.stringify(req),
  })
    .then(function (res) {
      return res.text();
    })
    .then(function (data) {
      if (data === 'Success') {
        console.log('Success');
        window.location.replace('profile.php');
        localStorage.setItem('cart', '');
      } else {
        console.log('Error occured');
      }
    });
}

function updateOrderStatus(event, id) {
  const span = document.querySelector(`#span-${id}`);
  const served = document.querySelector(`#checked-${id}`).checked ? 1 : 0;

  const data = {
    id: id,
    served: served,
  };

  fetch('update-order-status.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json; charset=utf-8',
    },
    body: JSON.stringify(data),
  })
    .then(function (res) {
      return res.text();
    })
    .then(function (data) {
      console.log(data);

      console.log(span.innerHTML);

      if (served === 1) {
        span.innerHTML = 'Served';
      } else {
        span.innerHTML = 'Not served';
      }
    });
}

function editProfile() {
  const status = document
    .querySelector('.edit-profile')
    .getAttribute('data-status');

  const ele = document.querySelectorAll('.profile-input');
  if (status === 'edit') {
    for (let i = 0; i < ele.length; i++) {
      ele[i].classList.add('show-input');
    }

    document
      .querySelector('.edit-profile')
      .setAttribute('data-status', 'cancel');
    document.querySelector('.edit-profile').classList.add('fa-xmark');
  } else {
    for (let i = 0; i < ele.length; i++) {
      ele[i].classList.remove('show-input');
    }

    document.querySelector('.edit-profile').setAttribute('data-status', 'edit');
    document.querySelector('.edit-profile').classList.remove('fa-xmark');
  }
}
