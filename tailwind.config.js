/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      fontFamily: {
        'inter': ['Inter', 'sans-serif'],
        'poppins': ['Poppins', 'sans-serif'],
      },
      colors: {
        primary: {
          50: '#f5f3ff',
          100: '#ede9fe',
          200: '#ddd6fe',
          300: '#c4b5fd',
          400: '#a78bfa',
          500: '#8b5cf6',
          600: '#7c3aed',
          700: '#6d28d9',
          800: '#5b21b6',
          900: '#4c1d95',
        },
        'admin': {
            'primary': '#0EA5E9',
            'secondary': '#0284C7',
            'accent': '#06B6D4',
            'dark': '#0F172A',
            'darker': '#020617',
            'slate': '#1E293B',
            'slate-light': '#334155',
        },
      },
      animation: {
        'pulse': 'pulse 4s ease-in-out infinite',
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}