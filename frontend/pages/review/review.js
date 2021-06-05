// pages/review/review.js
var app = getApp();

Page({
  data: {
    reviews: [],
    active_collapse: []
  },

  onLoad: function (options) {
    app.promises.request({
      url: app.globalData.api.reviews.list,
      data: {
        user_id: app.globalData.userInfo.user_id
      }
    }).then((res) => {
      this.setData({reviews: res.data.data})
    })
  },

  onShow: function () {

  },

  collapseClick: function (e) {
    this.setData({active_collapse: e.detail})
  }
})