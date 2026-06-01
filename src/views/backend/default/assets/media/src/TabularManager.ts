/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

/**
 * TabularManager - Manages dynamic tabular input for markers
 *
 * @author Your Name
 * @license UNLICENSED
 */

import { TabularConfig, MarkerFormData, LocationFormData } from './types';
import { ColorPicker } from './ColorPicker';

/**
 * TabularManager class
 * Manages adding, removing, and validating marker rows in a tabular form
 */
export class TabularManager {
    private readonly blockElement: HTMLElement;
    private readonly rowsContainer: HTMLElement;
    private readonly config: TabularConfig;
    private rowIndex: number = 0;
    private colorPickers: Map<number, ColorPicker> = new Map();
    private locationData: LocationFormData | null = null;
    private mapName: string = '';

    /**
     * Constructor
     *
     * @param blockElement - The container element for the tabular block
     * @param config - Configuration options
     */
    constructor(blockElement: HTMLElement, config: TabularConfig) {
        this.blockElement = blockElement;
        this.config = config;

        const rowsContainer = this.blockElement.querySelector('.tabular-rows');
        if (!rowsContainer) {
            throw new Error('Rows container not found');
        }
        this.rowsContainer = rowsContainer as HTMLElement;

        // Calculate initial row index
        this.calculateRowIndex();

        // Initialize color pickers for existing rows
        this.initializeExistingRows();

        // Attach event listeners
        this.attachEventListeners();

        // Extract location data
        this.extractLocationData();

        // Extract map name
        this.extractMapName();
    }

    /**
     * Calculate the current row index based on existing rows
     */
    private calculateRowIndex(): void {
        const rows = this.rowsContainer.querySelectorAll('.tabular-row');
        this.rowIndex = rows.length;
    }

    /**
     * Initialize color pickers for existing rows
     */
    private initializeExistingRows(): void {
        const rows = this.rowsContainer.querySelectorAll('.tabular-row');
        rows.forEach((row, index) => {
            const colorInput = row.querySelector('input[type="color"], input[name*="color"]') as HTMLInputElement;
            if (colorInput) {
                const picker = new ColorPicker(colorInput);
                this.colorPickers.set(index, picker);
            }
        });
    }

    /**
     * Attach event listeners to the block
     */
    private attachEventListeners(): void {
        // Delegate click events
        this.blockElement.addEventListener('click', (e: MouseEvent) => {
            const target = e.target as HTMLElement;

            // Add row button
            if (target.closest('.tabular-add-btn')) {
                e.preventDefault();
                this.addRow();
            }

            // Delete row button
            if (target.closest('.tabular-del-btn')) {
                e.preventDefault();
                const row = target.closest('.tabular-row') as HTMLElement;
                if (row) {
                    this.deleteRow(row);
                }
            }

            // Auto-fill button
            if (target.closest('.tabular-autofill-btn')) {
                e.preventDefault();
                const row = target.closest('.tabular-row') as HTMLElement;
                if (row) {
                    this.autoFillRow(row);
                }
            }
        });

        // Validation on input changes
        this.rowsContainer.addEventListener('input', (e: Event) => {
            const target = e.target as HTMLInputElement;
            if (target.tagName === 'INPUT') {
                this.validateField(target);
            }
        });
    }

    /**
     * Add a new row to the tabular form
     */
    private addRow(): void {
        // Create new row element
        const newRow = this.createNewRow();

        // Add fade-in animation
        newRow.style.opacity = '0';
        this.rowsContainer.appendChild(newRow);

        // Trigger animation
        requestAnimationFrame(() => {
            newRow.style.transition = 'opacity 0.3s ease-in';
            newRow.style.opacity = '1';
        });

        // Initialize color picker for the new row
        const colorInput = newRow.querySelector('input[name*="color"]') as HTMLInputElement;
        if (colorInput) {
            const picker = new ColorPicker(colorInput);
            this.colorPickers.set(this.rowIndex, picker);
        }

        this.rowIndex++;
    }

    /**
     * Create a new row element
     */
    private createNewRow(): HTMLDivElement {
        const row = document.createElement('div');
        row.className = 'row tabular-row mb-3';

        row.innerHTML = `
            <div class="col-md-2">
                <div class="form-group field-markerform-${this.rowIndex}-latitude">
                    <label class="form-label" for="markerform-${this.rowIndex}-latitude">Latitude</label>
                    <input type="text" id="markerform-${this.rowIndex}-latitude"
                           class="form-control"
                           name="${this.config.namePrefix}[${this.rowIndex}][latitude]"
                           placeholder="0.000000"
                           data-validation="latitude">
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group field-markerform-${this.rowIndex}-longitude">
                    <label class="form-label" for="markerform-${this.rowIndex}-longitude">Longitude</label>
                    <input type="text" id="markerform-${this.rowIndex}-longitude"
                           class="form-control"
                           name="${this.config.namePrefix}[${this.rowIndex}][longitude]"
                           placeholder="0.000000"
                           data-validation="longitude">
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group field-markerform-${this.rowIndex}-title">
                    <label class="form-label" for="markerform-${this.rowIndex}-title">Title</label>
                    <input type="text" id="markerform-${this.rowIndex}-title"
                           class="form-control"
                           name="${this.config.namePrefix}[${this.rowIndex}][title]"
                           maxlength="255"
                           data-validation="title">
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group field-markerform-${this.rowIndex}-subtitle">
                    <label class="form-label" for="markerform-${this.rowIndex}-subtitle">SubTitle</label>
                    <input type="text" id="markerform-${this.rowIndex}-subtitle"
                           class="form-control"
                           name="${this.config.namePrefix}[${this.rowIndex}][subTitle]"
                           maxlength="255"
                           data-validation="subtitle">
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group field-markerform-${this.rowIndex}-color">
                    <label class="form-label" for="markerform-${this.rowIndex}-color">Color</label>
                    <input type="color" id="markerform-${this.rowIndex}-color"
                           class="form-control"
                           name="${this.config.namePrefix}[${this.rowIndex}][color]"
                           value="#808080"
                           data-validation="color">
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="col-md-1 d-flex align-items-end gap-1">
                <button type="button" class="btn btn-sm btn-info tabular-autofill-btn"
                        title="Auto-fill from Location">
                    <i class="bi bi-stars"></i>
                </button>
                <button type="button" class="btn btn-sm btn-danger tabular-del-btn">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        `;

        return row;
    }

    /**
     * Delete a row from the tabular form
     */
    private deleteRow(row: HTMLElement): void {
        const rowCount = this.rowsContainer.querySelectorAll('.tabular-row').length;

        // Prevent deleting the last row
        if (rowCount <= 1) {
            this.showNotification('Cannot delete the last row', 'warning');
            return;
        }

        // Confirm deletion
        if (!confirm('Are you sure you want to delete this marker?')) {
            return;
        }

        // Find and destroy the color picker for this row
        const colorInput = row.querySelector('input[name*="color"]') as HTMLInputElement;
        if (colorInput) {
            const rowIndexMatch = colorInput.name.match(/\[(\d+)\]/);
            if (rowIndexMatch) {
                const index = parseInt(rowIndexMatch[1], 10);
                const picker = this.colorPickers.get(index);
                if (picker) {
                    picker.destroy();
                    this.colorPickers.delete(index);
                }
            }
        }

        // Add fade-out animation
        row.style.transition = 'opacity 0.3s ease-out';
        row.style.opacity = '0';

        setTimeout(() => {
            row.remove();
        }, 300);
    }

    /**
     * Auto-fill row with Location data and map name
     */
    private autoFillRow(row: HTMLElement): void {
        if (!this.locationData) {
            this.showNotification('Location data not available', 'warning');
            return;
        }

        const latitudeInput = row.querySelector('input[data-validation="latitude"]') as HTMLInputElement;
        const longitudeInput = row.querySelector('input[data-validation="longitude"]') as HTMLInputElement;
        const titleInput = row.querySelector('input[data-validation="title"]') as HTMLInputElement;

        if (latitudeInput) {
            latitudeInput.value = this.locationData.latitude.toFixed(6);
            this.validateField(latitudeInput);
        }

        if (longitudeInput) {
            longitudeInput.value = this.locationData.longitude.toFixed(6);
            this.validateField(longitudeInput);
        }

        if (titleInput && this.mapName) {
            titleInput.value = this.mapName;
            this.validateField(titleInput);
        }

        this.showNotification('Data auto-filled successfully', 'success');
    }

    /**
     * Extract location data from the form
     */
    private extractLocationData(): void {
        const latitudeInput = document.querySelector('input[name="LocationForm[latitude]"]') as HTMLInputElement;
        const longitudeInput = document.querySelector('input[name="LocationForm[longitude]"]') as HTMLInputElement;
        const zoomInput = document.querySelector('input[name="LocationForm[zoom]"]') as HTMLInputElement;

        if (latitudeInput && longitudeInput && zoomInput) {
            this.locationData = {
                latitude: parseFloat(latitudeInput.value) || 0,
                longitude: parseFloat(longitudeInput.value) || 0,
                zoom: parseInt(zoomInput.value, 10) || 1,
            };

            // Update location data on input changes
            [latitudeInput, longitudeInput, zoomInput].forEach(input => {
                input.addEventListener('input', () => {
                    if (this.locationData) {
                        this.locationData.latitude = parseFloat(latitudeInput.value) || 0;
                        this.locationData.longitude = parseFloat(longitudeInput.value) || 0;
                        this.locationData.zoom = parseInt(zoomInput.value, 10) || 1;
                    }
                });
            });
        }
    }

    /**
     * Extract map name from the form
     */
    private extractMapName(): void {
        const nameInput = document.querySelector('input[name="MapForm[name]"]') as HTMLInputElement;
        if (nameInput) {
            this.mapName = nameInput.value || '';

            // Update map name on input changes
            nameInput.addEventListener('input', () => {
                this.mapName = nameInput.value || '';
            });
        }
    }

    /**
     * Validate a form field
     */
    private validateField(input: HTMLInputElement): void {
        const validationType = input.getAttribute('data-validation');
        let isValid = true;
        let errorMessage = '';

        switch (validationType) {
            case 'latitude':
                isValid = this.validateLatitude(input.value);
                errorMessage = 'Latitude must be between -90 and 90';
                break;

            case 'longitude':
                isValid = this.validateLongitude(input.value);
                errorMessage = 'Longitude must be between -180 and 180';
                break;

            case 'color':
                isValid = this.validateColor(input.value);
                errorMessage = 'Color must be in HEX format (#000000)';
                break;

            case 'title':
            case 'subtitle':
                isValid = input.value.length <= 255;
                errorMessage = 'Maximum 255 characters allowed';
                break;
        }

        // Update field state
        const formGroup = input.closest('.form-group');
        const feedbackElement = formGroup?.querySelector('.invalid-feedback');

        if (isValid) {
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');
            if (feedbackElement) {
                feedbackElement.textContent = '';
            }
        } else {
            input.classList.remove('is-valid');
            input.classList.add('is-invalid');
            if (feedbackElement) {
                feedbackElement.textContent = errorMessage;
            }
        }
    }

    /**
     * Validate latitude value
     */
    private validateLatitude(value: string): boolean {
        const num = parseFloat(value);
        return !isNaN(num) && num >= -90 && num <= 90;
    }

    /**
     * Validate longitude value
     */
    private validateLongitude(value: string): boolean {
        const num = parseFloat(value);
        return !isNaN(num) && num >= -180 && num <= 180;
    }

    /**
     * Validate HEX color format
     */
    private validateColor(value: string): boolean {
        return /^#[0-9A-Fa-f]{6}$/.test(value) || /^#[0-9A-Fa-f]{3}$/.test(value);
    }

    /**
     * Show notification to user
     */
    private showNotification(message: string, type: 'success' | 'warning' | 'error'): void {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show position-fixed`;
        notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        notification.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;

        document.body.appendChild(notification);

        // Auto-remove after 3 seconds
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }

    /**
     * Validate all rows before form submission
     */
    public validateAll(): boolean {
        let isValid = true;
        const inputs = this.rowsContainer.querySelectorAll('input[data-validation]');

        inputs.forEach(input => {
            this.validateField(input as HTMLInputElement);
            if (input.classList.contains('is-invalid')) {
                isValid = false;
            }
        });

        return isValid;
    }

    /**
     * Get all marker data
     */
    public getMarkerData(): MarkerFormData[] {
        const markers: MarkerFormData[] = [];
        const rows = this.rowsContainer.querySelectorAll('.tabular-row');

        rows.forEach(row => {
            const latitudeInput = row.querySelector('input[data-validation="latitude"]') as HTMLInputElement;
            const longitudeInput = row.querySelector('input[data-validation="longitude"]') as HTMLInputElement;
            const titleInput = row.querySelector('input[data-validation="title"]') as HTMLInputElement;
            const subTitleInput = row.querySelector('input[data-validation="subtitle"]') as HTMLInputElement;
            const colorInput = row.querySelector('input[data-validation="color"]') as HTMLInputElement;

            if (latitudeInput && longitudeInput) {
                markers.push({
                    latitude: parseFloat(latitudeInput.value) || 0,
                    longitude: parseFloat(longitudeInput.value) || 0,
                    title: titleInput?.value || '',
                    subTitle: subTitleInput?.value || '',
                    color: colorInput?.value || '#808080',
                });
            }
        });

        return markers;
    }
}
