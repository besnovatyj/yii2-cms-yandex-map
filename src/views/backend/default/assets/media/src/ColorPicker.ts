/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

/**
 * ColorPicker - Simple color picker component with preset palette
 *
 * @author Your Name
 * @license UNLICENSED
 */

import { ColorPickerConfig, PresetColor } from './types';

/**
 * ColorPicker class
 * Provides a custom color picker UI with preset colors and HEX input
 */
export class ColorPicker {
    private inputElement: HTMLInputElement;
    private pickerWrapper: HTMLDivElement | null = null;
    private config: ColorPickerConfig;
    private currentColor: string;

    /**
     * Preset colors palette
     */
    private readonly presetColors: PresetColor[] = [
        { name: 'Red', value: '#FF0000' },
        { name: 'Orange', value: '#FFA500' },
        { name: 'Yellow', value: '#FFFF00' },
        { name: 'Green', value: '#00FF00' },
        { name: 'Blue', value: '#0000FF' },
        { name: 'Purple', value: '#800080' },
        { name: 'Pink', value: '#FFC0CB' },
        { name: 'Gray', value: '#808080' },
        { name: 'Black', value: '#000000' },
        { name: 'White', value: '#FFFFFF' },
        { name: 'Brown', value: '#A52A2A' },
        { name: 'Cyan', value: '#00FFFF' },
    ];

    /**
     * Constructor
     *
     * @param inputElement - The input element to attach color picker to
     * @param config - Configuration options
     */
    constructor(inputElement: HTMLInputElement, config: ColorPickerConfig = {}) {
        this.inputElement = inputElement;
        this.config = config;
        this.currentColor = config.initialColor || inputElement.value || '#808080';

        this.init();
    }

    /**
     * Initialize the color picker
     */
    private init(): void {
        // Hide the native color input
        this.inputElement.type = 'hidden';

        // Create the custom color picker UI
        this.createPickerUI();

        // Update preview with initial color
        this.updateColor(this.currentColor);
    }

    /**
     * Create the color picker UI elements
     */
    private createPickerUI(): void {
        // Create wrapper
        this.pickerWrapper = document.createElement('div');
        this.pickerWrapper.className = 'color-picker-wrapper';

        // Create preview button
        const previewButton = document.createElement('button');
        previewButton.type = 'button';
        previewButton.className = 'color-picker-preview';
        previewButton.style.backgroundColor = this.currentColor;
        previewButton.setAttribute('aria-label', 'Open color picker');

        // Create dropdown panel
        const dropdownPanel = document.createElement('div');
        dropdownPanel.className = 'color-picker-dropdown';

        // Create HEX input
        const hexInputGroup = document.createElement('div');
        hexInputGroup.className = 'color-picker-hex-input-group';

        const hexLabel = document.createElement('label');
        hexLabel.textContent = 'HEX:';
        hexLabel.className = 'color-picker-hex-label';

        const hexInput = document.createElement('input');
        hexInput.type = 'text';
        hexInput.className = 'color-picker-hex-input form-control form-control-sm';
        hexInput.value = this.currentColor;
        hexInput.maxLength = 7;
        hexInput.placeholder = '#000000';

        hexInputGroup.appendChild(hexLabel);
        hexInputGroup.appendChild(hexInput);

        // Create palette grid
        const paletteGrid = document.createElement('div');
        paletteGrid.className = 'color-picker-palette';

        this.presetColors.forEach(preset => {
            const colorButton = document.createElement('button');
            colorButton.type = 'button';
            colorButton.className = 'color-picker-preset';
            colorButton.style.backgroundColor = preset.value;
            colorButton.setAttribute('title', preset.name);
            colorButton.setAttribute('data-color', preset.value);

            paletteGrid.appendChild(colorButton);
        });

        // Append elements
        dropdownPanel.appendChild(hexInputGroup);
        dropdownPanel.appendChild(paletteGrid);

        this.pickerWrapper.appendChild(previewButton);
        this.pickerWrapper.appendChild(dropdownPanel);

        // Insert after the hidden input
        this.inputElement.parentElement?.insertBefore(
            this.pickerWrapper,
            this.inputElement.nextSibling
        );

        // Attach event listeners
        this.attachEventListeners(previewButton, dropdownPanel, hexInput, paletteGrid);
    }

    /**
     * Attach event listeners to picker elements
     */
    private attachEventListeners(
        previewButton: HTMLButtonElement,
        dropdownPanel: HTMLDivElement,
        hexInput: HTMLInputElement,
        paletteGrid: HTMLDivElement
    ): void {
        // Toggle dropdown on preview button click
        previewButton.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            dropdownPanel.classList.toggle('show');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (this.pickerWrapper && !this.pickerWrapper.contains(e.target as Node)) {
                dropdownPanel.classList.remove('show');
            }
        });

        // Handle HEX input changes
        hexInput.addEventListener('input', () => {
            const value = hexInput.value.trim();
            if (this.isValidHex(value)) {
                this.updateColor(value);
                previewButton.style.backgroundColor = value;
            }
        });

        hexInput.addEventListener('blur', () => {
            const value = hexInput.value.trim();
            if (!this.isValidHex(value)) {
                hexInput.value = this.currentColor;
            }
        });

        // Handle preset color clicks
        paletteGrid.addEventListener('click', (e) => {
            const target = e.target as HTMLElement;
            if (target.classList.contains('color-picker-preset')) {
                const color = target.getAttribute('data-color');
                if (color) {
                    this.updateColor(color);
                    previewButton.style.backgroundColor = color;
                    hexInput.value = color;
                    dropdownPanel.classList.remove('show');
                }
            }
        });
    }

    /**
     * Update the current color value
     */
    private updateColor(color: string): void {
        this.currentColor = color;
        this.inputElement.value = color;

        // Trigger change event for form validation
        const event = new Event('change', { bubbles: true });
        this.inputElement.dispatchEvent(event);

        // Call onChange callback if provided
        if (this.config.onChange) {
            this.config.onChange(color);
        }
    }

    /**
     * Validate HEX color format
     */
    private isValidHex(hex: string): boolean {
        return /^#[0-9A-Fa-f]{6}$/.test(hex) || /^#[0-9A-Fa-f]{3}$/.test(hex);
    }

    /**
     * Get current color value
     */
    public getColor(): string {
        return this.currentColor;
    }

    /**
     * Set color value programmatically
     */
    public setColor(color: string): void {
        if (this.isValidHex(color)) {
            this.updateColor(color);

            // Update UI elements
            if (this.pickerWrapper) {
                const previewButton = this.pickerWrapper.querySelector('.color-picker-preview') as HTMLButtonElement;
                const hexInput = this.pickerWrapper.querySelector('.color-picker-hex-input') as HTMLInputElement;

                if (previewButton) {
                    previewButton.style.backgroundColor = color;
                }
                if (hexInput) {
                    hexInput.value = color;
                }
            }
        }
    }

    /**
     * Destroy the color picker and cleanup
     */
    public destroy(): void {
        if (this.pickerWrapper && this.pickerWrapper.parentElement) {
            this.pickerWrapper.parentElement.removeChild(this.pickerWrapper);
        }
        this.inputElement.type = 'text';
    }
}
