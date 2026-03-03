/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        'ontime-blue': '#1e3a8a',
        'ontime-orange': '#f59e0b',
      }
    },
  },
  plugins: [],
}