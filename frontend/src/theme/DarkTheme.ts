import type { ThemeTypes } from '@/types/themeTypes/ThemeType';

const DarkTheme: ThemeTypes = {
  name: 'DarkTheme',
  dark: true,
  variables: {
    'border-color': '#333',
    'carousel-control-size': 10
  },
  colors: {
    primary: '#5D87FF',
    secondary: '#49BEFF',
    info: '#539BFF',
    success: '#13DEB9',
    accent: '#FFAB91',
    warning: '#FFAE1F',
    error: '#FA896B',
    muted: '#5a6a85',
    lightprimary: '#ECF2FF',
    lightsecondary: '#E8F7FF',
    lightsuccess: '#E6FFFA',
    lighterror: '#FDEDE8',
    lightwarning: '#FEF5E5',
    textPrimary: '#fff', // Changed to white for better visibility on dark background
    textSecondary: '#ccc', // Changed to light gray for contrast
    borderColor: '#333',
    inputBorder: '#fff', // Changed to white for better visibility on dark background
    containerBg: '#222', // Changed to dark gray for background
    hoverColor: '#333', // Changed to slightly darker gray for hover effect
    surface: '#222', // Changed to dark gray for surface
    'on-surface-variant': '#fff', // Changed to white for better visibility on dark background
    grey100: '#333', // Changed to dark gray for light gray shades
    grey200: '#444' // Changed to darker gray for darker gray shades
  }
};

export { DarkTheme };