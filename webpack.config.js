const path = require('path');
const WorkboxPlugin = require('workbox-webpack-plugin');

module.exports = {
    plugins: [
        new WorkboxPlugin.GenerateSW({
            cleanupOutdatedCaches: true,
            clientsClaim: true,
            maximumFileSizeToCacheInBytes: 10485760,
            mode: 'production',
            skipWaiting: true
        })
    ],
    output: {
        publicPath: ''
    },
    resolve: {
        alias: {
            '@': path.resolve('resources/js'),
        },
    },
};
