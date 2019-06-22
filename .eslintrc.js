module.exports = {
	"env": {
		"browser": true,
		"commonjs": true,
		"es6": true
	},
	"extends": [
		"eslint:recommended",
		"plugin:vue/recommended"
	],
	"parserOptions": {
		"sourceType": "module",
		"ecmaVersion": 7,
		"ecmaFeatures": {
			"experimentalObjectRestSpread": true,
			"experimentalDecorators": true,
		}
	},
	"rules": {
		"indent": [
			"error",
			"tab"
		],
		"vue/max-attributes-per-line": [2, {
			"multiline": {
				"allowFirstLine": true
			}
		}],
		"vue/html-indent": [
			"error",
			"tab"
		],
		"linebreak-style": [
			"error",
			"unix"
		],
		"quotes": [
			"error",
			"double"
		],
		"semi": [
			"error",
			"always"
		],

		"no-unused-vars": 0,
		"no-undef": 0,
	}
};