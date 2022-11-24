const mix = require('laravel-mix');

mix

// Backyard
// Role
    .js('resources/js/backyard/user/role/index.js', 'public/js/backyard/user/role')

// User
    .js('resources/js/backyard/user/user/index.js', 'public/js/backyard/user/user')
    .js('resources/js/backyard/user/user/_form.js', 'public/js/backyard/user/user')

// Profile
    .js('resources/js/backyard/user/profile/_form.js', 'public/js/backyard/user/profile')