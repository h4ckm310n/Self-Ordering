// pages/order_detail/order_detail.js
var app = getApp();

Page({
  data: {
    order_id: '',
    amount: 0,
    remark: '',
    order_num: 0,
    datetime: '',
    status: '',
    dine_way: '',
    dishes: [],
  },

  onLoad: function (options) {
    let status_text = ['Unpaid', 'Paid', 'Cancelled']
    let dine_way_text = ['Eat in', 'Take away']
    app.promises.request({
      url: app.globalData.api.orders.detail + options.order_id,
      data: {
        user_id: app.globalData.userInfo.user_id
      }
    }).then((res) => {
      this.setData({
        order_id: res.data.data.order_id,
        amount: res.data.data.amount,
        remark: res.data.data.remark,
        datetime: res.data.data.datetime,
        status: status_text[res.data.data.status],
        order_num: res.data.data.order_num == 0 ? 'Cancel' : res.data.data.order_num,
        dine_way: dine_way_text[res.data.data.dine_way-1],
        dishes: res.data.data.dishes
      })
    })
  },

  onShow: function () {

  }
})