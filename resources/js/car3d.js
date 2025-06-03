import * as THREE from 'three';
import { GLTFLoader } from 'three/examples/jsm/loaders/GLTFLoader';

export class Car3D {
    constructor(containerId) {
        this.container = document.getElementById(containerId);
        this.scene = new THREE.Scene();
        this.camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
        
        // Renderer setup
        this.renderer = new THREE.WebGLRenderer({ 
            antialias: true,
            alpha: true 
        });
        this.renderer.setSize(window.innerWidth, window.innerHeight);
        this.renderer.setPixelRatio(window.devicePixelRatio);
        this.renderer.outputEncoding = THREE.sRGBEncoding;
        this.container.appendChild(this.renderer.domElement);

        // Lights
        this.setupLights();
        
        // Camera position
        this.camera.position.set(5, 2, 5);
        this.camera.lookAt(0, 0, 0);

        // Create simple car geometry (placeholder until we load a real model)
        this.createSimpleCar();

        // Handle window resize
        window.addEventListener('resize', this.onWindowResize.bind(this));

        // Start animation loop
        this.animate();
    }

    setupLights() {
        // Ambient light
        const ambientLight = new THREE.AmbientLight(0xffffff, 0.5);
        this.scene.add(ambientLight);

        // Directional light (sun-like)
        const dirLight = new THREE.DirectionalLight(0xffffff, 1);
        dirLight.position.set(5, 5, 5);
        this.scene.add(dirLight);

        // Point lights for dramatic effect
        const pointLight1 = new THREE.PointLight(0x00ff87, 1, 10);
        pointLight1.position.set(-2, 2, 2);
        this.scene.add(pointLight1);

        const pointLight2 = new THREE.PointLight(0x60efff, 1, 10);
        pointLight2.position.set(2, -2, -2);
        this.scene.add(pointLight2);
    }

    createSimpleCar() {
        // Car body
        const bodyGeometry = new THREE.BoxGeometry(2, 0.5, 4);
        const bodyMaterial = new THREE.MeshPhongMaterial({ 
            color: 0x000000,
            specular: 0x666666,
            shininess: 100
        });
        this.carBody = new THREE.Mesh(bodyGeometry, bodyMaterial);

        // Cabin
        const cabinGeometry = new THREE.BoxGeometry(1.5, 0.5, 2);
        const cabinMaterial = new THREE.MeshPhongMaterial({ 
            color: 0x111111,
            specular: 0x666666,
            shininess: 100
        });
        this.cabin = new THREE.Mesh(cabinGeometry, cabinMaterial);
        this.cabin.position.y = 0.5;
        this.cabin.position.z = -0.5;

        // Wheels
        const wheelGeometry = new THREE.CylinderGeometry(0.3, 0.3, 0.2, 32);
        const wheelMaterial = new THREE.MeshPhongMaterial({ color: 0x333333 });
        
        this.wheels = [];
        const wheelPositions = [
            { x: -1, y: -0.3, z: 1.2 },
            { x: 1, y: -0.3, z: 1.2 },
            { x: -1, y: -0.3, z: -1.2 },
            { x: 1, y: -0.3, z: -1.2 },
        ];

        wheelPositions.forEach(pos => {
            const wheel = new THREE.Mesh(wheelGeometry, wheelMaterial);
            wheel.rotation.z = Math.PI / 2;
            wheel.position.set(pos.x, pos.y, pos.z);
            this.wheels.push(wheel);
        });

        // Group all car parts
        this.car = new THREE.Group();
        this.car.add(this.carBody);
        this.car.add(this.cabin);
        this.wheels.forEach(wheel => this.car.add(wheel));

        // Add to scene
        this.scene.add(this.car);
    }

    onWindowResize() {
        this.camera.aspect = window.innerWidth / window.innerHeight;
        this.camera.updateProjectionMatrix();
        this.renderer.setSize(window.innerWidth, window.innerHeight);
    }

    animate() {
        requestAnimationFrame(this.animate.bind(this));

        // Rotate car smoothly
        if (this.car) {
            this.car.rotation.y += 0.005;
            
            // Add subtle floating animation
            this.car.position.y = Math.sin(Date.now() * 0.001) * 0.1;
        }

        this.renderer.render(this.scene, this.camera);
    }
} 