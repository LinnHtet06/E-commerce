const plus = document.querySelectorAll(".increment-btn");
const minus = document.querySelectorAll(".decrement-btn");
const qty = document.querySelector(".qty");
const buy = document.querySelector(".add-to-bag-btn");
const wishList = document.querySelector(".wish");
const removeItems = document.querySelectorAll(".removeItem");
const removeWishList = document.querySelectorAll(".removeWishList");
const cart = document.querySelector("#myCart");
const wish = document.querySelector("#wish");
const placeOrderBtn = document.querySelector(".placeOrder-btn");
const priceBtn = document.querySelector(".priceBtn");

// const productData = buy.closest(".product_data");
// const prod_id = buy.value;

plus.forEach((button) => {
  button.addEventListener("click", (e) => {
    e.preventDefault();
    const qtyInput = e.target.closest(".input-group").querySelector(".qty");
    let value = parseInt(qtyInput.value, 10);
    if (isNaN(value)) {
      value = 0;
    }

    if (value < 100) {
      value++;
      qtyInput.value = value;
    }
  });
});
minus.forEach((button) => {
  button.addEventListener("click", (e) => {
    e.preventDefault();
    const qtyInput = e.target.closest(".input-group").querySelector(".qty");
    let value = parseInt(qtyInput.value, 10);
    if (isNaN(value)) {
      value = 0;
    }
    if (value > 1) {
      value--;
      qtyInput.value = value;
    }
  });
});

document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".removeWishList").forEach((button) => {
    button.addEventListener("click", async (e) => {
      e.preventDefault();

      const wID = e.target.value;

      const wishlistItem = e.target.closest(".wishlist-item");
      if (wishlistItem) {
        wishlistItem.style.opacity = 0.5; // Indicate removal in progress
      }

      try {
        const response = await fetch("functions/wishList.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            wID: wID,
            scope: "delete",
          }),
        });

        const result = await response.json();
        console.log(result);

        if (result.status == 201) {
          alertify.success("Product deleted from wishlist");
          if (wishlistItem) {
            wishlistItem.remove();
          }
        } else if (result.status == 404) {
          alertify.error("Wish item not found");
          if (wishlistItem) {
            wishlistItem.style.opacity = 1; // Revert if error
          }
        } else if (result.status == 500) {
          alertify.error("Something went wrong");
          if (wishlistItem) {
            wishlistItem.style.opacity = 1; // Revert if error
          }
        } else {
          alertify.error("Unexpected error");
          if (wishlistItem) {
            wishlistItem.style.opacity = 1; // Revert if error
          }
        }
      } catch (error) {
        console.error("Error:", error);
        alertify.error("Failed to remove product from wishlist");
        if (wishlistItem) {
          wishlistItem.style.opacity = 1; // Revert if error
        }
      }
    });
  });
});

// removeWishList.forEach((button) => {
//   button.addEventListener("click", async (e) => {
//     e.preventDefault();
//     const wID = e.target.value;

//     try {
//       const response = await fetch("functions/wishList.php", {
//         method: "POST",
//         headers: {
//           "Content-Type": "application/json",
//         },
//         body: JSON.stringify({
//           wID: wID,
//           scope: "delete",
//         }),
//       });

//       const responseText = await response.text(); // Get the response text
//       console.log(responseText); // Log the response text

//       // Try to parse the response as JSON
//       const result = JSON.parse(responseText);
//       console.log(result);

//       if (result.status == 201) {
//         alertify.success("Product deleted from wishList");
//         $("#wish").load(location.href + "#wish");
//       } else if (result.status == 500) {
//         alertify.error("Something went wrong");
//       } else {
//         alertify.error("Unexpected error");
//       }
//     } catch (error) {
//       console.error("Error:", error);
//       alertify.error("Failed to add product to wishList");
//     }
//   });
// });

document.addEventListener("DOMContentLoaded", function () {
  async function updateCart() {
    try {
      // Fetch updated cart data
      const response = await fetch("functions/handleCart.php"); // Adjust the URL to your getCart.php
      const cartHtml = await response.text(); // Get the updated cart HTML

      // Update off-canvas with new cart data
      document.querySelector("#myCart").innerHTML = cartHtml;
    } catch (error) {
      console.error("Failed to fetch cart:", error);
    }
  }
  document.querySelectorAll(".add-to-bag-btn").forEach((button) => {
    button.addEventListener("click", async (e) => {
      e.preventDefault();

      const productData = e.target.closest(".product_data");
      const prod_id = productData.querySelector(".add-to-bag-btn").value;
      const qty = productData.querySelector(".qty").value;

      // const cart = e.target.closest(".col-md-8").next(".offcanvas-body");
      // if (cart) {
      //   cart.style.opacity = 0.5; // Indicate removal in progress
      // }

      try {
        const response = await fetch("functions/handleCart.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            prod_id: prod_id,
            prod_qty: qty,
            scope: "add",
          }),
        });

        const responseText = await response.text(); // Get the response text
        console.log(responseText); // Log the response text

        // Try to parse the response as JSON
        const result = JSON.parse(responseText);
        console.log(result);

        if (result.status == 201) {
          alertify.success("Product added to cart");
          // await updateCart();
          // Show the off-canvas
          const offcanvas = new bootstrap.Offcanvas(
            document.querySelector("#offcanvasRight")
          );
          offcanvas.show(); // Show the off-canvas if not already visible
        } else if (result.status == "alreadyexisting") {
          alertify.success("Product already added in cart");
        } else if (result.status == 401) {
          alertify.success("Login to continue");
        } else if (result.status == 500) {
          alertify.error("Something went wrong");
        } else {
          alertify.error("Unexpected error");
        }
      } catch (error) {
        console.error(error);
        alertify.error("Failed to add product to cart");
      }
    });
  });
});
// buy.addEventListener("click", async (e) => {
//   e.preventDefault();

//   const productData = e.target.closest(".product_data");
//   const prod_id = productData.querySelector(".add-to-bag-btn").value;
//   const qty = productData.querySelector(".qty").value;

//   try {
//     const response = await fetch("functions/handleCart.php", {
//       method: "POST",
//       headers: {
//         "Content-Type": "application/json",
//       },
//       body: JSON.stringify({
//         prod_id: prod_id,
//         prod_qty: qty,
//         scope: "add",
//       }),
//     });

//     const responseText = await response.text(); // Get the response text
//     console.log(responseText); // Log the response text

//     // Try to parse the response as JSON
//     const result = JSON.parse(responseText);
//     console.log(result);

//     if (result.status == 201) {
//       alertify.success("Product added to cart");
//       document.querySelector(".container").addEventListener("load", (e) => {
//         location.href += "#.container"; // Update the location directly
//       });
//     } else if (result.status == "alreadyexisting") {
//       alertify.success("Product already added in cart");
//     } else if (result.status == 401) {
//       alertify.success("Login to continue");
//     } else if (result.status == 500) {
//       alertify.error("Something went wrong");
//     } else {
//       alertify.error("Unexpected error");
//     }
//   } catch (error) {
//     console.error(error);
//     alertify.error("Failed to add product to cart");
//   }
// });
document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".updateQuantity").forEach((button) => {
    button.addEventListener("click", async (e) => {
      const productData = e.target.closest(".cartItem");
      const prod_id = productData.getAttribute("id");
      const qty = productData.querySelector(".cartQty").value;
      try {
        const response = await fetch("functions/handleCart.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            prod_id: prod_id,
            prod_qty: qty,
            scope: "update",
          }),
        });

        const responseText = await response.text(); // Get the response text
        console.log(responseText); // Log the response text

        // Try to parse the response as JSON
        const result = JSON.parse(responseText);
        console.log(result);

        if (result.status == 200) {
        } else if (result.status == 500) {
          alertify.error("Something went wrong");
        } else {
          alertify.error("Unexpected error");
        }
      } catch (error) {
        console.error(error);
        alertify.error("Failed to add product to cart");
      }
    });
  });
});

wishList.addEventListener("click", async (e) => {
  e.preventDefault();

  const productData = e.target.closest(".product_data");
  const prod_id = productData.querySelector(".wish").value;

  try {
    const response = await fetch("functions/wishList.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        prod_id: prod_id,
        scope: "add",
      }),
    });

    const responseText = await response.text(); // Get the response text
    console.log(responseText); // Log the response text

    // Try to parse the response as JSON
    const result = JSON.parse(responseText);
    console.log(result);

    if (result.status == 201) {
      alertify.success("Product added to wishList");
    } else if (result.status == "alreadyexisting") {
      alertify.success("Product already added in wishList");
    } else if (result.status == 401) {
      alertify.success("Login to continue");
    } else if (result.status == 500) {
      alertify.error("Something went wrong");
    } else {
      alertify.error("Unexpected error");
    }
  } catch (error) {
    console.error("Error:", error);
    alertify.error("Failed to add product to wishList");
  }
});
// removeItems.forEach((button) => {
//   button.addEventListener("click", async (e) => {
//     e.preventDefault();
//     const cartId = e.target.value;
//     try {
//       const response = await fetch("functions/handleCart.php", {
//         method: "POST",
//         headers: {
//           "Content-Type": "application/json",
//         },
//         body: JSON.stringify({
//           cartId: cartId,
//           scope: "delete",
//         }),
//       });

//       const responseText = await response.text(); // Get the response text
//       console.log(responseText); // Log the response text

//       // Try to parse the response as JSON
//       const result = JSON.parse(responseText);
//       console.log(result);

//       if (result.status == 201) {
//         alertify.success("Product deleted from cart");
//         cart.addEventListener("DOMContentLoaded", (e) => {
//           location.href += "#myCart";
//         });
//       } else if (result.status == 500) {
//         alertify.error("Something went wrong");
//       } else {
//         alertify.error("Unexpected error");
//       }
//     } catch (error) {
//       console.error("Error:", error);
//       alertify.error("Failed to add product to cart");
//     }
//   });
// });
document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".removeItem").forEach((button) => {
    button.addEventListener("click", async (e) => {
      e.preventDefault();

      const cartId = e.target.value;

      const cartItem = e.target.closest(".cartItem");
      if (cartItem) {
        cartItem.style.opacity = 0.5; // Indicate removal in progress
      }

      try {
        const response = await fetch("functions/handleCart.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            cartId: cartId,
            scope: "delete",
          }),
        });

        const responseText = await response.text(); // Get the response text
        console.log(responseText); // Log the response text

        // Try to parse the response as JSON
        const result = JSON.parse(responseText);
        console.log(result);

        if (result.status == 201) {
          alertify.success("Product deleted from cart");
          if (cartItem) {
            cartItem.remove();
          }
        } else if (result.status == 500) {
          alertify.error("Something went wrong");
          if (cartItem) {
            cartItem.style.opacity = 1; // Revert if error
          }
        } else {
          alertify.error("Unexpected error");
          if (cartItem) {
            cartItem.style.opacity = 1; // Revert if error
          }
        }
      } catch (error) {
        console.error("Error:", error);
        alertify.error("Failed to add product to cart");
        if (cartItem) {
          cartItem.style.opacity = 1; // Revert if error
        }
      }
    });
  });
});
