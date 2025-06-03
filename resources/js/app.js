import './bootstrap';
import { Livewire } from '../../vendor/livewire/livewire/dist/livewire.esm';
import Alpine from 'alpinejs';
import { Car3D } from './car3d';

window.Alpine = Alpine;
Alpine.start();
Livewire.start();

// Initialize car 3D model when the DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    const carCanvas = document.getElementById('car-canvas');
    if (carCanvas) {
        new Car3D('car-canvas');
    }
});