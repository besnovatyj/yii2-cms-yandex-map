# Yandex Map Tabular Manager

TypeScript-based tabular input manager for Yandex Map markers with custom ColorPicker.

## Features

- **TypeScript Strict Mode**: Fully typed codebase for better maintainability
- **Custom ColorPicker**: No external dependencies, UNLICENSED compatible
- **Client-side Validation**: Real-time validation for coordinates, colors, and text fields
- **Auto-fill Functionality**: One-click fill from Location data and map name
- **Smooth Animations**: Fade-in/fade-out effects for adding/removing rows
- **Responsive Design**: Mobile-friendly with Bootstrap 5
- **Modern Architecture**: ES2020+ with modular structure

## Installation

### Prerequisites

- Node.js >= 16.0.0
- npm >= 8.0.0

### Setup

1. Navigate to the assets directory:
   ```bash
   cd Besnovatyj/YandexMap/views/backend/default/assets
   ```

2. Install dependencies:
   ```bash
   npm install
   ```

3. Build the project:
   ```bash
   npm run build
   ```

## Development

### Watch Mode

For development with auto-rebuild on file changes:

```bash
npm run watch
```

### Build for Production

```bash
npm run build
```

### Clean Build

```bash
npm run clean && npm run build
```

## Project Structure

```
assets/
├── src/
│   ├── ColorPicker.ts       # Custom color picker component
│   ├── TabularManager.ts    # Main tabular input manager
│   ├── index.ts             # Entry point
│   ├── types.d.ts           # TypeScript type definitions
│   └── styles.scss          # SCSS styles
├── dist/                    # Compiled output (generated)
│   ├── index.js
│   ├── index.js.map
│   ├── styles.css
│   └── styles.css.map
├── package.json
├── tsconfig.json
├── esbuild.config.js
└── README.md
```

## Usage

The assets are automatically loaded in the `_form.php` view file. The TabularManager initializes on DOM ready and provides the following features:

### Adding Markers

Click the **+** button in the card header to add a new marker row.

### Removing Markers

Click the **trash icon** button to remove a marker row. Confirmation dialog will appear.

### Auto-filling Data

Click the **magic icon** button to auto-fill:
- Latitude/Longitude from the Location section
- Title from the Map name

### Color Selection

Click the colored preview box to open the color picker with:
- Preset color palette (12 colors)
- HEX input field for custom colors
- Visual preview

### Validation

Client-side validation is performed in real-time for:
- **Latitude**: -90 to 90
- **Longitude**: -180 to 180
- **Color**: HEX format (#000000 or #000)
- **Title/SubTitle**: Max 255 characters

Invalid fields are highlighted with red borders and error messages.

## Technologies

- **TypeScript**: ^5.7.3
- **ESBuild**: ^0.25.4 (for bundling)
- **Sass**: ^1.83.4 (for styles)
- **Target**: ES2020
- **Module**: ESNext

## License

MIT 

## Browser Support

- Chrome/Edge: Latest 2 versions
- Firefox: Latest 2 versions
- Safari: Latest 2 versions
- Mobile browsers: iOS Safari, Chrome Android

## Contributing

This is part of the Yii2-cms project. Follow the main project's coding standards:
- PSR-12 for PHP
- TypeScript strict mode
- No external dependencies for core functionality

## Troubleshooting

### Build Errors

If you encounter build errors:

1. Clean and reinstall:
   ```bash
   rm -rf node_modules package-lock.json
   npm install
   ```

2. Check Node.js version:
   ```bash
   node --version  # Should be >= 16.0.0
   ```

### Runtime Errors

Check browser console for errors. Common issues:

- **Module not loading**: Ensure `type="module"` is set in script tag
- **Styles not applying**: Clear browser cache and rebuild CSS
- **Validation not working**: Check that `data-validation` attributes are present

## Future Improvements

Potential enhancements:
- [ ] Add drag-and-drop reordering for markers
- [ ] Implement bulk operations (delete all, duplicate, etc.)
- [ ] Add map preview with live marker positioning
- [ ] Export/import marker configurations
- [ ] Add keyboard shortcuts for power users
