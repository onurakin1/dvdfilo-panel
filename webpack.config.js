const path = require('path');

module.exports = {
    resolve: {
        alias: {
            '@': path.resolve('resources/js'),
            '@popperjs/core/lib/popper-lite': '@popperjs/core/lib/popper-lite.js',
            '@popperjs/core/lib/modifiers/preventOverflow': '@popperjs/core/lib/modifiers/preventOverflow.js',
            '@popperjs/core/lib/modifiers/flip': '@popperjs/core/lib/modifiers/flip.js',
            'lodash-es/uniq': 'lodash-es/uniq.js',
            'lodash-es/find': 'lodash-es/find.js',
            'lodash-es/clone': 'lodash-es/clone.js',
            'lodash-es/filter': 'lodash-es/filter.js',
            'lodash-es/findKey': 'lodash-es/findKey.js',
            'lodash-es/forEach': 'lodash-es/forEach.js',
            'lodash-es/isEqual': 'lodash-es/isEqual.js',
            'lodash-es/map': 'lodash-es/map.js',
            'lodash-es/pickBy': 'lodash-es/pickBy.js',
        },
    },
    output: {
        chunkFilename: 'js/[name].js?id=[chunkhash]',
    },
    module: {
        rules: [
            {
                test: /\.m?js/,
                exclude: /node_modules/,
                type: "javascript/auto",
            },
            {
                test: /\.m?js/,
                resolve: {
                    fullySpecified: false,
                },
            },
        ],
    }

};
