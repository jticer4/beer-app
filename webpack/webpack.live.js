let webpack = require("webpack");
let webpackMerge = require("webpack-merge");
let ExtractTextPlugin = require("extract-text-webpack-plugin");
let commonConfig = require("./webpack.common.js");
let helpers = require("./helpers");
let targetUrl = require("./target.js");

const ENV = process.env.NODE_ENV = process.env.ENV = "live";

module.exports = webpackMerge(commonConfig, {
	output: {
		path: helpers.root("public_html/dist"),
		publicPath: "dist",
		filename: "[name].[hash].js",
		chunkFilename: "[id].[hash].chunk.js"
	},

	plugins: [
		new webpack.NoEmitOnErrorsPlugin(),
		new webpack.optimize.UglifyJsPlugin(),
		new ExtractTextPlugin("[name].[hash].css"),
		new webpack.DefinePlugin({
			"process.env": {
				"BASE_HREF": JSON.stringify(targetUrl().substring(targetUrl().indexOf("/", targetUrl().indexOf("//") + 2))),
				"ENV": JSON.stringify(ENV)
			}
		}),
		new webpack.LoaderOptionsPlugin({
			htmlLoader: {
				minimize: false // workaround for ng2
			}
		})
	]
});