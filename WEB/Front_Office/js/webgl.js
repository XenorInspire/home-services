import * as THREE from '/build/three.module.js';

import { EffectComposer } from '/build/EffectComposer.js';
import { RenderPass } from '/build/RenderPass.js';
import { GlitchPass } from '/build/GlitchPass.js';

var startButton = document.getElementById('startButton');
startButton.addEventListener('click', init);

var camera, scene, renderer, composer, video;
var particles;
var PARTICLE_SIZE = 20;
var raycaster, intersects;
var mouse, INTERSECTED;
var clock = new THREE.Clock();
var glitchPass;

var ENABLE_GLITH = true;
var COUNTER_GLITCH = 0;

function init() {

    var blocker = document.getElementById('blocker');
    blocker.remove();

    getVideo();

    var container = document.getElementById('container');

    scene = new THREE.Scene();
    camera = new THREE.PerspectiveCamera(45, window.innerWidth / window.innerHeight, 1, 100000);
    camera.position.z = 250;

    var vertices = new THREE.BoxGeometry(200, 200, 200, 16, 16, 16).vertices;

    var positions = new Float32Array(vertices.length * 3);
    var colors = new Float32Array(vertices.length * 3);
    var sizes = new Float32Array(vertices.length);

    var vertex;
    var color = new THREE.Color();

    for (var i = 0, l = vertices.length; i < l; i++) {

        vertex = vertices[i];
        vertex.toArray(positions, i * 3);

        color.setHSL(0.01 + 0.1 * (i / l), 1.0, 0.5);
        color.toArray(colors, i * 3);

        sizes[i] = PARTICLE_SIZE * 0.5;

    }

    var geometry = new THREE.BufferGeometry();
    geometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));
    geometry.setAttribute('customColor', new THREE.BufferAttribute(colors, 3));
    geometry.setAttribute('size', new THREE.BufferAttribute(sizes, 1));

    //

    var material = new THREE.ShaderMaterial({

        uniforms: {
            color: { value: new THREE.Color(0xffffff) },
            pointTexture: { value: new THREE.TextureLoader().load("img/disc.png") }
        },
        vertexShader: document.getElementById('vertexshader').textContent,
        fragmentShader: document.getElementById('fragmentshader').textContent,

        alphaTest: 0.9

    });

    //

    video = document.getElementById('background');
    video.play();

    var Vtexture = new THREE.VideoTexture(video);
    Vtexture.minFilter = THREE.LinearFilter;
    Vtexture.magFilter = THREE.LinearFilter;
    Vtexture.format = THREE.RGBFormat;

    var planGeometry = new THREE.PlaneBufferGeometry(1280, 720, 32);
    var planMaterial = new THREE.MeshBasicMaterial({ map: Vtexture });
    var plane = new THREE.Mesh(planGeometry, planMaterial);
    scene.add(plane);
    plane.position.set(0, 0, -300);

    //

    particles = new THREE.Points(geometry, material);
    scene.add(particles);

    //

    renderer = new THREE.WebGLRenderer();
    renderer.setPixelRatio(window.devicePixelRatio);
    renderer.setSize(window.innerWidth, window.innerHeight);
    container.appendChild(renderer.domElement);

    //

    raycaster = new THREE.Raycaster();
    mouse = new THREE.Vector2();

    // postprocessing

    composer = new EffectComposer(renderer);
    composer.addPass(new RenderPass(scene, camera));

    glitchPass = new GlitchPass();
    composer.addPass(glitchPass);

    //

    window.addEventListener('resize', onWindowResize, false);
    document.addEventListener('mousemove', onDocumentMouseMove, false);

    animate();

}

function onDocumentMouseMove(event) {

    event.preventDefault();

    mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
    mouse.y = - (event.clientY / window.innerHeight) * 2 + 1;

}

function onWindowResize() {

    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();

    renderer.setSize(window.innerWidth, window.innerHeight);
    composer.setSize(window.innerWidth, window.innerHeight);

}

function animate() {

    COUNTER_GLITCH++;
    requestAnimationFrame(animate);
    render();

    if (ENABLE_GLITH == true)
        composer.render();

    if (COUNTER_GLITCH > 80)
        disable();

    console.log("x : " + camera.position.x);
    console.log("y : " + camera.position.y);
    console.log("z : " + camera.position.z);


}

function render() {

    var delta = clock.getDelta();
    particles.rotation.x += delta / 5;
    particles.rotation.y += delta / 3;

    var geometry = particles.geometry;
    var attributes = geometry.attributes;

    raycaster.setFromCamera(mouse, camera);
    intersects = raycaster.intersectObject(particles);

    if (intersects.length > 0) {

        if (INTERSECTED != intersects[0].index) {

            attributes.size.array[INTERSECTED] = PARTICLE_SIZE;

            INTERSECTED = intersects[0].index;

            attributes.size.array[INTERSECTED] = PARTICLE_SIZE * 1.25;
            attributes.size.needsUpdate = true;

        }

    } else if (INTERSECTED !== null) {

        attributes.size.array[INTERSECTED] = PARTICLE_SIZE;
        attributes.size.needsUpdate = true;
        INTERSECTED = null;

    }

    renderer.render(scene, camera);

}

function disable() {

    ENABLE_GLITH = false;

}

function getVideo() {

    let container = document.getElementById('container');
    let video = document.createElement('video');

    video.id = "background";
    video.src = "video/background.mp4";
    video.style.display = "none";
    video.loop = true;
    video.setAttribute('webkit-playsinline', 'webkit-playsinline');
    video.crossOrigin = "anonymous";

    container.appendChild(video);

}