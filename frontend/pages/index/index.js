// pages/index/index.js
var app = getApp();

Page({
  data: {
    activeKey: 0,
    categories: [],
    dishes: [],
    cart: {
      total: 0,
      items: []
    },
    overlay_show: false
  },

  onLoad: function (options) {
    app.promises.request({
      url: app.globalData.api.dishes.categories
    }).then((res) => {
      this.setData({categories: res.data.data})
      if (res.data.data.length != 0) {
        return app.promises.request({
          url: app.globalData.api.dishes.list + res.data.data[0].cat_id
        })
      }
      throw 'No category'
    }).then((ress) => {
      this.setData({dishes: ress.data.data})
    })
  },

  onReady: function () {

  },

  onShow: function () {
    this.updateCart()
    this.getTabBar().setData({active: 0})
  },

  updateCart: function () {
    this.setData({cart: app.globalData.cart})
  },

  categoryChange: function (e) {
    app.promises.request({
      url: app.globalData.api.dishes.list + this.data.categories[e.detail].cat_id
    }).then((res) => {
      this.setData({dishes: res.data.data})
    })
  },

  showCart: function () {
    this.setData({overlay_show: true})
  },

  overlayHide: function () {
    this.setData({overlay_show: false})
  },

  clearCart: function () {
    let cart = app.globalData.cart
    cart.total = 0
    cart.items = []
    app.globalData.cart = cart
    this.updateCart()
  },

  addToCart: function (e) {
    let cart = app.globalData.cart
    let dish_id = e.target.dataset.dish_id
    let cart_index = cart.items.findIndex(x => x.dish_id == dish_id)
    let dish = this.data.dishes.find(x => x.dish_id == dish_id)
    let price = dish.price - dish.discount
    if (cart_index == -1) {
      cart.items.push({
        dish_id: dish_id,
        count: 1,
        price: price,
        name: dish.name
      })
      cart.total += price
    }
    else {
      cart.items[cart_index].count += 1
      cart.total += price
    }
    app.globalData.cart = cart
    this.updateCart()
  },

  removeFromCart: function (e) {
    let cart = app.globalData.cart
    let dish_id = e.target.dataset.dish_id
    let cart_index = cart.items.findIndex(x => x.dish_id == dish_id)
    let dish = this.data.dishes.find(x => x.dish_id == dish_id)
    let price = dish.price - dish.discount
    if (cart.items[cart_index].count == 1)
      cart.items.splice(cart_index, 1)
    else
      cart.items[cart_index].count -= 1
    cart.total -= price
    app.globalData.cart = cart
    this.updateCart()
  },

  submitOrder: function () {
    if (app.globalData.cart.total == 0 && app.globalData.cart.items.length == 0) {
      wx.showModal({
        title: 'Empty cart',
        content: 'No dish in the cart',
        showCancel: false,
        confirmText: 'OK'
      })
      return;
    }

    if (!wx.getStorageSync('userInfo')) {
      wx.showModal({
        title: 'Not Login',
        content: 'You need to login before submit an order.',
        cancelText: 'No',
        confirmText: 'Yes',
        success: (res) => {
          if (res.confirm) {
            wx.navigateTo({
              url: '/pages/authorization/authorization'
            })
          }
        }
      })
    }
  
    else {
      wx.navigateTo({
        url: '/pages/submit_order/submit_order'
      })
    }
  }
})
