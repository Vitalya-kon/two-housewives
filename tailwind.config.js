/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        'node_modules/flowbite-vue/**/*.{js,jsx,ts,tsx,vue}',
        'node_modules/flowbite/**/*.{js,jsx,ts,tsx}'
      ],
      variants: {
        extend: {
        textColor: ['hover'],
        }
    },
    theme: {
        container: {
            center: true, // Центрирование контейнера по умолчанию
            padding: '7rem', // Добавление горизонтального отступа по умолчанию
        },
        fontFamily: {
            'montserrat': ['Montserrat', 'sans-serif']
        },
        extend: {
            height: {
              '30vh': '30vh',
              '40vh': '40vh',
              '50vh': '50vh',
              '60vh': '60vh',
              '70vh': '70vh',
              '80vh': '80vh',
              '90vh': '90vh',
              '100vh': '100vh',
            }
          }
    },
    plugins: [
        require('flowbite/plugin'),
        // require("daisyui")
    ],

}

