import * as THREE from 'three';
import { OrbitControls } from 'three/examples/jsm/controls/OrbitControls.js';
import gsap from 'gsap';

let scene, camera, renderer, cube, floor;
  let geometry, material;
  let length = 5, width = 5, depth = 5, color = "#FFF452"; // Default values
  let isDragging = false; // Track if the mouse is dragging
  let previousMousePosition = { x: 0, y: 0 }; // Track previous mouse position for rotation
  const textureCache = {}; // Cache for loaded textures

  function initThreeJs() {
      const canvasContainer = document.getElementById('threeCanvas');
      canvasContainer.innerHTML = ''; // Clear previous canvas

      // Scene & Camera
      scene = new THREE.Scene();
      camera = new THREE.PerspectiveCamera(75, canvasContainer.clientWidth / 400, 0.1, 1000);
      camera.position.set(5, 5, 5); // Adjusted camera position
      camera.lookAt(0, 2.5, 0);

      // Renderer with Transparent Background
      renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
      renderer.setSize(canvasContainer.clientWidth, 400);
      renderer.setClearColor(0xffffff, 0); // Transparent background
      renderer.shadowMap.enabled = true; // Enable Shadows
      canvasContainer.appendChild(renderer.domElement);
      // Floor (Ground)
        const floorGeometry = new THREE.PlaneGeometry(20, 20);
        const floorMaterial = new THREE.ShadowMaterial({ opacity: 0.5 });
        floor = new THREE.Mesh(floorGeometry, floorMaterial);
        floor.rotation.x = -Math.PI / 2;
        floor.position.y = 0;
        floor.receiveShadow = true;
        scene.add(floor);

      // Lighting
      const ambientLight = new THREE.AmbientLight(0xffffff, 0.8);
      scene.add(ambientLight);

      const directionalLight = new THREE.DirectionalLight(0xffffff, 1.5);
      directionalLight.position.set(10, 10, 5);
      directionalLight.castShadow = true;
      directionalLight.shadow.mapSize.set(2048, 2048);
      scene.add(directionalLight);

      // Create Box
      updateBox();

      const pointLight = new THREE.PointLight(0xffffff, 2, 100);
      pointLight.position.set(5, 5, 5);
      scene.add(pointLight);

      new OrbitControls(camera, renderer.domElement);

      // Animation
      function animate() {
          requestAnimationFrame(animate);
          renderer.render(scene, camera);
      }
      animate();

      // Add Cursor Controller for 360-Degree Rotation
      const canvas = renderer.domElement;
      canvas.addEventListener('mousedown', (e) => {isDragging = true;});
      canvas.addEventListener('mouseup', (e) => {isDragging = false;});
      canvas.addEventListener('mousemove', (e) => {
          if (isDragging) {
              const deltaX = e.clientX - previousMousePosition.x;
              const deltaY = e.clientY - previousMousePosition.y;
              // Rotate the cube based on mouse movement
              cube.rotation.y += deltaX * 0.01; // Rotate horizontally
              cube.rotation.x += deltaY * 0.01; // Rotate vertically
          }
          previousMousePosition = { x: e.clientX, y: e.clientY };
      });
  }

  function loadTexture(url) {
    if (textureCache[url]) return textureCache[url];
    const loader = new THREE.TextureLoader();
    const texture = loader.load(url);
    textureCache[url] = texture;
    return texture;
}
function updateBox() {
    if (cube) scene.remove(cube);

    geometry = new THREE.BoxGeometry(length, width, depth);
    material = new THREE.MeshStandardMaterial({ map: loadTexture('https://everytexture.com/wp-content/uploads/2019/01/everytexture-com-stock-paper-texture-00042.jpg'), color });

    cube = new THREE.Mesh(geometry, material);
    cube.position.y = width / 2;
    cube.castShadow = true;
    scene.add(cube);
}

window.addEventListener('resize', () => {
    const canvasContainer = document.getElementById('threeCanvas');
    camera.aspect = canvasContainer.clientWidth / 400;
    camera.updateProjectionMatrix();
    renderer.setSize(canvasContainer.clientWidth, 400);
});

  // Event Listener for Modal Open
  document.getElementById('customizeModal').addEventListener('shown.bs.modal', initThreeJs);

    // Box Control Events
    ['length', 'width', 'depth', 'color'].forEach(id => {
        document.getElementById(id).addEventListener('input', (e) => {
            if (id === 'color') {
                color = e.target.value;
            } else {
                if (!isNaN(parseFloat(e.target.value))) {
                    if (id === 'length') length = parseFloat(e.target.value);
                    if (id === 'width') width = parseFloat(e.target.value);
                    if (id === 'depth') depth = parseFloat(e.target.value);
                }
            }
            updateBox();
        });
    });

  // Movement and Rotation Controls
  ['front', 'back', 'left', 'right', 'top', 'bottom'].forEach((id, i) => {
    document.getElementById(id).addEventListener('click', () => {
        const rotations = [
            [0, 0], [Math.PI, 0], [0, -Math.PI / 2], [0, Math.PI / 2], [-Math.PI / 2, 0], [Math.PI / 2, 0]
        ];
        gsap.to(cube.rotation, { x: rotations[i][0], y: rotations[i][1], duration: 0.8, ease: "power2.out" });
    });
});

// Manual Rotation Controls
document.getElementById('rotateLeft').addEventListener('click', () => cube.rotation.y += 0.1);
document.getElementById('rotateRight').addEventListener('click', () => cube.rotation.y -= 0.1);
document.getElementById('resetRotation').addEventListener('click', () => gsap.to(cube.rotation, { x: 0, y: 0, z: 0, duration: 0.5 }));
  // New Features: Upload Image & Input Text
document.getElementById('uploadImage').addEventListener('change', (e) => {
  const file = e.target.files[0];
  if (file) {
      const reader = new FileReader();
      reader.onload = function(event) {
          const textureLoader = new THREE.TextureLoader();
          const uploadedTexture = textureLoader.load(event.target.result);
          cube.material.map = uploadedTexture;
          cube.material.needsUpdate = true;
      };
      reader.readAsDataURL(file);
  }
});

document.getElementById('textInput').addEventListener('input', (e) => {
  const text = e.target.value;
  const canvas = document.createElement('canvas');
  const ctx = canvas.getContext('2d');
  canvas.width = 256;
  canvas.height = 256;
  ctx.fillStyle = "white";
  ctx.fillRect(0, 0, canvas.width, canvas.height);
  ctx.fillStyle = "black";
  ctx.font = "20px Arial";
  ctx.fillText(text, 50, 100);

  const textureLoader = new THREE.TextureLoader();
  const textTexture = new THREE.CanvasTexture(canvas);
  cube.material.map = textTexture;
  cube.material.needsUpdate = true;
});