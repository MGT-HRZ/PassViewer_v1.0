tailwind.config = {
    darkMode: 'class',
    theme: {
        extend: {
            colors: {
                primary: {
                    "50": "#eff6ff",
                    "100": "#dbeafe",
                    "200": "#bfdbfe",
                    "300": "#93c5fd",
                    "400": "#60a5fa",
                    "500": "#3b82f6",
                    "600": "#2563eb",
                    "700": "#1d4ed8",
                    "800": "#1e40af",
                    "900": "#1e3a8a",
                    "950": "#172554"
                }
            }
        }
    }
};

// Get references to the DOM elements
const themeToggle = document.getElementById('theme-toggle');
const darkIcon = document.getElementById('dark-icon');
const lightIcon = document.getElementById('light-icon');

// Apply a smooth transition for theme changes
document.documentElement.classList.add('transition-all', 'duration-1000'); // Set a 1 second transition duration

// Check for the saved theme in localStorage
document.addEventListener('DOMContentLoaded', () => {
    const savedTheme = localStorage.getItem('theme');
    
    // If there's a saved theme in localStorage, apply it
    if (savedTheme === 'light') {
        document.documentElement.classList.remove('dark');
        lightIcon.classList.remove('hidden');
        darkIcon.classList.add('hidden');
    } else {
        document.documentElement.classList.add('dark');
        darkIcon.classList.remove('hidden');
        lightIcon.classList.add('hidden');
    }
});

// Event listener for toggling the theme
themeToggle.addEventListener('click', () => {
    // Toggle the 'dark' class on the html element
    document.documentElement.classList.toggle('dark');

    // Check if the dark class is present
    const isDarkMode = document.documentElement.classList.contains('dark');

    // Save the selected theme in localStorage for persistence
    localStorage.setItem('theme', isDarkMode ? 'dark' : 'light');

    // Toggle the visibility of the icons based on the theme
    darkIcon.classList.toggle('hidden', !isDarkMode);
    lightIcon.classList.toggle('hidden', isDarkMode);
});

