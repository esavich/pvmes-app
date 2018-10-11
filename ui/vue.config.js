module.exports = {
    devServer: {
        host: '0.0.0.0',
        port: 8081,
        proxy: {
            '/api': {
                target: 'http://nginx:80/',
                changeOrigin: true
            }
        }
    }
};