//app.js

App({
  onLaunch: function () {
    let userInfo = wx.getStorageSync('userInfo')
    this.globalData.userInfo = userInfo
    if (userInfo.user_id) {
      this.promises.checkSession()
      .then(() => {return this.promises.login()})
      .then((res) => {
        return this.promises.request({
          url: this.globalData.api.user.login,
          data: {
            code: res.code,
            nickname: userInfo.nickname,
            avatar: userInfo.avatar
          },
          method: "POST"
        })
      }).then((ress) => {
        let userInfo_new = {user_id: ress.data.data.user_id, skey: ress.data.data.skey, nickname: userInfo.nickname, avatar: userInfo.avatar}
        wx.setStorageSync('userInfo', userInfo_new)
        this.globalData.userInfo = userInfo_new
      }).catch((err) => {
        console.log(err)
        wx.removeStorageSync('userInfo')
        this.globalData.userInfo = null
        wx.showToast({
          title: 'Failed to login',
        })
      })
    }
  },

  promises: require('utils/promises.js'),

  resetCart: function () {
    this.globalData.cart = {
      total: 0,
      items: []
    }
  },

  globalData: {
    userInfo: null,
    api: {
      user: {
        detail: 'http://cs003.h4ckm310n.com/user/detail',
        login: 'http://cs003.h4ckm310n.com/user/login',
        credits: 'http://cs003.h4ckm310n.com/user/credits'
      },
      dishes: {
        categories: 'http://cs003.h4ckm310n.com/dishes/categories',
        list: 'http://cs003.h4ckm310n.com/dishes/category/'
      },
      orders: {
        list: 'http://cs003.h4ckm310n.com/orders/',
        submit: 'http://cs003.h4ckm310n.com/orders/submit',
        pay: 'http://cs003.h4ckm310n.com/orders/pay',
        cancel: 'http://cs003.h4ckm310n.com/orders/cancel',
        detail: 'http://cs003.h4ckm310n.com/orders/detail/'
      },
      reviews: {
        list: 'http://cs003.h4ckm310n.com/reviews/',
        exist: 'http://cs003.h4ckm310n.com/reviews/exist/',
        detail: 'http://cs003.h4ckm310n.com/reviews/detail/',
        submit: 'http://cs003.h4ckm310n.com/reviews/submit'
      }
    }, 
    cart: {
      total: 0,
      items: []
    }
  }
})
