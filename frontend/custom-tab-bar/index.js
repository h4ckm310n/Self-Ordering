// custom_tab-bar/index.js
Component({
  properties: {

  },

  data: {
    active: null,
    tabs: [
      {icon: 'wap-home-o', text: 'Home', page: '/pages/index/index'},
      {icon: 'user-o', text: 'Me', page: '/pages/me/me'}
    ]
  },

  methods: {
    onChange: function (e) {
      this.setData({active: e.detail})
      wx.switchTab({
        url: this.data.tabs[e.detail].page
      })
    }
  }
})
