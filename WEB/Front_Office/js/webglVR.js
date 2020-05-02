import * as THREE from '/build/three.module.js';
import { VRButton } from '/build/VRButton.js';

import { EffectComposer } from '/build/EffectComposer.js';
import { RenderPass } from '/build/RenderPass.js';
import { GlitchPass } from '/build/GlitchPass.js';

var startButton = document.getElementById('startButton');
startButton.addEventListener('click', init);

var camera, scene, renderer, composer, video;
var particles;
var raycaster, intersects;
var mouse;
var clock = new THREE.Clock();
var glitchPass;
var messages = [];
var texts = [];

var INTERSECTED;
var PARTICLE_SIZE = 20;
var ENABLE_GLICTH = true;
var COUNTER_GLITCH = 0;
var INITIAL_TEXT_POSITION = -175;
var MAX_TEXT_POSITION = -80;
var INDEX = 0;

function init() {

    var blocker = document.getElementById('blocker');
    blocker.remove();



    scene = new THREE.Scene();
    camera = new THREE.PerspectiveCamera(45, window.innerWidth / window.innerHeight, 1, 100000);
    camera.position.z = 250;

    // **********Musique globale**********

    var listener = new THREE.AudioListener();
    camera.add(listener);
    var global_sound = new THREE.Audio(listener);

    // load a sound and set it as the Audio object's buffer
    var audioLoader = new THREE.AudioLoader();
    audioLoader.load('sounds/presentation.mp3', function (buffer) {
        global_sound.setBuffer(buffer);
        global_sound.setLoop(true);
        global_sound.setVolume(0.5);
        global_sound.play();
    });

    //

    getVideo();

    var container = document.getElementById('container');

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

    messages = setTexts();
    texts = [messages.length];

    //

    for (let i = 0; i < messages.length; i++) {
        var loader = new THREE.FontLoader();
        loader.load('fonts/optimer_regular.typeface.json', function (font) {

            var xMid;
            var color = 0x000000;

            var matLite = new THREE.MeshBasicMaterial({
                color: color,
                transparent: true,
                opacity: 0.7,
                side: THREE.DoubleSide
            });

            var shapes = font.generateShapes(messages[i], 100);
            var geometry = new THREE.ShapeBufferGeometry(shapes);

            geometry.computeBoundingBox();
            xMid = - 0.5 * (geometry.boundingBox.max.x - geometry.boundingBox.min.x);
            geometry.translate(xMid, 0, 0);

            var text = new THREE.Mesh(geometry, matLite);
            text.position.z = INITIAL_TEXT_POSITION;
            text.scale.set(0.25, 0.25, 1);
            texts[i] = text;

        }); //end load function

    }

    document.body.appendChild(VRButton.createButton(renderer));
    renderer.vr.enabled = true;

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

    if (ENABLE_GLICTH == true)
        composer.render();

    if (COUNTER_GLITCH > 80) {

        disable();

    }

    if (ENABLE_GLICTH == false) {

        if (INDEX == 0 && texts[INDEX].position.z == INITIAL_TEXT_POSITION)
            scene.add(texts[INDEX]);

        texts[INDEX].position.z += 0.5;

        if (texts[INDEX].position.z == MAX_TEXT_POSITION) {

            scene.remove(texts[INDEX]);
            INDEX++;

            if (INDEX >= texts.length)
                INDEX = 0;

            console.log(INDEX);
            scene.add(texts[INDEX]);
            texts[INDEX].position.z = INITIAL_TEXT_POSITION;

        }

    }

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

    ENABLE_GLICTH = false;

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

function setTexts() {

    var messages = [];
    messages[0] = "HOME SERVICES";
    messages.push("La meilleure entreprise\n      de conciergerie");
    messages.push("En France et en Europe");
    messages.push("Nous comptons actuellement");
    messages.push("Plus de 4000 prestataires");
    messages.push("Prêt à intervenir chez vous");
    messages.push("Et ce dans les plus bref délais !");
    messages.push("Utiliser HOME SERVICES");
    messages.push("C'est aussi être accompagné\n            au quotidien");
    messages.push("Et profiter pleinement\n          de la vie");

    return messages;

}