// pages/order/order.js
var app = getApp();

Page({
  data: {
    orders: [],
    status: ['Unpaid', 'Paid', 'Cancelled'],
    review: {
      order_id: '',
      star: 0,
      content: ''
    },
    submit_show: false,
    review_show: false
  },

  onLoad: function (options) {
    app.promises.request({
      url: app.globalData.api.orders.list,
      data: {
        user_id: app.globalData.userInfo.user_id
      }
    }).then((res) => {
      this.setData({orders: res.data.data})
    })
  },

  onShow: function () {

  },

  orderDetail: function (e) {
    let order_id = e.currentTarget.dataset.order_id
    wx.navigateTo({
      url: '/pages/order_detail/order_detail?order_id=' + order_id
    })
  },

  orderReview: function (e) {
    if (e.currentTarget.dataset.disabled)
      return;
    
    let order_id = e.currentTarget.dataset.order_id
    app.promises.request({
      url: app.globalData.api.reviews.exist + order_id,
      data: {
        user_id: app.globalData.userInfo.user_id
      }
    }).then((res) => {
      let review_id = res.data.data;
      if (review_id == 'null') {
        this.setData({submit_show: true})
        let review = this.data.review
        review.order_id = order_id
        this.setData({review: review})
      }
      else {
        this.reviewDetail(review_id)
      }
    })
  },

  reviewDetail: function (review_id) {
    app.promises.request({
      url: app.globalData.api.reviews.detail + review_id,
      data: {
        user_id: app.globalData.userInfo.user_id
      }
    }).then((res) => {
      let review = this.data.review
      review.star = res.data.data.star
      review.content = res.data.data.content
      this.setData({
        review: review,
        review_show: true
      })
    })
  },

  hideOverlay: function () {
    this.setData({
      submit_show: false,
      review_show: false,
      review: {
        order_id: '',
        star: 0,
        content: ''
      }
    })
  },

  starChange: function (e) {
    let review = this.data.review
    review.star = e.detail
    this.setData({review: review})
  },

  contentChange: function (e) {
    let review = this.data.review
    review.content = e.detail.value
    this.setData({review: review})
  },

  submitReview: function () {
    app.promises.request({
      url: app.globalData.api.reviews.submit,
      data: {
        user_id: app.globalData.userInfo.user_id,
        order_id: this.data.review.order_id,
        star: this.data.review.star,
        content: this.data.review.content
      },
      method: 'POST'
    }).then(() => {
      wx.showModal({
        title: 'Complete',
        content: 'Review is sent',
        showCancel: false,
        confirmText: 'OK',
        complete: () => {
          this.hideOverlay()
        }
      })
    })
  }
})