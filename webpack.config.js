// webpack.config.js
const path = require('path');

module.exports = {
    entry: './src/index.js', // Your entry JavaScript file
    output: {
        path: path.resolve(__dirname, 'public/dist'), // Output directory
        filename: 'bundle.js', // Output filename
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env'],
                    },
                },
            },
        ],
    },
};
