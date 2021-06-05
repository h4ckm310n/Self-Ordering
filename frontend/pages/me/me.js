// pages/me/me.js

var app = getApp();

Page({
  data: {
    login: false,
    nickname: null,
    avatar: null,
    credit: 0,
    cells: [
      {title: 'Orders', url: '/pages/order/order', icon: 'orders-o'},
      {title: 'Reviews', url: '/pages/review/review', icon: 'comment-o'}
    ]
  },

  onLoad: function (options) {
    
  },

  onShow: function () {
    let userInfo = wx.getStorageSync('userInfo')

    if (!userInfo) {
      this.setData({login: false})
    }

    else {
      app.promises.request({
        url: app.globalData.api.user.credits,
        data: {
          user_id: app.globalData.userInfo.user_id
        }
      }).then((res) => {
        this.setData({
          login: true,
          nickname: userInfo.nickname,
          avatar: userInfo.avatar,
          credit: res.data.data.credit
        })
      })
    }
    this.getTabBar().setData({active: 1})
  },

  onLogin: function () {
    wx.navigateTo({
      url: '/pages/authorization/authorization',
    })
  }
})