// Load Dotenv
require('dotenv').config();

const path = require('path');
const baseDir = path.resolve(__dirname);

const config = {
    /*
     * BrowserSync
     */

    browserSync: {
        proxy: process.env.APP_URL,
        notify: false,
        open: false,
        files: [
            baseDir + '/{public,app}/**/*.{php,html}',
            baseDir + '/public/build/**/*.{js,css}',
            baseDir + '/resources/{views,lang}/**/*.{php,twig}'
        ],
    },
};

module.exports.config = config;
