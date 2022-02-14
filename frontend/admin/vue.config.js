var link = "http://localhost:8080/nafdac/backend"
module.exports = {
  publicPath: process.env.VUE_APP_BASE_URL,
  outputDir: 'dist',
  devServer: {
    proxy: {
    "^/assets": {
        target: link,
        pathRewrite: { "^/passports/": "/passports/" },
        changeOrigin: true,
        logLevel: "debug"
      },
      // End user
      "^/admin": {
        target: link,
        pathRewrite: { "^/admin/": "/admin/" },
        changeOrigin: true,
        logLevel: "debug"
      },
      "^/user": {
        target: link,
        pathRewrite: { "^/user/": "/user/" },
        changeOrigin: true,
        logLevel: "debug"
      },
      "^/pub": {
        target: link,
        pathRewrite: { "^/pub/": "/pub/" },
        changeOrigin: true,
        logLevel: "debug"
      },

    }
  }
};