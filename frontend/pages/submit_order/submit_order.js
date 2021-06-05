// pages/submit_order/submit_order.js
var app = getApp();

Page({
  data: {
    cart: {
      total: 0,
      items: []
    },
    remark: '',
    dine_way: '1',
    use_credits: false,
    credit: 0,
    password: '',
    overlay_show: false,
    pay_info: null
  },

  onLoad: function () {
    
  },

  onShow: function () {
    this.setData({cart: app.globalData.cart})
  },

  changeDineWay: function (e) {
    this.setData({dine_way: e.detail})
  },

  useCredits: function () {
    if (this.data.use_credits) {
      this.setData({
        use_credits: false,
        credit: 0
      })
    }

    else {
      this.setData({use_credits: true})
      let user = app.globalData.userInfo
      let user_id = user.user_id
      wx:wx.showLoading({
        title: 'Checking',
        mask: true
      })
      app.promises.request({
        url: app.globalData.api.user.credits,
        data: {user_id: user_id}
      }).then((res) => {
        let credit = res.data.data.credit
        wx:wx.hideLoading();
        if (credit < 50) {
          wx.showModal({
            title: 'Credit not enough',
            content: 'Your credit is less than 50 (' + credit.toString() + ' credits left.',
            showCancel: false,
            confirmText: 'OK',
            complete: () => {
              this.setData({
                use_credits: false,
                credit: 0
              })
            }
          })
        }
        else {
          this.setData({credit: 50})
        }
      })
    }
  },

  onSubmit: function () {
    wx.showLoading({title: 'Preparing...'})
    
    app.promises.request({
      url: app.globalData.api.orders.submit,
      data: {
        user_id: app.globalData.userInfo.user_id,
        total: this.data.cart.total - this.data.credit / 10,
        credit: this.data.credit,
        remark: this.data.remark,
        dine_way: this.data.dine_way,
        dishes: this.data.cart.items
      },
      method: 'POST'
    }).then((res) => {
      this.setData({pay_info: res.data.data})
      wx.hideLoading()
      this.setData({overlay_show: true})
    })
  },

  cancelPay: function () {
    wx.showModal({
      title: 'Cancel',
      content: 'Are you sure to cancel this order?',
      confirmText: 'Yes',
      cancelText: 'No',
      success: (res) => {
        if (res.confirm) {
          app.promises.request({
            url: app.globalData.api.orders.cancel,
            data: {
              user_id: app.globalData.userInfo.user_id,
              order_id: this.data.pay_info.order_id,
            },
            method: 'POST'
          }).then(() => { wx.navigateBack() })
        }
      }
    })
  },

  onPay: function () {
    let pay_info = this.data.pay_info
    app.promises.request({
      url: app.globalData.api.orders.pay,
      data: {
        user_id: app.globalData.userInfo.user_id,
        timeStamp: pay_info.timeStamp,
        nonceStr: pay_info.nonceStr,
        package: pay_info.package,
        signType: pay_info.signType,
        paySign: pay_info.paySign,
        order_id: pay_info.order_id
      },
      method: 'POST'
    }).then((res) => {
      app.resetCart()
      wx.showModal({
        title: 'Finish',
        content: 'Please wait for your dishes',
        showCancel: false,
        confirmText: 'OK',
        complete: () => {
          wx.navigateTo({
            url: '/pages/order_detail/order_detail?order_id=' + pay_info.order_id,
          })
        }
      })
    })
  }
})