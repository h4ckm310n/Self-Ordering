const request =  (args) => {
  let url = args.url
  let data = args.data
  let method = args.method
  let user = wx.getStorageSync('userInfo')
  let skey = user ? user.skey : '000000'
  let header = {
    'Authorization': 'Bearer ' + skey
  }
  return new Promise((resolve, reject) => {
    wx.request({
      url: url,
      data: data,
      method: method,
      header: header,
      success: (res) => {
        if (res.statusCode == 200)
          resolve(res)
        else
          reject(res)
      },
      fail: (err) => {
        reject(err)
      }
    })
  })
}

const checkSession = () => {
  return new Promise((resolve, reject) => {
    wx.checkSession({
      success: () => {
        resolve()
      },
      fail: () => {
        reject()
      }
    })
  })
}

const login = () => {
  return new Promise((resolve, reject) => {
    wx.login({
      success: (res) => {
        if (res.code)
          resolve(res)
        else
          reject(res)
      },

      fail: (err) => {
        reject(err)
      }
    })
  })
}

module.exports = {
  request: request,
  checkSession: checkSession,
  login: login
}