import '../css/custom.css'
require('noty/src/noty.scss')
require('noty/src/themes/mint.scss')
window.Noty = require('noty')
window.axios = require('axios')

const URL = 'https://wishlikist.test'

const wishlistButton = document.querySelector('.kei-wishlist-button')

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

const removeWishlist = (customer, product_id) => {
  axios
    .post(URL + '/api/removeWishlist', {
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
  //     type: 'warning',
  //     layout: 'topRight',
  //     timeout: 3000,
  //     text: 'Removed from wishlist'
  //   }).show()
}

const checkWishlist = (customer, product_id) => {
  axios
    .post(URL + '/api/checkWishlist', {
      shop_id: Shopify.shop,
      customer_id: customer,
      product_id: product_id
    })
    .then((response) => {
      if (response.data == 1) {
        wishlistButton.classList.add('active')
      }
    })
    .catch((error) => {
      console.log(error)
    })
}

if (meta.page.pageType === 'product') {
  wishlistButton.addEventListener('click', () => {
    const customer = wishlistButton.dataset.customer
    const id = wishlistButton.dataset.product
    if (wishlistButton.classList.contains('active')) {
      wishlistButton.classList.remove('active')
      removeWishlist(customer, id)
    } else {
      wishlistButton.classList.add('active')
      addWishlist(customer, id)
    }
  })
}

if (wishlistButton) {
  const customer = wishlistButton.dataset.customer
  const id = wishlistButton.dataset.product
  checkWishlist(customer, id)
}
