// Shop interactions: quantity buttons, cart and wishlist.
// Every element is looked up safely, so this file runs without errors on any page.

document.addEventListener("DOMContentLoaded", () => {
  const notify = (type, message) => {
    if (window.alertify) {
      alertify.set("notifier", "position", "top-right");
      alertify[type](message);
    } else {
      alert(message);
    }
  };

  // POST JSON to a PHP endpoint and return its JSON answer.
  async function postJSON(url, body) {
    const response = await fetch(url, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(body),
    });
    return response.json();
  }

  const isSuccess = (status) => status === 200 || status === 201;

  // Recalculate line totals and the cart total in the slide-out cart.
  function recalcCart() {
    const items = document.querySelectorAll(".cartItem");
    let total = 0;
    items.forEach((item) => {
      const price = parseFloat(item.dataset.price);
      const qty = parseInt(item.querySelector(".qty").value, 10) || 0;
      const line = price * qty;
      total += line;
      const lineEl = item.querySelector(".lineTotal");
      if (lineEl) lineEl.textContent = line.toFixed(2);
    });
    const totalEl = document.querySelector("#cartTotal");
    if (totalEl) totalEl.textContent = total.toFixed(2);
    document.querySelector("#cartEmpty")?.classList.toggle("d-none", items.length > 0);
    document.querySelector("#cartCheckout")?.classList.toggle("d-none", items.length === 0);
  }

  // + / - buttons (product page and cart).
  document.querySelectorAll(".increment-btn, .decrement-btn").forEach((button) => {
    button.addEventListener("click", async (e) => {
      e.preventDefault();
      const input = button.closest(".input-group").querySelector(".qty");
      const current = parseInt(input.value, 10) || 1;
      const max = parseInt(input.dataset.max || "100", 10);
      const next = button.classList.contains("increment-btn")
        ? Math.min(current + 1, max)
        : Math.max(current - 1, 1);
      if (next === current) {
        if (button.classList.contains("increment-btn")) notify("warning", `Only ${max} in stock`);
        return;
      }
      input.value = next;

      // Inside the cart, save the new quantity straight away.
      const cartItem = button.closest(".cartItem");
      if (!cartItem) return;
      try {
        const result = await postJSON("functions/handleCart.php", {
          scope: "update",
          cartId: cartItem.dataset.cartId,
          prod_qty: next,
        });
        if (isSuccess(result.status)) {
          recalcCart();
        } else {
          input.value = current;
          notify("error", result.message || "Could not update quantity");
        }
      } catch (error) {
        console.error(error);
        input.value = current;
        notify("error", "Could not update quantity");
      }
    });
  });

  // Add to cart (product page).
  document.querySelectorAll(".add-to-bag-btn").forEach((button) => {
    button.addEventListener("click", async (e) => {
      e.preventDefault();
      const qty = button.closest(".product_data").querySelector(".qty").value;
      try {
        const result = await postJSON("functions/handleCart.php", {
          scope: "add",
          prod_id: button.value,
          prod_qty: qty,
        });
        if (isSuccess(result.status)) {
          // Reload so the cart shows the new item, then open it.
          window.location.hash = "cart";
          window.location.reload();
        } else if (result.status === "alreadyexisting") {
          notify("message", "This product is already in your cart");
        } else if (result.status === 401) {
          notify("error", "Please log in to add items to your cart");
        } else {
          notify("error", result.message || "Something went wrong");
        }
      } catch (error) {
        console.error(error);
        notify("error", "Failed to add product to cart");
      }
    });
  });

  // Open the cart after "add to cart" reloaded the page.
  const cartPanel = document.querySelector("#offcanvasRight");
  if (window.location.hash === "#cart") {
    history.replaceState(null, "", window.location.pathname + window.location.search);
    if (cartPanel && window.bootstrap) {
      bootstrap.Offcanvas.getOrCreateInstance(cartPanel).show();
      notify("success", "Product added to cart");
    }
  }

  // Remove from cart.
  document.querySelectorAll(".removeItem").forEach((button) => {
    button.addEventListener("click", async (e) => {
      e.preventDefault();
      const cartItem = button.closest(".cartItem");
      cartItem.style.opacity = 0.5;
      try {
        const result = await postJSON("functions/handleCart.php", { scope: "delete", cartId: button.value });
        if (isSuccess(result.status)) {
          cartItem.remove();
          recalcCart();
          notify("success", "Product removed from cart");
        } else {
          cartItem.style.opacity = 1;
          notify("error", result.message || "Something went wrong");
        }
      } catch (error) {
        console.error(error);
        cartItem.style.opacity = 1;
        notify("error", "Failed to remove product from cart");
      }
    });
  });

  // Add to wishlist (product page).
  document.querySelectorAll(".wish").forEach((button) => {
    button.addEventListener("click", async (e) => {
      e.preventDefault();
      try {
        const result = await postJSON("functions/wishList.php", { scope: "add", prod_id: button.value });
        if (isSuccess(result.status)) {
          notify("success", "Product added to wishlist");
        } else if (result.status === "alreadyexisting") {
          notify("message", "Already in your wishlist");
        } else if (result.status === 401) {
          notify("error", "Please log in to use your wishlist");
        } else {
          notify("error", result.message || "Something went wrong");
        }
      } catch (error) {
        console.error(error);
        notify("error", "Failed to add product to wishlist");
      }
    });
  });

  // Remove from wishlist (wishlist page).
  document.querySelectorAll(".removeWishList").forEach((button) => {
    button.addEventListener("click", async (e) => {
      e.preventDefault();
      const wishlistItem = button.closest(".wishlist-item");
      wishlistItem.style.opacity = 0.5;
      try {
        const result = await postJSON("functions/wishList.php", { scope: "delete", wID: button.value });
        if (isSuccess(result.status)) {
          wishlistItem.remove();
          notify("success", "Product removed from wishlist");
          if (!document.querySelector(".wishlist-item")) {
            document.querySelector("#wishEmpty")?.classList.remove("d-none");
          }
        } else {
          wishlistItem.style.opacity = 1;
          notify("error", result.message || "Something went wrong");
        }
      } catch (error) {
        console.error(error);
        wishlistItem.style.opacity = 1;
        notify("error", "Failed to remove product from wishlist");
      }
    });
  });
});
