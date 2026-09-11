/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: 'class',
  content: [
    "./resources/views/**/*.blade.php",
    "./resources/assets/js/**/*.js",
    "./public/js/**/*.js"
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Inter', 'Roboto', 'sans-serif'],
      },
      colors: {
        brand: {
          50: '#f0f4fc',
          100: '#d9e2f7',
          500: '#192965',
          600: '#132152',
          700: '#0d173d',
        }
      },
      boxShadow: {
        'xs': '0 1px 2px 0 rgba(0, 0, 0, 0.05)',
      }
    },
  },
  plugins: [],
}
