const path = require("path");
// const CopyPlugin = require("copy-webpack-plugin");

const config = {
    entry: "./src/js/all.js",
    output: {
        filename: "all.min.js",
        path: path.join(__dirname, "/dist/js"),
    },
    resolve: {
        modules: [path.resolve("./src/js"), path.resolve("./node_modules")],
        extensions: [".tsx", ".css", ".scss", ".ts", ".js"],
    },
    mode: 'none',
    module: {
        rules: [
            {
                test: /\.(ts|js)x?$/,
                exclude: /node_modules/,
                use: ["babel-loader"],
            },
            {
            test: /\.css$/,
                use : [
                    {
                            loader: 'style-loader',
                    },
                    {
                            loader: 'css-loader',
                            options: {
                                    sourceMap: true,
                            }
                    }
                ]
            }
        ],
    },
};

module.exports = config;