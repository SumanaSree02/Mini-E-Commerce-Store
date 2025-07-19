// Global variables
let cart = [];
let currentPage = 'home';
let wishlist = [];


  const track = document.getElementById('carousel-track');
  const leftBtn = document.querySelector('.left-btn');
  const rightBtn = document.querySelector('.right-btn');

  const scrollStep = 300;

  leftBtn.addEventListener('click', () => {
    track.scrollBy({ left: -scrollStep, behavior: 'smooth' });
  });

  rightBtn.addEventListener('click', () => {
    track.scrollBy({ left: scrollStep, behavior: 'smooth' });
  });

  // Auto scroll
  setInterval(() => {
    track.scrollBy({ left: scrollStep, behavior: 'smooth' });

    // Optional: Reset to start when near end
    if (track.scrollLeft + track.offsetWidth >= track.scrollWidth - 10) {
      track.scrollTo({ left: 0, behavior: 'smooth' });
    }
  }, 4000); // Every 4 seconds

  //newsletter
  function showSuccessMessage(event) {
    event.preventDefault(); // prevents page reload
    const message = document.getElementById('success-message');
    message.style.display = 'block';

    // Optional: reset form after submission
    event.target.reset();

    // Optional: hide message after a few seconds
    setTimeout(() => {
      message.style.display = 'none';
    }, 4000);
  }



// Sample product data
const featuredProducts = [
    {
        id: 1,
        name: 'Leather Loafers',
        price: 1299,
        image: 'https://images.pexels.com/photos/1598505/pexels-photo-1598505.jpeg?auto=compress&cs=tinysrgb&w=300'
    },
    {
        id: 2,
        name: 'Wooden lamp',
        price: 999,
        image: 'https://images.pexels.com/photos/1112598/pexels-photo-1112598.jpeg?auto=compress&cs=tinysrgb&w=300'
    },
    {
        id: 3,
        name: 'Leather Loafers',
        price: 599,
        image: 'https://images.pexels.com/photos/996329/pexels-photo-996329.jpeg?auto=compress&cs=tinysrgb&w=300'
    },
    {
        id: 4,
        name: 'Wireless Headphones',
        price: 2999,
        image: 'https://images.pexels.com/photos/788946/pexels-photo-788946.jpeg?auto=compress&cs=tinysrgb&w=300'
    }
];

const bestSellerProducts = [
    {
        id: 5,
        name: 'White Lace Top',
        price: 799,
        image: 'https://images.pexels.com/photos/1536619/pexels-photo-1536619.jpeg?auto=compress&cs=tinysrgb&w=200'
    },
    {
        id: 6,
        name: 'Blue Jeans',
        price: 1299,
        image: 'https://images.pexels.com/photos/1082529/pexels-photo-1082529.jpeg?auto=compress&cs=tinysrgb&w=200'
    },
    {
        id: 7,
        name: 'Beige Coat',
        price: 2499,
        image: 'https://images.pexels.com/photos/1043474/pexels-photo-1043474.jpeg?auto=compress&cs=tinysrgb&w=200'
    },
    {
        id: 8,
        name: 'Top Book',
        price: 399,
        image: 'https://images.pexels.com/photos/159711/books-bookstore-book-reading-159711.jpeg?auto=compress&cs=tinysrgb&w=200'
    }
];

const popularProducts = [
    { id: 9, name: 'Black Dress', image: 'https://images.pexels.com/photos/1536619/pexels-photo-1536619.jpeg?auto=compress&cs=tinysrgb&w=150' },
    { id: 10, name: 'White Shirt', image: 'https://images.pexels.com/photos/996329/pexels-photo-996329.jpeg?auto=compress&cs=tinysrgb&w=150' },
    { id: 11, name: 'Brown Bag', image: 'https://images.pexels.com/photos/1598505/pexels-photo-1598505.jpeg?auto=compress&cs=tinysrgb&w=150' },
    { id: 12, name: 'Perfume', image: 'https://images.pexels.com/photos/1961795/pexels-photo-1961795.jpeg?auto=compress&cs=tinysrgb&w=150' },
    { id: 13, name: 'White Plate', image: 'https://images.pexels.com/photos/1112598/pexels-photo-1112598.jpeg?auto=compress&cs=tinysrgb&w=150' },
    { id: 14, name: 'Chair', image: 'https://images.pexels.com/photos/586744/pexels-photo-586744.jpeg?auto=compress&cs=tinysrgb&w=150' },
    { id: 15, name: 'Table', image: 'https://images.pexels.com/photos/1112598/pexels-photo-1112598.jpeg?auto=compress&cs=tinysrgb&w=150' },
    { id: 16, name: 'Lamp', image: 'https://images.pexels.com/photos/1112598/pexels-photo-1112598.jpeg?auto=compress&cs=tinysrgb&w=150' }
];

const categoriesData = [
  {
    name: 'Books & Stationery',
    icon: 'fas fa-book',
    subcategories: [
      {
        name: 'Academic Books',
      },
      {
        name: 'Novels & Comics',
      },
      {
        name: 'Notebooks & Diaries',
      },
      {
        name: 'Pens, Pencils & Art Supplies',
      },
      {
        name: 'Office supplies',
      }
    ]
  },
  {
    name: 'Electronics',
    icon: 'fas fa-mobile-alt',
    subcategories: [
      { 
        name: 'Mobiles & Tablets',
    },
      { name: 'Laptops & Accessories', 
    },
      { name: 'Headphones & Earphones', 
    },
      { name: 'Smart Devices (Watches, Speakers)', 
    },
      { name: 'Gaming Consoles & Accessories', 
    }
    ]
  },
  {
    name: 'Clothing',
    icon: 'fas fa-tshirt',
    subcategories: [
      { name: "Men's Wear", 
        
    },
      { name: "Women's Wear", 
},
      { name: "Kids' Clothing", 
    }
    ]
  },
  {
    name: 'Footwear',
    icon: 'fas fa-shoe-prints',
    subcategories: [
      { name: 'Casual Shoes', 
         },
      { name: 'Sports Shoes', 
        },
      { name: 'Heels & Sandals', 
         },
      { name: 'Flats & Slippers', 
         },
      { name: 'Boots & Formal Wear', 
         }
    ]
  },
  {
    name: 'Beauty & Personal Care',
    icon: 'fas fa-gem',
    subcategories: [
      { name: 'Skincare', 
        },
      { name: 'Makeup', 
         },
      { name: 'Haircare', 
         },
      { name: 'Fragrances', 
         }
    ]
  },
  {
    name: 'Home & Living',
    icon: 'fas fa-home',
    subcategories: [
      { name: 'Home Decor', 
        },
      { name: 'Kitchen & Appliances', 
         },
      { name: 'Home Textiles', 
         },
      { name: 'Home Improvement', 
        },
      { name: 'Furniture', 
         }
    ]
  },
  {
    name: 'Sports & Fitness',
    icon: 'fas fa-dumbbell',
    subcategories: [
      { name: 'Fitness Equipment', 
        },
      { name: 'Team Sports Gear', 
         },
      { name: 'Racket & Accessories', 
        },
      { name: 'Outdoor & Adventure', 
         },
      { name: 'Activewear', 
        }
    ]
  },
  {
    name: 'Food & Beverages',
    icon: 'fas fa-coffee',
    subcategories: [
      { name: 'Snacks', 
        },
      { name: 'Packaged Food', 
        },
      { name: 'Soft Drinks & Juices', 
        },
      { name: 'Instant & Ready Meals', 
         }
    ]
  },
  {
    name: 'Toys & Games',
    icon: 'fas fa-gamepad',
    subcategories: [
      { name: 'Educational Toys & Learning Toys', 
         },
      { name: 'Indoor games', 
         },
      { name: 'Soft Toys', 
        },
      { name: 'Action Figures', 
         }
    ]
  },
  {
    name: 'Bags &Travel Essentials',
    icon: 'fas fa-suitcase',
    subcategories: [
      { name: 'School Bags', 
        },
      { name: 'Handbags & Purses', 
         },
      { name: 'Travel Trolleys', 
       },
      { name: 'Laptop Bags', 
        },
      { name: 'Travel Kits', 
        },
      { name: 'Neck Pillows', 
         },
      { name: 'Luggage Tags', 
         },
      { name: 'Organizers & Pouche', 
         }
    ]
  }
];


// Initialize the application
document.addEventListener('DOMContentLoaded', function() {
    initializeApp();
    loadCartFromStorage();
    updateCartCount();
    loadWishlistFromStorage();
    renderCategories(categoriesData);
    updateWishlistDisplay();
});

function initializeApp() {
    // Navigation event listeners
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const page = this.getAttribute('href').substring(1);
            showPage(page);
        });
    });

    // Cart button event listener
    document.getElementById('cart-btn').addEventListener('click', function() {
        showPage('cart');
    });

    // Wishlist button event listener
    const wishlistBtn = document.getElementById('wishlist-btn');
    if (wishlistBtn) {
        wishlistBtn.addEventListener('click', function() {
            showPage('wishlist');
        });
    }

    // Login button event listener
    const loginBtn = document.getElementById('login-btn');
    const authModal = document.getElementById('auth-modal');
    const loginTypeSelection = document.getElementById('login-type-selection');
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');

    loginBtn.addEventListener('click', () => {
        authModal.style.display = 'block';
        loginTypeSelection.style.display = 'block';
        loginForm.classList.add('hidden');
        registerForm.classList.add('hidden');
    });

    // Modal event listeners
    const modalClose = document.getElementById('modal-close');
    modalClose.addEventListener('click', () => {
        authModal.style.display = 'none';
    });
    document.getElementById('show-register').addEventListener('click', showRegisterForm);
    document.getElementById('show-login').addEventListener('click', showLoginForm);

    // Form event listeners
    document.getElementById('login-form').addEventListener('submit', handleLogin);
    document.getElementById('register-form').addEventListener('submit', handleRegister);
    document.getElementById('contact-form').addEventListener('submit', handleContactForm);
    document.getElementById('checkout-form').addEventListener('submit', handleCheckout);

    // FAQ event listeners
    document.querySelectorAll('.faq-question').forEach(question => {
        question.addEventListener('click', function() {
            const faqItem = this.parentElement;
            faqItem.classList.toggle('active');
        });
    });

    // Load initial content
    loadFeaturedProducts();
    loadBestSellerProducts();
    loadPopularProducts();
    updateCartDisplay();
    updateCheckoutDisplay();

    const userLoginBtn = document.getElementById('user-login-btn');
    const authSwitch = document.querySelector('#login-form .auth-switch');
    userLoginBtn.addEventListener('click', () => {
        loginTypeSelection.style.display = 'none';
        loginForm.classList.remove('hidden');
        registerForm.classList.add('hidden');
        if(authSwitch) authSwitch.style.display = 'block'; // Show register switch for user
    });

    // Elements
    const userIconBtn = document.getElementById("user-icon-btn");

    // Function to update UI based on login status
    function updateLoginUI(isLoggedIn) {
        if (isLoggedIn) {
            if (loginBtn) loginBtn.style.display = "none";
            if (userIconBtn) userIconBtn.style.display = "inline-block";
        } else {
            if (loginBtn) loginBtn.style.display = "inline-block";
            if (userIconBtn) userIconBtn.style.display = "none";
        }
    }

    // Check login status via AJAX
    fetch('user_session_check.php', { credentials: 'include' })
        .then(response => response.text())
        .then(status => {
            updateLoginUI(status.trim() === "logged_in");
        });

    // Expose updateLoginUI for use after login
    window.updateLoginUI = updateLoginUI;
}

// Page navigation
function showPage(pageId) {
    // Hide all pages
    document.querySelectorAll('.page').forEach(page => {
        page.classList.remove('active');
    });

    // Show selected page
    document.getElementById(pageId).classList.add('active');

    // Update navigation
    document.querySelectorAll('.nav-link').forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href') === '#' + pageId) {
            link.classList.add('active');
        }
    });

    currentPage = pageId;

    // Update page-specific content
    if (pageId === 'cart') {
        updateCartDisplay();
    } else if (pageId === 'checkout') {
        updateCheckoutDisplay();
    } else if (pageId === 'wishlist') {
        updateWishlistDisplay();
    }
}

// Product loading functions
function loadFeaturedProducts() {
    const container = document.getElementById('featured-products');
    if (!container) return;

    container.innerHTML = featuredProducts.map(product => `
        <div class="product-card">
            <div class="product-image">
                <img src="${product.image}" alt="${product.name}">
                <button class="wishlist-btn${isInWishlist(product.id) ? ' in-wishlist' : ''}" onclick="toggleWishlist(${product.id})" title="Add to wishlist">
                    <i class="${isInWishlist(product.id) ? 'fas' : 'far'} fa-heart" style="color:${isInWishlist(product.id) ? '#e74c3c' : '#000'}"></i>
                </button>
            </div>
            <div class="product-info">
                <h3 class="product-name">${product.name}</h3>
                <p class="product-price">Rs ${product.price.toLocaleString()}/-</p>
                <button class="add-to-cart" onclick="addToCart(${product.id})">Add to Cart</button>
            </div>
        </div>
    `).join('');
}

function loadBestSellerProducts() {
    const container = document.getElementById('best-seller-products');
    if (!container) return;

    container.innerHTML = bestSellerProducts.map(product => `
        <div class="best-seller-item">
            <img src="${product.image}" alt="${product.name}">
            <h4>${product.name}</h4>
            <p class="price">Rs ${product.price.toLocaleString()}/-</p>
            <button class="wishlist-btn${isInWishlist(product.id) ? ' in-wishlist' : ''}" onclick="toggleWishlist(${product.id})" style="margin-top: 0.5rem;" title="Add to wishlist">
                <i class="${isInWishlist(product.id) ? 'fas' : 'far'} fa-heart" style="color:${isInWishlist(product.id) ? '#e74c3c' : '#000'}"></i>
            </button>
        </div>
    `).join('');
}

function loadPopularProducts() {
    const container = document.getElementById('popular-products');
    if (!container) return;

    container.innerHTML = `
        <div class="popular-grid">
            ${popularProducts.map(product => `
                <div class="popular-item">
                    <img src="${product.image}" alt="${product.name}">
                    <p>${product.name}</p>
                </div>
            `).join('')}
        </div>
    `;
}

// Cart functionality
function addToCart(productId) {
    if (!isUserLoggedIn()) {
        // Show login modal
        const authModal = document.getElementById('auth-modal');
        document.getElementById('login-type-selection').style.display = 'block';
        document.getElementById('login-form').classList.add('hidden');
        document.getElementById('register-form').classList.add('hidden');
        authModal.style.display = 'block';
        return;
    }
    const allProducts = [...featuredProducts, ...bestSellerProducts];
    const product = allProducts.find(p => p.id === productId);
    
    if (!product) return;

    const existingItem = cart.find(item => item.id === productId);
    
    if (existingItem) {
        existingItem.quantity += 1;
    } else {
        cart.push({
            id: product.id,
            name: product.name,
            price: product.price,
            image: product.image,
            quantity: 1
        });
    }

    updateCartCount();
    saveCartToStorage();
    
    // Show success message (optional)
    alert('Product added to cart!');
}

function removeFromCart(productId) {
    cart = cart.filter(item => item.id !== productId);
    updateCartCount();
    updateCartDisplay();
    updateCheckoutDisplay();
    saveCartToStorage();
}

function updateQuantity(productId, change) {
    const item = cart.find(item => item.id === productId);
    if (item) {
        item.quantity = Math.max(1, item.quantity + change);
        updateCartCount();
        updateCartDisplay();
        updateCheckoutDisplay();
        saveCartToStorage();
    }
}

function updateCartCount() {
    const count = cart.reduce((sum, item) => sum + item.quantity, 0);
    document.getElementById('cart-count').textContent = count;
}

function updateCartDisplay() {
    const container = document.getElementById('cart-items');
    if (!container) return;

    if (cart.length === 0) {
        container.innerHTML = '<div class="text-center p-4">Your cart is empty</div>';
        document.getElementById('cart-subtotal').textContent = 'Rs 0.00';
        document.getElementById('cart-total').textContent = 'Rs 0.00';
        return;
    }

    container.innerHTML = cart.map(item => `
        <div class="cart-item">
            <div class="cart-item-info">
                <img src="${item.image}" alt="${item.name}">
                <div class="cart-item-name">${item.name}</div>
            </div>
            <div class="cart-item-price">Rs ${item.price.toLocaleString()}.00</div>
            <div class="quantity-controls">
                <button class="quantity-btn" onclick="updateQuantity(${item.id}, -1)">
                    <i class="fas fa-minus"></i>
                </button>
                <span class="quantity-display">${item.quantity.toString().padStart(2, '0')}</span>
                <button class="quantity-btn" onclick="updateQuantity(${item.id}, 1)">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
            <div class="cart-item-total-remove" style="display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                <span class="cart-item-total">Rs ${(item.price * item.quantity).toLocaleString()}.00</span>
                <button class="remove-btn" onclick="removeFromCart(${item.id})" title="Remove from cart">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    `).join('');

    const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    document.getElementById('cart-subtotal').textContent = `Rs ${subtotal.toLocaleString()}.00`;
    document.getElementById('cart-total').textContent = `Rs ${subtotal.toLocaleString()}.00`;
}

function updateCheckoutDisplay() {
    const container = document.getElementById('checkout-items');
    if (!container) return;

    container.innerHTML = cart.map(item => `
        <div class="checkout-item">
            <img src="${item.image}" alt="${item.name}">
            <div class="checkout-item-info">
                <h3>${item.name}</h3>
                <p class="price">Rs ${item.price.toLocaleString()}.00</p>
            </div>
        </div>
    `).join('');

    const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    document.getElementById('checkout-subtotal').textContent = `Rs ${subtotal.toLocaleString()}.00`;
    document.getElementById('checkout-total').textContent = `Rs ${subtotal.toLocaleString()}.00`;
}

// Local storage functions
function saveCartToStorage() {
    localStorage.setItem('needore-cart', JSON.stringify(cart));
}

function loadCartFromStorage() {
    const savedCart = localStorage.getItem('needore-cart');
    if (savedCart) {
        cart = JSON.parse(savedCart);
    }
}

function saveWishlistToStorage() {
    localStorage.setItem('needore-wishlist', JSON.stringify(wishlist));
}

function loadWishlistFromStorage() {
    const saved = localStorage.getItem('needore-wishlist');
    if (saved) wishlist = JSON.parse(saved);
}

function isInWishlist(productId) {
    return wishlist.includes(productId);
}

function addToWishlist(productId) {
    if (!isUserLoggedIn()) {
        // Show login modal
        const authModal = document.getElementById('auth-modal');
        document.getElementById('login-type-selection').style.display = 'block';
        document.getElementById('login-form').classList.add('hidden');
        document.getElementById('register-form').classList.add('hidden');
        authModal.style.display = 'block';
        return;
    }
    if (!isInWishlist(productId)) {
        wishlist.push(productId);
        saveWishlistToStorage();
        alert('Product added to wishlist!');
        renderAllWishlists();
    }
}

function removeFromWishlist(productId) {
    wishlist = wishlist.filter(id => id !== productId);
    saveWishlistToStorage();
    alert('Product removed from wishlist!');
    renderAllWishlists();
}

function toggleWishlist(productId) {
    if (isInWishlist(productId)) {
        removeFromWishlist(productId);
    } else {
        addToWishlist(productId);
    }
}

function renderAllWishlists() {
    loadFeaturedProducts();
    loadBestSellerProducts();
    updateWishlistDisplay();
}

// Modal functions
function showAuthModal() {
    document.getElementById('auth-modal').classList.add('active');
}

function hideAuthModal() {
    document.getElementById('auth-modal').classList.remove('active');
}

function showRegisterForm() {
    document.getElementById('login-form').classList.add('hidden');
    document.getElementById('register-form').classList.remove('hidden');
    document.getElementById('modal-subtitle').textContent = 'Great to see you here!';
}

function showLoginForm() {
    document.getElementById('register-form').classList.add('hidden');
    document.getElementById('login-form').classList.remove('hidden');
    document.getElementById('modal-subtitle').textContent = 'Great to have you back!';
}

// Form handlers
function handleLogin(e) {
    e.preventDefault();
    const formData = new FormData(e.target);
    fetch('user_login.php', {
        method: 'POST',
        body: formData,
        credentials: 'include'
    })
    .then(response => response.text())
    .then(result => {
        if (result.trim() === 'success') {
            // Hide modal, update UI
            if (typeof window.updateLoginUI === 'function') {
                window.updateLoginUI(true);
            }
            // Optionally close modal
            const modal = document.getElementById('auth-modal');
            if (modal) modal.style.display = 'none';
        } else if (result.trim() === 'invalid') {
            alert('Invalid email or password.');
        } else {
            alert('Login failed. Please try again.');
        }
    });
}

function handleRegister(e) {
    e.preventDefault();
    alert('Registration functionality would be implemented here');
    hideAuthModal();
}

function handleContactForm(e) {
    e.preventDefault();
    alert('Thank you for your message! We will get back to you soon.');
    e.target.reset();
}

function handleCheckout(e) {
    e.preventDefault();
    alert('Order placed successfully! Thank you for shopping with NEEDORE.');
    cart = [];
    updateCartCount();
    updateCartDisplay();
    saveCartToStorage();
    showPage('home');
}

// Close modal when clicking outside
document.getElementById('auth-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        hideAuthModal();
    }
});

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        hideAuthModal();
    }
});

// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth'
            });
        }
    });
});

// Add loading states for better UX
function showLoading(element) {
    element.innerHTML = '<div class="text-center p-4"><i class="fas fa-spinner fa-spin"></i> Loading...</div>';
}

// Add error handling
window.addEventListener('error', function(e) {
    console.error('An error occurred:', e.error);
});

// Add resize handler for responsive behavior
window.addEventListener('resize', function() {
    // Handle any responsive adjustments if needed
});

// Initialize tooltips or other interactive elements
function initializeInteractiveElements() {
    // Add hover effects, tooltips, etc.
    document.querySelectorAll('.product-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-4px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
}

// Call initialization functions
document.addEventListener('DOMContentLoaded', function() {
    initializeInteractiveElements();
});

function showSubcategories(category) {
    const grid = document.getElementById('categories-grid');
    const subSection = document.getElementById('subcategories-section');
    const prodSection = document.getElementById('category-products-section');
    const subTitle = document.getElementById('subcategories-title');
    const subList = document.getElementById('subcategories-list');
    if (!subSection || !subTitle || !subList) return;
    subTitle.textContent = `Subcategories in ${category.name}`;
    subList.innerHTML = category.subcategories.map(sub => `
        <button class="subcategory-btn" data-subcategory="${sub.name}">${sub.name}</button>
    `).join('');
    subSection.style.display = '';
    if (grid) grid.style.display = 'none';
    if (prodSection) prodSection.style.display = 'none';
    // Add event listeners
    subList.querySelectorAll('.subcategory-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const subName = this.getAttribute('data-subcategory');
            const sub = category.subcategories.find(s => s.name === subName);
            if (sub) showSubcategoryProducts(category, sub);
        });
    });
    // Back to main categories
    const backBtn = document.getElementById('back-to-main-categories');
    if (backBtn) {
        backBtn.onclick = function() {
            renderCategories(categoriesData);
        };
    }
}
function renderCategories(data) {
    const grid = document.getElementById('categories-grid');
    const subSection = document.getElementById('subcategories-section');
    const prodSection = document.getElementById('category-products-section');
    if (!grid) return;
    grid.innerHTML = data.map(cat => `
        <div class="category-item" data-category="${cat.name}">
            <i class="${cat.icon}"></i>
            <span>${cat.name}</span>
        </div>
    `).join('');
    grid.style.display = '';
    if (subSection) subSection.style.display = 'none';
    if (prodSection) prodSection.style.display = 'none';
    // Add event listeners
    grid.querySelectorAll('.category-item').forEach(item => {
        item.addEventListener('click', function() {
            const catName = this.getAttribute('data-category');
            const cat = categoriesData.find(c => c.name === catName);
            if (cat) showSubcategories(cat);
        });
    });
}
function showSubcategoryProducts(category, subcategory) {
    const prodSection = document.getElementById('category-products-section');
    const subSection = document.getElementById('subcategories-section');
    const prodTitle = document.getElementById('category-products-title');
    const prodList = document.getElementById('category-products-list');
    if (!prodSection || !prodTitle || !prodList) return;
    prodTitle.textContent = `Products in ${subcategory.name}`;
    prodList.innerHTML = subcategory.products.map(product => `
        <div class="product-card">
            <div class="product-image">
                <img src="${product.image}" alt="${product.name}">
            </div>
            <div class="product-info">
                <h3 class="product-name">${product.name}</h3>
                <p class="product-price">Rs ${product.price.toLocaleString()}/-</p>
                <button class="add-to-cart" onclick="addToCart(${product.id}, '${subcategory.name}')">Add to Cart</button>
            </div>
        </div>
    `).join('');
    prodSection.style.display = '';
    if (subSection) subSection.style.display = 'none';
    // Back to subcategories
    const backBtn = document.getElementById('back-to-subcategories');
    if (backBtn) {
        backBtn.onclick = function() {
            showSubcategories(category);
        };
    }
}
function filterCategories(query) {
    if (!query) {
        renderCategories(categoriesData);
        return;
    }
    // Filter main categories and subcategories
    const filtered = categoriesData.filter(cat => {
        if (cat.name.toLowerCase().includes(query)) return true;
        if (cat.subcategories.some(sub => sub.name.toLowerCase().includes(query))) return true;
        return false;
    });
    renderCategories(filtered);
}

function updateWishlistDisplay() {
    const container = document.getElementById('wishlist-items');
    if (!container) return;
    if (wishlist.length === 0) {
        container.innerHTML = '<div class="text-center p-4">Your wishlist is empty</div>';
        return;
    }
    // Gather all products
    const allProducts = [...featuredProducts, ...bestSellerProducts];
    container.innerHTML = wishlist.map(id => {
        const product = allProducts.find(p => p.id === id);
        if (!product) return '';
        return `
            <div class="cart-item">
                <div class="cart-item-info">
                    <img src="${product.image}" alt="${product.name}">
                    <div class="cart-item-name">${product.name}</div>
                </div>
                <div class="cart-item-price">Rs ${product.price.toLocaleString()}.00</div>
                <div style="display: flex; align-items: center; gap: 0.5rem; justify-content: center;">
                    <button class="add-to-cart" onclick="addToCart(${product.id})">Add to Cart</button>
                    <button class="remove-btn" onclick="removeFromWishlist(${product.id})" title="Remove from wishlist">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
    }).join('');
}

// --- LOGIN STATE TRACKING (FAKE DEMO) ---
function isUserLoggedIn() {
    return localStorage.getItem('isLoggedIn') === 'true';
}
function setUserLoggedIn() {
    localStorage.setItem('isLoggedIn', 'true');
}
function setUserLoggedOut() {
    localStorage.setItem('isLoggedIn', 'false');
}

// --- INTERCEPT WISHLIST & CART BUTTONS ---
document.addEventListener('DOMContentLoaded', function() {
    const wishlistBtn = document.getElementById('wishlist-btn');
    const cartBtn = document.getElementById('cart-btn');
    const authModal = document.getElementById('auth-modal');

    function showLoginModal() {
        document.getElementById('login-type-selection').style.display = 'block';
        document.getElementById('login-form').classList.add('hidden');
        document.getElementById('register-form').classList.add('hidden');
        authModal.style.display = 'block';
    }

    if (wishlistBtn) {
        wishlistBtn.addEventListener('click', function(e) {
            if (!isUserLoggedIn()) {
                e.preventDefault();
                showLoginModal();
            } else {
                showPage('wishlist');
            }
        });
    }
    if (cartBtn) {
        cartBtn.addEventListener('click', function(e) {
            if (!isUserLoggedIn()) {
                e.preventDefault();
                showLoginModal();
            } else {
                showPage('cart');
            }
        });
    }
});

// --- INTERCEPT PRODUCT CARD BUTTONS (Add to Cart & Wishlist) ---
document.addEventListener('click', function(e) {
    // Add to Cart button
    if (e.target.classList.contains('add-to-cart') || (e.target.closest && e.target.closest('.add-to-cart'))) {
        if (!isUserLoggedIn()) {
            e.preventDefault();
            // Show login modal
            const authModal = document.getElementById('auth-modal');
            document.getElementById('login-type-selection').style.display = 'block';
            document.getElementById('login-form').classList.add('hidden');
            document.getElementById('register-form').classList.add('hidden');
            authModal.style.display = 'block';
            return false;
        }
    }
    // Wishlist button (product card)
    if (e.target.classList.contains('wishlist-btn') || (e.target.closest && e.target.closest('.wishlist-btn'))) {
        if (!isUserLoggedIn()) {
            e.preventDefault();
            // Show login modal
            const authModal = document.getElementById('auth-modal');
            document.getElementById('login-type-selection').style.display = 'block';
            document.getElementById('login-form').classList.add('hidden');
            document.getElementById('register-form').classList.add('hidden');
            authModal.style.display = 'block';
            return false;
        }
    }
}, true);
