// Simple rotating globe using Three.js
// Import Three.js library
const THREE = window.THREE

function initGlobe() {
  const globeContainer = document.getElementById("globe")
  if (!globeContainer || typeof THREE === "undefined") return

  const scene = new THREE.Scene()
  const camera = new THREE.PerspectiveCamera(50, globeContainer.clientWidth / globeContainer.clientHeight, 0.1, 1000)
  const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true })

  renderer.setSize(globeContainer.clientWidth, globeContainer.clientHeight)
  renderer.setClearColor(0x000000, 0)
  globeContainer.appendChild(renderer.domElement)

  const geometry = new THREE.SphereGeometry(1, 32, 32)
  const material = new THREE.MeshBasicMaterial({
    color: 0xffdb70,
    wireframe: true,
    transparent: true,
    opacity: 0.8,
  })
  const globe = new THREE.Mesh(geometry, material)
  scene.add(globe)

  camera.position.z = 3

  function animate() {
    requestAnimationFrame(animate)
    globe.rotation.x += 0.005
    globe.rotation.y += 0.01
    renderer.render(scene, camera)
  }
  animate()

  // Handle window resize
  window.addEventListener("resize", () => {
    if (globeContainer.clientWidth > 0 && globeContainer.clientHeight > 0) {
      camera.aspect = globeContainer.clientWidth / globeContainer.clientHeight
      camera.updateProjectionMatrix()
      renderer.setSize(globeContainer.clientWidth, globeContainer.clientHeight)
    }
  })
}

// Initialize globe when DOM is loaded
document.addEventListener("DOMContentLoaded", initGlobe)
