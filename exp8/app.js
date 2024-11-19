const cartBtn = document.getElementById('your-cart-btn');
const closeCartBtn = document.querySelector('.fa-remove');
const cartDOM = document.querySelector('.cart');
const cartOverlay = document.querySelector('.cart-overlay');
const cartContent = document.querySelector('.cart-content');
const noOfcartItems = document.querySelector('.cart-item-no');
const cartTotal = document.querySelector('.cart-total');
const clearCartBtn = document.querySelector('.clear-cart');
const menuContainer = document.querySelector('.menu-container');
const btnContainer = document.querySelector('.btns');

let cart = [];
let buttonsDOM = [];

class Products {
  async getProducts() {
    try {
      let result = await fetch('products.php');
      let data = await result.json();
      const products = data.items.map(function (item) {
        const { name, desc, price, category } = item.fields;
        const { id } = item.sys;
        const img = item.fields.img.fields.file.url;
        return { id, name, desc, price, category, img };
      });
      return products;
    } catch (error) {
      console.log(error);
    }
  }
}

class UI {
  displayMenuItems(menu) {
    let displayMenu = menu.map((item) => {
      return `<div class="container">
          <img src="${item.img}" alt="${item.name}" />
          <div class="content">
            <h4>${item.name}</h4>
            <p>
              ${item.desc}
            </p>
            <div class="row">
              <span>$${item.price}</span>
              <button class="btn cart-btn" data-id=${item.id}>Add to Cart</button>
            </div>
          </div>
        </div>`;
    });
    displayMenu = displayMenu.join('');
    menuContainer.innerHTML = displayMenu;
    this.updateCartButtons();
  }

  displayMenuButtons(menuItems) {
    const categories = menuItems.reduce(
      (acc, item) => {
        if (!acc.includes(item.category)) {
          acc.push(item.category);
        }
        return acc;
      },
      ['all']
    );

    const categoryBtns = categories
      .map((category) => {
        return `<button class="btn menu-btn" data-id="${category}">${category}</button>`;
      })
      .join('');
    btnContainer.innerHTML = categoryBtns;

    const menuBtns = btnContainer.querySelectorAll('.menu-btn');

    menuBtns.forEach((btn) => {
      btn.addEventListener('click', (event) => {
        const filter = event.target.dataset.id;
        if (filter === 'all') {
          this.displayMenuItems(menuItems);
        } else {
          const filteredItems = menuItems.filter(
            (item) => item.category === filter
          );
          this.displayMenuItems(filteredItems);
        }
        this.addToCart();
      });
    });
  }

  addToCart() {
    buttonsDOM = [...document.querySelectorAll('.cart-btn')];
    buttonsDOM.forEach((cartBtn) => {
      let id = cartBtn.dataset.id;
      let inCart = cart.find((item) => item.id === id);
      if (inCart) {
        cartBtn.innerText = 'In Cart';
        cartBtn.disabled = true;
      }

      cartBtn.addEventListener('click', (event) => {
        event.target.innerText = 'In Cart';
        event.target.disabled = true;

        let cartItem = { ...Storage.getProduct(id), amount: 1 };
        cart = [...cart, cartItem];
        Storage.saveCart(cart);
        this.setCartValues(cart);
        this.addCartItem(cartItem);
        this.displayCart();
      });
    });
  }

  updateCartButtons() {
    buttonsDOM = [...document.querySelectorAll('.cart-btn')];
    buttonsDOM.forEach((cartBtn) => {
      let id = cartBtn.dataset.id;
      let inCart = cart.find((item) => item.id === id);
      if (inCart) {
        cartBtn.innerText = 'In Cart';
        cartBtn.disabled = true;
      }
    });
  }

  setCartValues(cart) {
    let tempTotal = 0;
    let itemsTotal = 0;
    cart.forEach((item) => {
      tempTotal += item.price * item.amount;
      itemsTotal += item.amount;
    });
    noOfcartItems.innerText = itemsTotal;
    cartTotal.innerText = parseFloat(tempTotal.toFixed(2));
  }

  addCartItem(item) {
    const div = document.createElement('div');
    div.classList.add('cart-item');
    div.innerHTML = `<img src="${item.img}" alt="${item.name}" />
            <div class="desc">
              <h4>${item.name}</h4>
              <div class="row">
                <span>$${item.price}</span>
                <button class="btn rem-btn" data-id=${item.id}>Remove</button>
              </div>
            </div>
            <div class="quantity">
              <i class="fa-solid fa-chevron-up" data-id=${item.id}></i>
              <span>${item.amount}</span>
              <i class="fa-solid fa-chevron-down" data-id=${item.id}></i>
            </div>`;
    cartContent.appendChild(div);
  }

  displayCart() {
    cartOverlay.classList.add('transparentBcg');
    cartDOM.classList.add('showCart');
  }

  hideCart() {
    cartOverlay.classList.remove('transparentBcg');
    cartDOM.classList.remove('showCart');
  }

  setUpApp() {
    cart = Storage.getProductData();
    this.setCartValues(cart);
    this.populateCart(cart);
    cartBtn.addEventListener('click', this.displayCart);
    closeCartBtn.addEventListener('click', this.hideCart);
  }

  populateCart(cart) {
    cart.forEach((item) => this.addCartItem(item));
  }

  cartLogic() {
    clearCartBtn.addEventListener('click', () => {
      this.clearCart();
    });

    cartContent.addEventListener('click', (event) => {
      let id = event.target.dataset.id;
      if (event.target.classList.contains('rem-btn')) {
        this.removeItem(id);
        cartContent.removeChild(
          event.target.parentElement.parentElement.parentElement
        );
      } else if (event.target.classList.contains('fa-chevron-up')) {
        let tempItem = cart.find((item) => item.id === id);
        tempItem.amount += 1;
        event.target.nextElementSibling.innerText = tempItem.amount;
        this.setCartValues(cart);
        Storage.saveCart(cart);
      } else if (event.target.classList.contains('fa-chevron-down')) {
        let tempItem = cart.find((item) => item.id === id);
        tempItem.amount -= 1;
        if (tempItem.amount === 0) {
          this.removeItem(id);
          cartContent.removeChild(event.target.parentElement.parentElement);
        } else {
          event.target.previousElementSibling.innerText = tempItem.amount;
          this.setCartValues(cart);
          Storage.saveCart(cart);
        }
      }
    });
  }

  clearCart() {
    let cartItems = cart.map((item) => item.id);
    cartItems.forEach((id) => this.removeItem(id));
    console.log(cartContent.children);
    while (cartContent.children.length > 0) {
      cartContent.removeChild(cartContent.children[0]);
    }
    this.hideCart();
  }

  removeItem(id) {
    cart = cart.filter((item) => item.id !== id);
    this.setCartValues(cart);
    Storage.saveCart(cart);
    let button = this.getSingleButton(id);
    button.disabled = false;
    button.innerText = 'Add to Cart';
  }

  getSingleButton(id) {
    return buttonsDOM.find((button) => button.dataset.id === id);
  }
}

class Storage {
  static saveProducts(menuItems) {
    localStorage.setItem('menuItems', JSON.stringify(menuItems));
  }

  static getProduct(id) {
    let menu_items = JSON.parse(localStorage.getItem('menuItems'));
    return menu_items.find(function (menu_item) {
      return menu_item.id === id;
    });
  }

  static saveCart(cart) {
    localStorage.setItem('cart', JSON.stringify(cart));
  }

  static getProductData() {
    return localStorage.getItem('cart')
      ? JSON.parse(localStorage.getItem('cart'))
      : [];
  }
}

window.addEventListener('DOMContentLoaded', function () {
  const ui = new UI();
  const products = new Products();

  products
    .getProducts()
    .then((menuItems) => {
      ui.displayMenuButtons(menuItems);
      ui.displayMenuItems(menuItems);
      Storage.saveProducts(menuItems);
    })
    .then(() => {
      ui.addToCart();
      ui.cartLogic();
    })
    .catch((err) => {
      console.log(err);
    });

  ui.setUpApp();
});
