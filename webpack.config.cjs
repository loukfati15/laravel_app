const path = require('path');

module.exports = {
    entry: './public/js/modul_data.js', // Path to your main JS file
    output: {
        filename: 'modul_data.bundle.js', // Name of the bundled output file
        path: path.resolve(__dirname, 'public/js'), // Directory to output the bundled file
    },
    module: {
        rules: [
            {
                test: /\.js$/, // Apply Babel loader to JavaScript files
                exclude: /node_modules/, // Exclude node_modules directory
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env'], // Use Babel preset-env
                    },
                },
            },
        ],
    },
    mode: 'development', // Set mode to development
};
