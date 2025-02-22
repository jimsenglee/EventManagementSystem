function addToCart(item) {
  // Add the item to the cart
  cart.push(item);

  // Update the cart total
  var total = 0;
  for (var i = 0; i < cart.length; i++) {
    total += cart[i].price;
  }
  document.getElementById('cart-total').innerHTML = total.toFixed(2);

  // Add the item to the table
  var tableRow = '<tr><td>' + item.name + '</td><td>' + item.price.toFixed(2) + '</td></tr>';
  document.getElementById('cart-items').innerHTML += tableRow;
}
