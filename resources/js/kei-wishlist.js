import '../css/custom.css'
require('noty/src/noty.scss')
require('noty/src/themes/mint.scss')
window.Noty = require('noty')
window.axios = require('axios')

const URL = 'https://wishlikist.test'

const addWishlist = (customer, product_id) => {
  axios
    .post(URL + '/api/addToWishlist', {
      shop_id: Shopify.shop,
      customer_id: customer,
      product_id: product_id
    })
    .then((response) => {
      console.log(response)
    })
    .catch((error) => {
      console.log(error)
    })
  //   new Noty({
  //     type: 'success',
  //     layout: 'topRight',
  //     timeout: 3000,
  //     text: 'Added to wishlist'
  //   }).show()
}

const removeWishlist = () => {
  new Noty({
    type: 'warning',
    layout: 'topRight',
    timeout: 3000,
    text: 'Removed from wishlist'
  }).show()
}

const wishlistButton = document.querySelector('.kei-wishlist-button')

wishlistButton.addEventListener('click', () => {
  if (wishlistButton.classList.contains('active')) {
    wishlistButton.classList.remove('active')
    removeWishlist()
  } else {
    wishlistButton.classList.add('active')
    addWishlist(wishlistButton.dataset.customer, wishlistButton.dataset.product)
  }
})
