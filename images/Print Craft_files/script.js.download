
async function loadProducts() {
    try {
        const response = await fetch("api/products.php");
        const data = await response.json();

        const container = document.getElementById("products");

        if (!data.success) {
            container.innerHTML = "<p>Unable to load products.</p>";
            return;
        }

        container.innerHTML = "";

        data.products.forEach(product => {

            const card = document.createElement("div");

            card.className = "product-card";

            card.innerHTML = `
                <div class="product-image">
                    ${
                        product.image
                        ? `<img src="images/${product.image}" alt="${product.name}">`
                        : `<div class="no-image"><img src="images/t-shirt.jpg" ></div>`
                    }
                </div>

                <h3>${product.name}</h3>

                <p>${product.description}</p>

                <h4>₹${product.price}</h4>

                <p>Stock: ${product.stock}</p>

                <button onclick="addToCart(${product.id})">
                    Add to Cart
                </button>
            `;

            container.appendChild(card);
        });

    } catch (error) {
        console.error(error);

        document.getElementById("products").innerHTML =
            "<p>Server connection error.</p>";
    }
}


let cart = JSON.parse(localStorage.getItem("cart")) || [];


function addToCart(productId) {

    const existingProduct = cart.find(
        item => item.productId === productId
    );

    if (existingProduct) {
        existingProduct.quantity += 1;
    } else {
        cart.push({
            productId: productId,
            quantity: 1
        });
    }

    localStorage.setItem("cart", JSON.stringify(cart));

    alert("Product added to cart!");

    console.log(cart);
}
function displayCart() {

    const cartItems = document.getElementById("cart-items");
    const cartTotal = document.getElementById("cart-total");

    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    if (cart.length === 0) {

        cartItems.innerHTML = `
            <div class="empty-cart">
                <h3>Your cart is empty</h3>
                <a href="index.html">Continue Shopping</a>
            </div>
        `;

        cartTotal.innerText = "0.00";

        return;
    }


    cartItems.innerHTML = "";

    let total = 0;


    cart.forEach((item, index) => {

        /*
         * Temporary product information.
         * Later we will get this directly from MySQL.
         */

        let productName = "";
        let price = 0;

        if (item.productId == 1) {
            productName = "Custom T-Shirt";
            price = 499;
        }

        else if (item.productId == 2) {
            productName = "Custom Hoodie";
            price = 999;
        }

        else if (item.productId == 3) {
            productName = "Custom Sweatshirt";
            price = 799;
        }


        let itemTotal = price * item.quantity;

        total += itemTotal;


        cartItems.innerHTML += `

            <div class="cart-item">

                <div>
                    <h3>${productName}</h3>

                    <p>Price: ₹${price}</p>

                    <p>
                        Quantity:
                        <button onclick="changeQuantity(${index}, -1)">
                            -
                        </button>

                        <span>${item.quantity}</span>

                        <button onclick="changeQuantity(${index}, 1)">
                            +
                        </button>
                    </p>

                    <p>
                        Subtotal: ₹${itemTotal}
                    </p>

                    <button onclick="removeFromCart(${index})">
                        Remove
                    </button>

                </div>

            </div>

        `;
    });


    cartTotal.innerText = total.toFixed(2);
}
function changeQuantity(index, change) {

    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    cart[index].quantity += change;


    if (cart[index].quantity <= 0) {
        cart.splice(index, 1);
    }


    localStorage.setItem("cart", JSON.stringify(cart));

    displayCart();
}
function removeFromCart(index) {

    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    cart.splice(index, 1);

    localStorage.setItem("cart", JSON.stringify(cart));

    displayCart();
}
function checkout() {

    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    if (cart.length === 0) {

        alert("Your cart is empty!");

        return;
    }

    window.location.href = "checkout.html";
}
function displayCheckoutTotal() {

    const cart = JSON.parse(localStorage.getItem("cart")) || [];

    let total = 0;

    cart.forEach(item => {

        if (item.productId == 1) {
            total += 499 * item.quantity;
        }

        else if (item.productId == 2) {
            total += 999 * item.quantity;
        }

        else if (item.productId == 3) {
            total += 799 * item.quantity;
        }

    });

    const totalElement = document.getElementById("checkout-total");

    if (totalElement) {
        totalElement.innerText = total.toFixed(2);
    }
}


displayCheckoutTotal();
const checkoutForm = document.getElementById("checkout-form");

if (checkoutForm) {

    checkoutForm.addEventListener("submit", async function(event) {

        event.preventDefault();


        const cart = JSON.parse(localStorage.getItem("cart")) || [];

        if (cart.length === 0) {

            alert("Your cart is empty!");

            return;
        }


        let total = 0;


        cart.forEach(item => {

            if (item.productId == 1) {
                total += 499 * item.quantity;
            }

            else if (item.productId == 2) {
                total += 999 * item.quantity;
            }

            else if (item.productId == 3) {
                total += 799 * item.quantity;
            }

        });


        const orderData = {

            name: document.getElementById("name").value,

            email: document.getElementById("email").value,

            phone: document.getElementById("phone").value,

            address: document.getElementById("address").value,

            total: total

        };


        try {

            const response = await fetch("api/orders.php", {

                method: "POST",

                headers: {
                    "Content-Type": "application/json"
                },

                body: JSON.stringify(orderData)

            });


            const result = await response.json();


            if (result.success) {

                alert(
                    "Order placed successfully!\n" +
                    "Order ID: " + result.order_id
                );


                // Empty cart
                localStorage.removeItem("cart");


                // Go to home
                window.location.href = "index.html";

            } else {

                alert(result.message);

            }


        } catch (error) {

            console.error(error);

            alert("Server connection error.");

        }

    });
}
const registerForm =
    document.getElementById("register-form");


if (registerForm) {

    registerForm.addEventListener(
        "submit",
        async function(event) {

            event.preventDefault();


            const name =
                document.getElementById(
                    "register-name"
                ).value.trim();


            const email =
                document.getElementById(
                    "register-email"
                ).value.trim();


            const phone =
                document.getElementById(
                    "register-phone"
                ).value.trim();


            const password =
                document.getElementById(
                    "register-password"
                ).value;


            const confirmPassword =
                document.getElementById(
                    "register-confirm-password"
                ).value;


            if (password !== confirmPassword) {

                alert("Passwords do not match!");

                return;
            }


            try {

                const response = await fetch(
                    "api/register.php",
                    {
                        method: "POST",

                        headers: {
                            "Content-Type":
                                "application/json"
                        },

                        body: JSON.stringify({

                            name: name,
                            email: email,
                            phone: phone,
                            password: password

                        })
                    }
                );


                const result =
                    await response.json();


                if (result.success) {

                    alert(
                        "Account created successfully!"
                    );

                    window.location.href =
                        "login.html";

                } else {

                    alert(result.message);

                }


            } catch (error) {

                console.error(error);

                alert(
                    "Server connection error."
                );
            }

        }
    );
}