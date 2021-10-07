<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>My first three.js app</title>
		<style>
            html, body {
                margin: 0;
                height: 100%;
            }
            #canvas {
                width: 1000px;
                height: 720px;
                display: block;
            }
        </style>
	</head>
	<body>
    <div>
        <input id="file-input" type="file" (change)="mychange($event)" />
    </div>  
        <canvas id="canvas"></canvas>
		{{-- <script src="js/three.min.js"></script> --}}
		<script type="module">
            import * as THREE from 'https://unpkg.com/three/build/three.module.js';
            import { GLTFLoader } from '/js/three/examples/jsm/loaders/GLTFLoader.js';
            import { OrbitControls } from '/js/three/examples/jsm/controls/OrbitControls.js';
            // import { GLTFLoader } from 'https://threejsfundamentals.org/threejs/resources/threejs/r122/examples/jsm/loaders/GLTFLoader.js';
            const gltfUploader = document.getElementById('file-input');

            gltfUploader.addEventListener('change', async (e) => {

                let file = e.target.files[0];
                console.log(file);
                console.log(e.target)
                const canvas = document.querySelector('#canvas');
                const renderer = new THREE.WebGLRenderer({canvas});

                const fov = 45;
                const aspect = 2;  // the canvas default
                const near = 0.1;
                const far = 100;
                const camera = new THREE.PerspectiveCamera(fov, aspect, near, far);
                camera.position.set(0, 10, 20);

                const controls = new OrbitControls(camera, canvas);
                controls.target.set(0, 5, 0);
                controls.update();

                const scene = new THREE.Scene();
                scene.background = new THREE.Color('black');

                {
                    const planeSize = 40;

                    const loader = new THREE.TextureLoader();
                    const texture = loader.load('https://threejsfundamentals.org/threejs/resources/images/checker.png');
                    texture.wrapS = THREE.RepeatWrapping;
                    texture.wrapT = THREE.RepeatWrapping;
                    texture.magFilter = THREE.NearestFilter;
                    const repeats = planeSize / 2;
                    texture.repeat.set(repeats, repeats);

                    const planeGeo = new THREE.PlaneBufferGeometry(planeSize, planeSize);
                    const planeMat = new THREE.MeshPhongMaterial({
                    map: texture,
                    side: THREE.DoubleSide,
                    });
                    const mesh = new THREE.Mesh(planeGeo, planeMat);
                    mesh.rotation.x = Math.PI * -.5;
                    scene.add(mesh);
                }

                {
                    const skyColor = 0xB1E1FF;  // light blue
                    const groundColor = 0xB97A20;  // brownish orange
                    const intensity = 1;
                    const light = new THREE.HemisphereLight(skyColor, groundColor, intensity);
                    scene.add(light);
                }

                {
                    const color = 0xFFFFFF;
                    const intensity = 1;
                    const light = new THREE.DirectionalLight(color, intensity);
                    light.position.set(5, 10, 2);
                    scene.add(light);
                    scene.add(light.target);
                }

                function frameArea(sizeToFitOnScreen, boxSize, boxCenter, camera) {
                    const halfSizeToFitOnScreen = sizeToFitOnScreen * 0.5;
                    const halfFovY = THREE.MathUtils.degToRad(camera.fov * .5);
                    const distance = halfSizeToFitOnScreen / Math.tan(halfFovY);
                    const direction = (new THREE.Vector3())
                        .subVectors(camera.position, boxCenter)
                        .multiply(new THREE.Vector3(1, 0, 1))
                        .normalize();

                    camera.position.copy(direction.multiplyScalar(distance).add(boxCenter));
                    camera.near = boxSize / 100;
                    camera.far = boxSize * 100;
                    camera.updateProjectionMatrix();
                    camera.lookAt(boxCenter.x, boxCenter.y, boxCenter.z);
                }

                {
                    const reader = new FileReader();
                    reader.addEventListener( 'load', function ( event ) {

                        const contents = event.target.result;

                        const loader = new GLTFLoader();
                        loader.parse( contents, '', function ( gltf ) {

                            const root = gltf.scene;
                            scene.add(root);
                            const box = new THREE.Box3().setFromObject(root);
                            const boxSize = box.getSize(new THREE.Vector3()).length();
                            const boxCenter = box.getCenter(new THREE.Vector3());
                            frameArea(boxSize * 0.5, boxSize, boxCenter, camera);
                            controls.maxDistance = boxSize * 10;
                            controls.target.copy(boxCenter);
                            controls.update();
                            console.log( root );

                        } );

                    }, false );

                reader.readAsArrayBuffer( file );
                //   const gltfLoader = new GLTFLoader();
                //  gltfLoader.parse( gltfText.target.result, '', function( gltf ){
                //     const root = gltf.scene;
                //     scene.add(root);
                //     const box = new THREE.Box3().setFromObject(root);
                //     const boxSize = box.getSize(new THREE.Vector3()).length();
                //     const boxCenter = box.getCenter(new THREE.Vector3());
                //     frameArea(boxSize * 0.5, boxSize, boxCenter, camera);
                //     controls.maxDistance = boxSize * 10;
                //     controls.target.copy(boxCenter);
                //     controls.update();
                //   });
                }

                function resizeRendererToDisplaySize(renderer) {
                    const canvas = renderer.domElement;
                    const width = canvas.clientWidth;
                    const height = canvas.clientHeight;
                    const needResize = canvas.width !== width || canvas.height !== height;
                    if (needResize) {
                        renderer.setSize(width, height, false);
                    }
                    return needResize;
                }

                function render() {
                    if (resizeRendererToDisplaySize(renderer)) {
                        const canvas = renderer.domElement;
                        camera.aspect = canvas.clientWidth / canvas.clientHeight;
                        camera.updateProjectionMatrix();
                    }

                    renderer.render(scene, camera);

                    requestAnimationFrame(render);
                }

                requestAnimationFrame(render);
    
        });
		</script>
	</body>
</html>