import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/filament/**/*.blade.php',
        './storage/framework/views/*.php',
      './resources/views/**/*.blade.php',
    ],

    darkMode: 'class',

    theme: {
        extend: {
         fontFamily: {
       sans: [
           '-apple-system',
           'BlinkMacSystemFont',
              'SF Pro Display',
                 'SF Pro Text',
        'Inter',
                    'system-ui',
               ...defaultTheme.fontFamily.sans
        ],
                khmer: ['Noto Sans Khmer', 'Khmer OS Battambang', 'sans-serif'],
          },
          colors: {
                // macOS System Colors
          bg: {
                light: '#F5F5F7',
                  dark: '#1D1D1F',
       },
                surface: {
                    light: 'rgba(255, 255, 255, 0.72)',
            dark: 'rgba(40, 40, 42, 0.72)',
           },
           border: {
              light: 'rgba(0, 0, 0, 0.08)',
                  dark: 'rgba(255, 255, 255, 0.10)',
                },
            text: {
                    primary: {
                     light: '#1D1D1F',
                 dark: '#F5F7',
             },
              secondary: {
                 light: '#6E6E73',
                        dark: '#A1A1A6',
                    },
             },
       // macOS Accent Blue
              accent: {
                    DEFAULT: '#0071E3',
                    hover: '#0077ED',
         pressed: '#006EDB',
                },
           // Traffic Light Colors
                red: '#FF5F57',
            yellow: '#FEBC2E',
                green: '#28C840',
            },
            borderRadius: {
                'card': '12px',
              'modal': '18px',
                'button': '8px',
            },
            boxShadow: {
          'resting': '0 1px 2px rgba(0, 0, 0, 0.04), 0 1px 1px rgba(0, 0, 0, 0.06)',
                'hover': '0 4px 12px rgba(0, 0, 0, 0.08), 0 2px 4px rgba(0, 0, 0, 0.04)',
                'modal': '0 20px 60px rgba(0, 0, 0, 0.25)',
            },
            backdropBlur: {
                'glass': '20px',
        },
        backdropSaturate: {
            'glass': '180%',
            },
            letterSpacing: {
             'display': '-0.022em',
            },
        transitionTimingFunction: {
              'macos': 'cubic-bezier(0.4, 0, 0.2, 1)',
          },
        },
    },

    plugins: [forms],
};
