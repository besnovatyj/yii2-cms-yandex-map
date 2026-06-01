/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

/**
 * ESBuild configuration for Yandex Map Tabular Manager
 */

import * as esbuild from 'esbuild';
import * as sass from 'sass';
import * as fs from 'fs';
import * as path from 'path';

// Check if watch mode is enabled
const isWatch = process.argv.includes('--watch');

// Build TypeScript
const buildTypeScript = async () => {
    const buildOptions = {
        entryPoints: ['src/index.ts'],
        bundle: true,
        outfile: 'dist/index.js',
        format: 'esm',
        target: 'es2020',
        sourcemap: true,
        minify: true,
        treeShaking: true,
        platform: 'browser',
        logLevel: 'info',
    };

    if (isWatch) {
        const context = await esbuild.context(buildOptions);
        await context.watch();
        console.log('Watching TypeScript files...');
    } else {
        await esbuild.build(buildOptions);
        console.log('TypeScript build completed!');
    }
};

// Build SCSS
const buildSCSS = () => {
    try {
        const result = sass.compile('src/styles.scss', {
            style: 'compressed',
            sourceMap: true,
        });

        // Ensure dist directory exists
        if (!fs.existsSync('dist')) {
            fs.mkdirSync('dist', { recursive: true });
        }

        // Write CSS
        fs.writeFileSync('dist/styles.css', result.css);

        // Write source map
        if (result.sourceMap) {
            fs.writeFileSync('dist/styles.css.map', JSON.stringify(result.sourceMap));
        }

        console.log('SCSS build completed!');
    } catch (error) {
        console.error('SCSS build failed:', error);
        process.exit(1);
    }
};

// Watch SCSS in watch mode
const watchSCSS = () => {
    console.log('Watching SCSS files...');
    fs.watch('src', { recursive: true }, (eventType, filename) => {
        if (filename && filename.endsWith('.scss')) {
            console.log(`SCSS file changed: ${filename}`);
            buildSCSS();
        }
    });
};

// Main build function
const build = async () => {
    try {
        console.log('Starting build...');

        // Build SCSS
        buildSCSS();

        // Build TypeScript
        await buildTypeScript();

        // If watch mode, also watch SCSS
        if (isWatch) {
            watchSCSS();
            console.log('Watch mode enabled. Waiting for changes...');
        } else {
            console.log('Build completed successfully!');
        }
    } catch (error) {
        console.error('Build failed:', error);
        process.exit(1);
    }
};

// Run build
build();
