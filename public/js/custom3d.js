import * as THREE from 'three';
import { OrbitControls } from 'three/addons/controls/OrbitControls.js';
import { mergeBufferGeometries } from 'three/addons/utils/BufferGeometryUtils.js';
import { GUI } from 'three/addons/libs/lil-gui.module.min.js';
import { TransformControls } from 'three/addons/controls/TransformControls.js';
import { GLTFExporter } from 'three/addons/exporters/GLTFExporter.js';

// Check for gsap (loaded via HTML script tags)
if (typeof gsap === 'undefined') {
    console.error('gsap not loaded. Ensure script tags are present in HTML.');
}

const container = document.querySelector('.container3d');
const boxCanvas = document.querySelector('#box-canvas');
let textMesh = null; // Variable to store the text mesh
let uploadInput = null; // Initialize uploadInput globally as null
let faceMeshes = {}; // Store meshes for each face
let selectedFaceMesh = null;

let box = {
    params: {
        breadth: 27,
        breadthLimits: [15, 70],
        length: 80,
        lengthLimits: [40, 120],
        height: 45,
        heightLimits: [15, 70],
        thickness: .6,
        thicknessLimits: [.1, 1],
        fluteFreq: 5,
        fluteFreqLimits: [3, 7],
        flapGap: 1,
        copyrightSize: [27, 10]
    },
    els: {
        group: new THREE.Group(),
        backHalf: {
            breadth: { top: new THREE.Mesh(), side: new THREE.Mesh(), bottom: new THREE.Mesh() },
            length: { top: new THREE.Mesh(), side: new THREE.Mesh(), bottom: new THREE.Mesh() },
        },
        frontHalf: {
            breadth: { top: new THREE.Mesh(), side: new THREE.Mesh(), bottom: new THREE.Mesh() },
            length: { top: new THREE.Mesh(), side: new THREE.Mesh(), bottom: new THREE.Mesh() },
        }
    },
    animated: {
        openingAngle: .02 * Math.PI,
        flapAngles: {
            backHalf: { breadth: { top: 0, bottom: 0 }, length: { top: 0, bottom: 0 } },
            frontHalf: { breadth: { top: 0, bottom: 0 }, length: { top: 0, bottom: 0 } }
        }
    }
};

// Globals
let renderer, scene, camera, orbit, lightHolder, rayCaster, mouse, copyright,transformControls;

// Run the app
initScene();
createControls();
window.addEventListener('resize', updateSceneSize);

// Three.js scene
function initScene() {
    renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true, canvas: boxCanvas });
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));

    scene = new THREE.Scene();
    camera = new THREE.PerspectiveCamera(45, container.clientWidth / container.clientHeight, 10, 1000);
    camera.position.set(40, 90, 110);
    rayCaster = new THREE.Raycaster();
    mouse = new THREE.Vector2(0, 0);

    updateSceneSize();

    scene.add(box.els.group);
    setGeometryHierarchy();

    const ambientLight = new THREE.AmbientLight(0xffffff, .5);
    scene.add(ambientLight);
    lightHolder = new THREE.Group();
    const topLight = new THREE.PointLight(0xffffff, .5);
    topLight.position.set(-30, 300, 0);
    lightHolder.add(topLight);
    const sideLight = new THREE.PointLight(0xffffff, .7);
    sideLight.position.set(50, 0, 150);
    lightHolder.add(sideLight);
    scene.add(lightHolder);

    const material = new THREE.MeshStandardMaterial({ color: new THREE.Color(0x9C8D7B), side: THREE.DoubleSide });
    box.els.group.traverse(c => { if (c.isMesh) c.material = material; });

    orbit = new OrbitControls(camera, boxCanvas);
    orbit.enableZoom = false;
    orbit.enablePan = false;
    orbit.enableDamping = true;
    orbit.autoRotate = false;
    orbit.autoRotateSpeed = .25;

    // Initialize TransformControls
    transformControls = new TransformControls(camera, renderer.domElement);
    transformControls.setSize(0.5); // Smaller controls for better UI
    transformControls.setTranslationSnap(0.1); // Snap to grid while moving
    transformControls.setRotationSnap(THREE.MathUtils.degToRad(15)); // Snap to 15-degree increments
    transformControls.setScaleSnap(0.1); // Snap to 0.1 increments while scaling
    scene.add(transformControls);

    // Disable OrbitControls while using TransformControls
    transformControls.addEventListener('dragging-changed', (event) => {
        orbit.enabled = !event.value;
    });

    setupFaceViewControls();
    createCopyright();
    createBoxElements();
    createFoldingAnimation();
    createZooming();

    render();
}

function render() {
    orbit.update();
    lightHolder.quaternion.copy(camera.quaternion);
    renderer.render(scene, camera);
    requestAnimationFrame(render);
}

function updateSceneSize() {
    camera.aspect = container.clientWidth / container.clientHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(container.clientWidth, container.clientHeight);
}

// Box geometries
function setGeometryHierarchy() {
    box.els.group.add(box.els.frontHalf.breadth.side, box.els.frontHalf.length.side, box.els.backHalf.breadth.side, box.els.backHalf.length.side);
    box.els.frontHalf.breadth.side.add(box.els.frontHalf.breadth.top, box.els.frontHalf.breadth.bottom);
    box.els.frontHalf.length.side.add(box.els.frontHalf.length.top, box.els.frontHalf.length.bottom);
    box.els.backHalf.breadth.side.add(box.els.backHalf.breadth.top, box.els.backHalf.breadth.bottom);
    box.els.backHalf.length.side.add(box.els.backHalf.length.top, box.els.backHalf.length.bottom);
}

function createBoxElements() {
    for (let halfIdx = 0; halfIdx < 2; halfIdx++) {
        for (let sideIdx = 0; sideIdx < 2; sideIdx++) {
            const half = halfIdx ? 'frontHalf' : 'backHalf';
            const side = sideIdx ? 'breadth' : 'length';
            const sideBreadth = side === 'breadth' ? box.params.breadth : box.params.length;
            const flapBreadth = sideBreadth - 2 * box.params.flapGap;
            const flapHeight = .5 * box.params.breadth - .75 * box.params.flapGap;

            const sidePlaneGeometry = new THREE.PlaneGeometry(sideBreadth, box.params.height, Math.floor(5 * sideBreadth), Math.floor(.2 * box.params.height));
            const flapPlaneGeometry = new THREE.PlaneGeometry(flapBreadth, flapHeight, Math.floor(5 * flapBreadth), Math.floor(.2 * flapHeight));

            const sideGeometry = createSideGeometry(sidePlaneGeometry, [sideBreadth, box.params.height], [true, true, true, true], false);
            const topGeometry = createSideGeometry(flapPlaneGeometry, [flapBreadth, flapHeight], [false, false, true, false], true);
            const bottomGeometry = createSideGeometry(flapPlaneGeometry, [flapBreadth, flapHeight], [true, false, false, false], true);

            topGeometry.translate(0, .5 * flapHeight, 0);
            bottomGeometry.translate(0, -.5 * flapHeight, 0);

            box.els[half][side].top.geometry = topGeometry;
            box.els[half][side].side.geometry = sideGeometry;
            box.els[half][side].bottom.geometry = bottomGeometry;

            box.els[half][side].top.position.y = .5 * box.params.height;
            box.els[half][side].bottom.position.y = -.5 * box.params.height;
        }
    }
    updatePanelsTransform();
}

function createSideGeometry(baseGeometry, size, folds, hasMiddleLayer) {
    const geometriesToMerge = [];
    geometriesToMerge.push(getLayerGeometry(v => -.5 * box.params.thickness + .01 * Math.sin(box.params.fluteFreq * v)));
    geometriesToMerge.push(getLayerGeometry(v => .5 * box.params.thickness + .01 * Math.sin(box.params.fluteFreq * v)));
    if (hasMiddleLayer) {
        geometriesToMerge.push(getLayerGeometry(v => .5 * box.params.thickness * Math.sin(box.params.fluteFreq * v)));
    }

    function getLayerGeometry(offset) {
        const layerGeometry = baseGeometry.clone();
        const positionAttr = layerGeometry.attributes.position;
        for (let i = 0; i < positionAttr.count; i++) {
            const x = positionAttr.getX(i);
            const y = positionAttr.getY(i);
            let z = positionAttr.getZ(i) + offset(x);
            z = applyFolds(x, y, z);
            positionAttr.setXYZ(i, x, y, z);
        }
        return layerGeometry;
    }

    function applyFolds(x, y, z) {
        let modifier = (c, s) => (1. - Math.pow(c / (.5 * s), 10.));
        if ((x > 0 && folds[1]) || (x < 0 && folds[3])) z *= modifier(x, size[0]);
        if ((y > 0 && folds[0]) || (y < 0 && folds[2])) z *= modifier(y, size[1]);
        return z;
    }

    const mergedGeometry = new mergeBufferGeometries(geometriesToMerge, false);
    mergedGeometry.computeVertexNormals();
    return mergedGeometry;
}

// Clickable copyright
function createCopyright() {
    const textInput = document.querySelector('.text-input');
    if (!textInput) {
        console.error('Text input element with class "text-input" not found in the DOM.');
        return;
    }

    // Function to create or update a mesh for a specific face
    function createFaceMesh(face) {
        let width, height, targetMesh;
        switch (face) {
            case 'front':
                width = box.params.length;
                height = box.params.height;
                targetMesh = box.els.frontHalf.length.side;
                break;
            case 'back':
                width = box.params.length;
                height = box.params.height;
                targetMesh = box.els.backHalf.length.side;
                break;
            case 'left':
                width = box.params.breadth;
                height = box.params.height;
                targetMesh = box.els.frontHalf.breadth.side;
                break;
            case 'right':
                width = box.params.breadth;
                height = box.params.height;
                targetMesh = box.els.backHalf.breadth.side;
                break;
            case 'top':
                width = box.params.length;
                height = box.params.breadth;
                targetMesh = box.els.frontHalf.length.top;
                break;
            case 'bottom':
                width = box.params.length;
                height = box.params.breadth;
                targetMesh = box.els.frontHalf.length.bottom;
                break;
            default:
                return null;
        }

        // If mesh already exists, update it; otherwise, create new
        if (!faceMeshes[face]) {
            const canvas = document.createElement('canvas');
            canvas.width = width * 20; // High resolution
            canvas.height = height * 20;
            const ctx = canvas.getContext('2d');
            const texture = new THREE.CanvasTexture(canvas);
            const geometry = new THREE.PlaneGeometry(width, height);
            const material = new THREE.MeshBasicMaterial({ map: texture, transparent: true, side: THREE.DoubleSide });
            faceMeshes[face] = new THREE.Mesh(geometry, material);
            scene.add(faceMeshes[face]);
        }

        // Position and rotate mesh based on target face
    const mesh = faceMeshes[face];
    const offset = 0.1; // Small offset to avoid z-fighting

    // Reset position and rotation to match the target mesh, then adjust
    mesh.position.copy(targetMesh.position);
    mesh.rotation.set(0, 0, 0); // Reset rotation before applying face-specific rotation

    switch (face) {
        case 'front':
            mesh.position.z += box.params.thickness / 2 + offset;
            // No additional rotation needed; front face is already facing outward
            break;
        case 'back':
            mesh.position.z -= box.params.thickness / 2 + offset;
            mesh.rotation.y = Math.PI; // Rotate 180 degrees to face outward
            break;
        case 'left':
            mesh.position.x -= box.params.thickness / 2 + offset;
            mesh.rotation.y = -Math.PI / 2; // Rotate to face left
            break;
        case 'right':
            mesh.position.x += box.params.thickness / 2 + offset;
            mesh.rotation.y = Math.PI / 2; // Rotate to face right
            break;
        case 'top':
            mesh.position.y += box.params.thickness / 2 + offset;
            mesh.rotation.x = -Math.PI / 2; // Rotate to face upward
            break;
        case 'bottom':
            mesh.position.y -= box.params.thickness / 2 + offset;
            mesh.rotation.x = Math.PI / 2; // Rotate to face downward
            break;
    }

    return mesh;
}

    // Function to update canvas with text and/or image
    function updateFaceCanvas(face, text, fontStyle, fontSize, image = null) {
        const mesh = createFaceMesh(face);
        if (!mesh) return;
    
        // Update canvas content
        const canvas = mesh.material.map.image;
        const ctx = canvas.getContext('2d');
        ctx.clearRect(0, 0, canvas.width, canvas.height);
    
        // Handle image drawing
        if (image) {
            const aspectRatio = image.width / image.height;
            const canvasAspect = canvas.width / canvas.height;
            let drawWidth = canvas.width;
            let drawHeight = canvas.height;
    
            if (canvasAspect > aspectRatio) {
                drawWidth = drawHeight * aspectRatio;
            } else {
                drawHeight = drawWidth / aspectRatio;
            }
    
            const xOffset = (canvas.width - drawWidth) / 2;
            const yOffset = (canvas.height - drawHeight) / 2;
    
            // Flip the image for back face
            if (face === 'back') {
                ctx.save();
                ctx.scale(-1, 1);
                ctx.drawImage(image, -xOffset - drawWidth, yOffset, drawWidth, drawHeight);
                ctx.restore();
            } else {
                ctx.drawImage(image, xOffset, yOffset, drawWidth, drawHeight);
            }
        }
    
        // Handle text drawing
        ctx.fillStyle = '#000000';
        const scaledFontSize = fontSize * 20;
        ctx.font = `${scaledFontSize}px ${fontStyle}`;
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
    
        // Flip text for back face
        if (face === 'back') {
            ctx.save();
            ctx.scale(-1, 1);
            ctx.fillText(text, -canvas.width / 2, canvas.height / 2);
            ctx.restore();
        } else {
            ctx.fillText(text, canvas.width / 2, canvas.height / 2);
        }
    
        mesh.material.map.needsUpdate = true;
    
        // Attach TransformControls to the selected face mesh
        transformControls.detach();
        transformControls.attach(mesh);
        selectedFaceMesh = mesh;
    }    

    // Initial setup for front face (optional)
    const initialFontStyle = document.getElementById('fontStyle')?.value || 'Helvetica';
    const initialFontSize = parseInt(document.getElementById('fontSize')?.value) || 6;
    const faces = ['front', 'back', 'left', 'right', 'top', 'bottom'];
    faces.forEach(face => {
        updateFaceCanvas(face, textInput.value || 'Your Text Here', initialFontStyle, initialFontSize);
    });

    // Text input listener - apply to selected face
    textInput.addEventListener('input', () => {
        const fontStyle = document.getElementById('fontStyle')?.value || 'Helvetica';
        const fontSize = parseInt(document.getElementById('fontSize')?.value) || 6;
        const face = selectedFace || 'front'; // Default to front if no face selected
        updateFaceCanvas(face, textInput.value || 'Your Text Here', fontStyle, fontSize);
    });

    // File upload
    uploadInput = document.createElement('input');
    uploadInput.type = 'file';
    uploadInput.accept = 'image/*';
    uploadInput.style.display = 'none';
    document.body.appendChild(uploadInput);

    const uploadBtn = document.getElementById('upload-btn');
    if (uploadBtn) {
        uploadBtn.addEventListener('click', () => uploadInput.click());
    }

    uploadInput.addEventListener('change', (event) => {
        const file = event.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = (e) => {
            const img = new Image();
            img.onload = () => {
                const fontStyle = document.getElementById('fontStyle')?.value || 'Helvetica';
                const fontSize = parseInt(document.getElementById('fontSize')?.value) || 6;
                const text = textInput.value || 'Your Text Here';
                const face = selectedFace || 'front'; // Default to front if no face selected
                updateFaceCanvas(face, text, fontStyle, fontSize, img);
            };
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
    });

    createTransformControlsUI();
}

function createTransformControlsUI() {
    const container = document.querySelector('.ui-controls');
    if (!container) {
        console.error('UI controls container not found in the DOM.');
        return;
    }

    // Create a div for transform controls
    const transformControlsDiv = document.createElement('div');
    transformControlsDiv.className = 'transform-controls';
    transformControlsDiv.style.marginTop = '10px';

    // Translate button (Move)
    const translateBtn = document.createElement('button');
    translateBtn.className = 'unbutton ui-controls__button transform-icon';
    translateBtn.innerHTML = '<i class="fas fa-arrows-alt"></i>'; // FontAwesome icon for move
    translateBtn.title = 'Move Image'; // Tooltip for accessibility
    translateBtn.addEventListener('click', () => {
        transformControls.setMode('translate');
    });

    // Rotate button
    const rotateBtn = document.createElement('button');
    rotateBtn.className = 'unbutton ui-controls__button transform-icon';
    rotateBtn.innerHTML = '<i class="fas fa-sync-alt"></i>'; // FontAwesome icon for rotate
    rotateBtn.title = 'Rotate Image'; // Tooltip for accessibility
    rotateBtn.addEventListener('click', () => {
        transformControls.setMode('rotate');
    });

    // Scale button
    const scaleBtn = document.createElement('button');
    scaleBtn.className = 'unbutton ui-controls__button transform-icon';
    scaleBtn.innerHTML = '<i class="fas fa-expand-arrows-alt"></i>'; // FontAwesome icon for scale
    scaleBtn.title = 'Scale Image'; // Tooltip for accessibility
    scaleBtn.addEventListener('click', () => {
        transformControls.setMode('scale');
    });

    // Append buttons to the div
    transformControlsDiv.appendChild(translateBtn);
    transformControlsDiv.appendChild(rotateBtn);
    transformControlsDiv.appendChild(scaleBtn);

    // Append the div to the UI controls container
    container.appendChild(transformControlsDiv);
}

// Animation
function createFoldingAnimation() {
    box.animated.openingAngle = 0;
    box.animated.flapAngles.backHalf.breadth.top = 0;
    box.animated.flapAngles.backHalf.breadth.bottom = 0;
    box.animated.flapAngles.backHalf.length.top = 0;
    box.animated.flapAngles.backHalf.length.bottom = 0;
    box.animated.flapAngles.frontHalf.breadth.top = 0;
    box.animated.flapAngles.frontHalf.breadth.bottom = 0;
    box.animated.flapAngles.frontHalf.length.top = 0;
    box.animated.flapAngles.frontHalf.length.bottom = 0;
    updatePanelsTransform();

    const closeTimeline = gsap.timeline({ paused: true, onUpdate: updatePanelsTransform, defaults: { ease: 'power1.inOut' } });
    closeTimeline
        .to(box.animated.flapAngles.frontHalf.length, { duration: 0.9, top: 0, bottom: 0, ease: 'back.out(4)' })
        .to(box.animated.flapAngles.backHalf.length, { duration: 0.7, top: 0, bottom: 0, ease: 'back.out(3)' }, "-=0.7")
        .to([box.animated.flapAngles.backHalf.breadth, box.animated.flapAngles.frontHalf.breadth], { duration: 0.6, top: 0, bottom: 0, ease: 'back.out(3)' }, "-=0.6")
        .to(box.animated, { duration: 1, openingAngle: 0, ease: 'power1.inOut' }, "-=0.5");

    const openTimeline = gsap.timeline({ paused: true, onUpdate: updatePanelsTransform, defaults: { ease: 'power1.inOut' } });
    openTimeline
        .to(box.animated, { duration: 1, openingAngle: 0.5 * Math.PI, ease: 'power1.inOut' })
        .to([box.animated.flapAngles.backHalf.breadth, box.animated.flapAngles.frontHalf.breadth], { duration: 0.6, bottom: 0.6 * Math.PI, ease: 'back.in(3)' }, "-=0.5")
        .to(box.animated.flapAngles.backHalf.length, { duration: 0.7, bottom: 0.5 * Math.PI, ease: 'back.in(2)' }, "-=0.4")
        .to(box.animated.flapAngles.frontHalf.length, { duration: 0.8, bottom: 0.49 * Math.PI, ease: 'back.in(3)' }, "-=0.6")
        .to([box.animated.flapAngles.backHalf.breadth, box.animated.flapAngles.frontHalf.breadth], { duration: 0.6, top: 0.6 * Math.PI, ease: 'back.in(3)' }, "-=0.5")
        .to(box.animated.flapAngles.backHalf.length, { duration: 0.7, top: 0.5 * Math.PI, ease: 'back.in(3)' }, "-=0.6")
        .to(box.animated.flapAngles.frontHalf.length, { duration: 0.9, top: 0.49 * Math.PI, ease: 'back.in(4)' }, "-=0.7");

    const closeBtn = document.getElementById('close-btn-box');
    if (closeBtn) closeBtn.addEventListener('click', () => { openTimeline.pause(); closeTimeline.restart(); });

    const openBtn = document.getElementById('open-box-btn');
    if (openBtn) openBtn.addEventListener('click', () => { closeTimeline.pause(); openTimeline.restart(); });
}

function updatePanelsTransform() {
    box.els.frontHalf.breadth.side.position.x = 0.5 * box.params.length;
    box.els.backHalf.breadth.side.position.x = -0.5 * box.params.length;
    box.els.frontHalf.breadth.side.rotation.y = box.animated.openingAngle;
    box.els.backHalf.breadth.side.rotation.y = box.animated.openingAngle;

    const cos = Math.cos(box.animated.openingAngle);
    box.els.frontHalf.length.side.position.x = -0.5 * cos * box.params.breadth;
    box.els.backHalf.length.side.position.x = 0.5 * cos * box.params.breadth;

    const sin = Math.sin(box.animated.openingAngle);
    box.els.frontHalf.length.side.position.z = 0.5 * sin * box.params.breadth;
    box.els.backHalf.length.side.position.z = -0.5 * sin * box.params.breadth;

    box.els.frontHalf.breadth.top.rotation.x = -box.animated.flapAngles.frontHalf.breadth.top;
    box.els.frontHalf.length.top.rotation.x = -box.animated.flapAngles.frontHalf.length.top;
    box.els.frontHalf.breadth.bottom.rotation.x = box.animated.flapAngles.frontHalf.breadth.bottom;
    box.els.frontHalf.length.bottom.rotation.x = box.animated.flapAngles.frontHalf.length.bottom;

    box.els.backHalf.breadth.top.rotation.x = box.animated.flapAngles.backHalf.breadth.top;
    box.els.backHalf.length.top.rotation.x = box.animated.flapAngles.backHalf.length.top;
    box.els.backHalf.breadth.bottom.rotation.x = -box.animated.flapAngles.backHalf.breadth.bottom;
    box.els.backHalf.length.bottom.rotation.x = -box.animated.flapAngles.backHalf.length.bottom;

    // Update face meshes to follow their corresponding panels
    const offset = 0.1; // Small offset to avoid z-fighting
    for (const face in faceMeshes) {
        const mesh = faceMeshes[face];
        let targetMesh;

        // Determine the target mesh for each face
        switch (face) {
            case 'front':
                targetMesh = box.els.frontHalf.length.side;
                mesh.position.copy(targetMesh.position);
                mesh.rotation.copy(targetMesh.rotation);
                mesh.position.z += box.params.thickness / 2 + offset;
                break;
            case 'back':
                targetMesh = box.els.backHalf.length.side;
                mesh.position.copy(targetMesh.position);
                mesh.rotation.copy(targetMesh.rotation);
                mesh.position.z -= box.params.thickness / 2 + offset;
                mesh.rotation.y += Math.PI; // Ensure back face is oriented outward
                break;
            case 'left':
                targetMesh = box.els.frontHalf.breadth.side;
                mesh.position.copy(targetMesh.position);
                mesh.rotation.copy(targetMesh.rotation);
                mesh.position.x -= box.params.thickness / 2 + offset;
                mesh.rotation.y -= Math.PI / 2; // Ensure left face is oriented outward
                break;
            case 'right':
                targetMesh = box.els.backHalf.breadth.side;
                mesh.position.copy(targetMesh.position);
                mesh.rotation.copy(targetMesh.rotation);
                mesh.position.x += box.params.thickness / 2 + offset;
                mesh.rotation.y += Math.PI / 2; // Ensure right face is oriented outward
                break;
            case 'top':
                targetMesh = box.els.frontHalf.length.top;
                mesh.position.copy(targetMesh.position);
                mesh.rotation.copy(targetMesh.rotation);
                mesh.position.y += box.params.thickness / 2 + offset;
                mesh.rotation.x += -Math.PI / 2; // Ensure top face is oriented upward
                break;
            case 'bottom':
                targetMesh = box.els.frontHalf.length.bottom;
                mesh.position.copy(targetMesh.position);
                mesh.rotation.copy(targetMesh.rotation);
                mesh.position.y -= box.params.thickness / 2 + offset;
                mesh.rotation.x += Math.PI / 2; // Ensure bottom face is oriented downward
                break;
        }
    }

    // Update copyright position (if applicable)
    if (copyright) {
        const frontLengthSide = box.els.frontHalf.length.side;
        copyright.position.copy(frontLengthSide.position);
        copyright.position.x += box.params.length / 2 - (copyright.geometry.parameters.width / 2);
        copyright.position.y = 0;
        copyright.position.z = frontLengthSide.position.z + (box.params.thickness / 2) + 0.1;
        copyright.rotation.copy(frontLengthSide.rotation);
    }

    if (textMesh) {
        textMesh.position.copy(box.els.frontHalf.length.side.position);
        textMesh.position.x += box.params.length / 2 - 10;
        textMesh.position.y = 0;
        textMesh.position.z += box.params.thickness + 0.1;
        textMesh.rotation.copy(box.els.frontHalf.length.side.rotation);
    }
}

// Manual zoom
function createZooming() {
    const zoomInBtn = document.querySelector('#zoom-in');
    const zoomOutBtn = document.querySelector('#zoom-out');
    let zoomLevel = 1;
    const limits = [.4, 2];

    zoomInBtn.addEventListener('click', () => { zoomLevel *= 1.3; applyZoomLimits(); });
    zoomOutBtn.addEventListener('click', () => { zoomLevel *= .75; applyZoomLimits(); });

    function applyZoomLimits() {
        if (zoomLevel > limits[1]) zoomLevel = limits[1], zoomInBtn.classList.add('disabled');
        else if (zoomLevel < limits[0]) zoomLevel = limits[0], zoomOutBtn.classList.add('disabled');
        else zoomInBtn.classList.remove('disabled'), zoomOutBtn.classList.remove('disabled');
        gsap.to(camera, { duration: .2, zoom: zoomLevel, onUpdate: () => camera.updateProjectionMatrix() });
    }
}

// Range sliders for box parameters
function createControls() {
    const gui = new GUI();
    const modalBody = document.querySelector('.modal-panel-left');
    if (modalBody) modalBody.appendChild(gui.domElement);

    function updateGUIStyles() {
        const screenWidth = window.innerWidth;
        const modalWidth = modalBody.getBoundingClientRect().width; // Get the width of .modal-panel-left
        gui.domElement.style.position = 'absolute';
        gui.domElement.style.top = '10px';
        gui.domElement.style.left = '8px';
        gui.domElement.style.right = '18px';
        gui.domElement.style.zIndex = '1000';
        gui.domElement.style.width = screenWidth < 768 ? '80%' : `${modalWidth}px`;
        if (screenWidth < 576) {
            gui.domElement.style.left = '50%';
            gui.domElement.style.transform = 'translateX(-50%)';
        } else {
            gui.domElement.style.left = '8px';
            gui.domElement.style.transform = 'none';
        }
    }

    updateGUIStyles();
    window.addEventListener("resize", updateGUIStyles);

    gui.add(box.params, 'breadth', box.params.breadthLimits[0], box.params.breadthLimits[1]).step(1).onChange(() => { createBoxElements(); updatePanelsTransform(); });
    gui.add(box.params, 'length', box.params.lengthLimits[0], box.params.lengthLimits[1]).step(1).onChange(() => { createBoxElements(); updatePanelsTransform(); });
    gui.add(box.params, 'height', box.params.heightLimits[0], box.params.heightLimits[1]).step(1).onChange(() => { createBoxElements(); updatePanelsTransform(); });
    gui.add(box.params, 'fluteFreq', box.params.fluteFreqLimits[0], box.params.fluteFreqLimits[1]).step(1).onChange(createBoxElements).name('Flute');
    gui.add(box.params, 'thickness', box.params.thicknessLimits[0], box.params.thicknessLimits[1]).step(0.05).onChange(createBoxElements);
}

// 3D Box Controller
let selectedFace = null;
function setupFaceViewControls() {
    const btnFront = document.querySelector('.b1');
    const btnLeft = document.querySelector('.b2');
    const btnBack = document.querySelector('.b3');
    const btnRight = document.querySelector('.b4');
    const btnTop = document.querySelector('.b5');
    const btnBottom = document.querySelector('.b6');
    const distance = 170;

    function moveCamera(position, lookAtTarget) {
        gsap.to(camera.position, {
            x: position.x, y: position.y, z: position.z, duration: 1,
            onUpdate: () => { camera.lookAt(lookAtTarget); camera.updateProjectionMatrix(); }
        });
    }

    btnFront.addEventListener('click', () => {
        selectedFace = 'front';
        moveCamera({ x: -80, y: 60, z: distance }, box.els.group.position);
    });
    btnBack.addEventListener('click', () => {
        selectedFace = 'back';
        moveCamera({ x: 0, y: 0, z: -distance }, box.els.group.position);
    });
    btnLeft.addEventListener('click', () => {
        selectedFace = 'left';
        moveCamera({ x: -distance, y: 0, z: 0 }, box.els.group.position);
    });
    btnRight.addEventListener('click', () => {
        selectedFace = 'right';
        moveCamera({ x: distance, y: 0, z: 0 }, box.els.group.position);
    });
    btnTop.addEventListener('click', () => {
        selectedFace = 'top';
        moveCamera({ x: 0, y: distance, z: 0 }, box.els.group.position);
    });
    btnBottom.addEventListener('click', () => {
        selectedFace = 'bottom';
        moveCamera({ x: 0, y: -distance, z: 0 }, box.els.group.position);
    });
}

// Save box configuration
async function saveBoxConfiguration() {
    const saveBtn = document.querySelector('.add-to-cart');
    try {
        // Show loading state
        saveBtn.disabled = true;
        saveBtn.textContent = 'Saving...';

        // 1. Prepare box data
        const boxData = {
            parameters: {
                breadth: box.params.breadth,
                length: box.params.length,
                height: box.params.height,
                thickness: box.params.thickness,
                fluteFreq: box.params.fluteFreq
            },
            faces: {}
        };

        const faceNames = ['front', 'back', 'left', 'right', 'top', 'bottom'];
        faceNames.forEach(face => {
            boxData.faces[face] = { hasAttachment: false, attachment: null };
            if (faceMeshes[face]) {
                const mesh = faceMeshes[face];
                boxData.faces[face].hasAttachment = true;
                boxData.faces[face].attachment = {
                    type: mesh.material.map.image ? 'image' : 'text',
                    content: mesh.material.map.image ? 'uploaded_image' : (document.querySelector('.text-input').value || ''),
                    fontStyle: document.getElementById('fontStyle')?.value || 'Helvetica',
                    fontSize: document.getElementById('fontSize')?.value || '20px',
                    position: { x: mesh.position.x, y: mesh.position.y, z: mesh.position.z },
                    rotation: { x: mesh.rotation.x, y: mesh.rotation.y, z: mesh.rotation.z },
                    scale: { x: mesh.scale.x, y: mesh.scale.y, z: mesh.scale.z }
                };
            }
        });

        // 2. Export 3D model
        const exporter = new GLTFExporter();
        const gltf = await new Promise((resolve, reject) => {
            exporter.parse(
                box.els.group,
                resolve,
                reject,
                { binary: true, embedImages: true }
            );
        });

        const modelBlob = new Blob([gltf], { type: 'model/gltf-binary' });
        const uniqueId = `${Date.now()}-${Math.random().toString(36).substr(2, 9)}`;

        // 3. Capture screenshot with error handling
        let imageBlob;
        try {
            camera.position.set(-80, 60, 170);
            camera.lookAt(box.els.group.position);
            camera.updateProjectionMatrix();
            renderer.render(scene, camera);
            
            // Verify renderer and canvas
            if (!renderer.domElement || !renderer.domElement.toDataURL) {
                throw new Error('Renderer canvas not available');
            }
            
            const imageDataUrl = renderer.domElement.toDataURL('image/png');
            if (!imageDataUrl || !imageDataUrl.startsWith('data:image/png')) {
                throw new Error('Failed to capture valid screenshot');
            }
            
            imageBlob = dataURLtoBlob(imageDataUrl);
        } catch (screenshotError) {
            console.error('Screenshot error:', screenshotError);
            throw new Error('Could not capture box preview. Please try again.');
        }

        // 4. Prepare FormData
        const formData = new FormData();
        formData.append('boxData', JSON.stringify(boxData));
        formData.append('model', modelBlob, `${uniqueId}.glb`);
        formData.append('image', imageBlob, `${uniqueId}.png`);
        formData.append('price', calculateBoxPrice(boxData));
        formData.append('seller_id', getCurrentSellerId());

        // 5. Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        
        // 6. First save the box design
        const apiUrl = `${window.location.origin}/api/box-designs/save-box-configuration`;

        // Make the request with error handling
        const response = await fetch(apiUrl, {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            credentials: 'include'
        });

        if (!response.ok) {
            const errorText = await response.text();
            throw new Error(`Server responded with ${response.status}: ${errorText}`);
        }

        const result = await response.json();
        console.log('Success:', result);
        alert('Box design saved successfully!');
        
        // 7. Then add to cart
        await addBoxDesignToCart(result.data.id, result.data.price, result.data.seller_id);

    } catch (error) {
        console.error('Error saving configuration:', error);
        alert(`Failed to save: ${error.message}`);
    } finally {
        if (saveBtn) {
            saveBtn.disabled = false;
            saveBtn.textContent = 'Add to Cart';
        }
    }
}

async function addBoxDesignToCart(boxDesignId, price, sellerId) {
    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        if (!csrfToken) {
            throw new Error('CSRF token not found');
        }

        const formData = new FormData();
        formData.append('_token', csrfToken);
        formData.append('box_design_id', boxDesignId);
        formData.append('product_type', 'box_design'); // Consistent field name
        formData.append('qty', 50);
        formData.append('price', price);
        formData.append('seller_id', sellerId);
        formData.append('shipping_method_id', 0);
        formData.append('is_buy_now', 'no');

        console.log('Sending payload:', Object.fromEntries(formData));

        const response = await fetch('/cart/store', {
            method: 'POST',
            body: formData, // Use FormData instead of JSON
            credentials: 'include'
        });

        if (!response.ok) {
            const errorData = await response.json();
            console.error('Validation errors:', errorData.errors);
            if (errorData.errors) {
                const errorMessages = Object.values(errorData.errors).flat();
                showToast('Validation errors: ' + errorMessages.join(', '));
            }
            throw new Error(errorData.message || `Server error (${response.status})`);
        }

        const result = await response.json();
        console.log('API Response:', result);
        
        updateCartUI(result.count_bottom);
        showToast('Box design added to cart!');
        
        return result;
    } catch (error) {
        console.error('Cart error:', error);
        showToast(error.message || 'Failed to add to cart');
        throw error;
    }
}
// Helper function to calculate box price (implement based on your pricing logic)
function calculateBoxPrice(boxData) {
    const basePrice = 10.00;
    const sizeFactor = boxData.parameters.length * boxData.parameters.breadth * boxData.parameters.height;
    return basePrice + (sizeFactor * 0.01);
}

// Helper function to get seller ID (implement based on your logic)
function getCurrentSellerId() {
    // This could come from a hidden field, user data, or be fixed
    return document.querySelector('meta[name="seller-id"]')?.content || 1;
}

// Add this function to your custom3d.js file
function updateCartUI(cartCount) {
    // Update the cart counter in the navbar
    const cartCounter = document.querySelector('.cart-count');
    if (cartCounter) {
        cartCounter.textContent = cartCount;
    }
    const cartPreview = document.querySelector('.cart-preview');
    if (cartPreview) {
    }

    showToast('Item added to cart!');
}


// Helper function for notifications
function showToast(message) {
    alert(message);
}
// Utility function to convert data URL to Blob
function dataURLtoBlob(dataURL) {
    try {
        if (!dataURL || typeof dataURL !== 'string') {
            throw new Error('Invalid data URL');
        }
        
        // Check if dataURL is properly formatted
        if (!dataURL.startsWith('data:')) {
            throw new Error('Invalid data URL format');
        }

        const parts = dataURL.split(',');
        if (parts.length < 2) {
            throw new Error('Malformed data URL');
        }

        const mime = parts[0].match(/:(.*?);/)[1];
        const bstr = atob(parts[1]);
        let n = bstr.length;
        const u8arr = new Uint8Array(n);

        while (n--) {
            u8arr[n] = bstr.charCodeAt(n);
        }

        return new Blob([u8arr], { type: mime });
    } catch (error) {
        console.error('Error converting data URL to Blob:', error);
        throw new Error('Failed to process image: ' + error.message);
    }
}

document.querySelector('.add-to-cart').addEventListener('click', saveBoxConfiguration);