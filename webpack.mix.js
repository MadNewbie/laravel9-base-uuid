const mix = require('laravel-mix');

mix

// Backyard
// Role
    .js('resources/js/backyard/user/role/index.js', 'public/js/backyard/user/role')
    .js('resources/js/backyard/user/user/index.js', 'public/js/backyard/user/user')