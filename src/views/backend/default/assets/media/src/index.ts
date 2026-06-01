/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

/**
 * Yandex Map Tabular Manager
 * Main entry point for the tabular input system
 *
 * @author Your Name
 * @license UNLICENSED
 */

import { TabularManager } from './TabularManager';
import { TabularConfig } from './types';

/**
 * Initialize Tabular Manager on DOM ready
 */
document.addEventListener('DOMContentLoaded', () => {
    // Find all tabular blocks
    const tabularBlocks = document.querySelectorAll<HTMLElement>('.tabular-block');

    if (tabularBlocks.length === 0) {
        console.warn('No tabular blocks found on the page');
        return;
    }

    // Initialize each tabular block
    tabularBlocks.forEach((block) => {
        try {
            const config: TabularConfig = {
                blockClass: 'tabular-block',
                namePrefix: 'MarkerForm',
            };

            const manager = new TabularManager(block, config);

            // Attach form validation before submit
            const form = block.closest('form');
            if (form) {
                form.addEventListener('submit', (e) => {
                    if (!manager.validateAll()) {
                        e.preventDefault();
                        alert('Please fix validation errors before submitting');
                        return false;
                    }
                });
            }

            // Log initialization success
            console.log('Tabular Manager initialized successfully');
        } catch (error) {
            console.error('Failed to initialize Tabular Manager:', error);
        }
    });
});

// Export for potential external use
export { TabularManager } from './TabularManager';
export { ColorPicker } from './ColorPicker';
