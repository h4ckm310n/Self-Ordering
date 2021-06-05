// pages/authorization/authorization.js

var app = getApp();

Page({
  data: {

  },

  onLoad: function (options) {

  },

  onShow: function () {

  },

  onGetUserInfo: function (e) {
    if (!e.detail.userInfo) {
      wx.showToast({
        title: 'Failed to login',
      })
      return
    }

    let nickname = e.detail.userInfo.nickName
    let avatar = e.detail.userInfo.avatarUrl

    app.promises.login()
    .then((res) => {
      return app.promises.request({
        url: app.globalData.api.user.login,
        data: {
          code: res.code,
          nickname: nickname,
          avatar: avatar
        },
        method: "POST",
      })
    }).then((ress) => {
      let userInfo = {user_id: ress.data.data.user_id, skey: ress.data.data.skey, nickname: nickname, avatar: avatar}
      wx.setStorageSync('userInfo', userInfo)
      app.globalData.userInfo = userInfo
      wx.navigateBack()
    })
  }
})