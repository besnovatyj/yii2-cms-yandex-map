/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

/**
 * Type definitions for Yandex Map Tabular Manager
 */

/**
 * Configuration for Tabular Manager
 */
export interface TabularConfig {
    /** CSS class for the tabular block container */
    blockClass: string;
    /** Prefix for form field names */
    namePrefix: string;
}

/**
 * Marker form data structure
 */
export interface MarkerFormData {
    latitude: number;
    longitude: number;
    title: string;
    subTitle: string;
    color: string;
}

/**
 * Location form data structure
 */
export interface LocationFormData {
    latitude: number;
    longitude: number;
    zoom: number;
}

/**
 * ColorPicker configuration
 */
export interface ColorPickerConfig {
    /** Initial color value in HEX format */
    initialColor?: string;
    /** Callback when color changes */
    onChange?: (color: string) => void;
}

/**
 * Preset color for ColorPicker palette
 */
export interface PresetColor {
    name: string;
    value: string;
}
