const smallCircle = document.getElementById('small-circle');
const bigCircle = document.getElementById('big-circle');

let mouseX = 0, mouseY = 0;
let bigX = 0, bigY = 0;

document.addEventListener('mousemove', e => {
  mouseX = e.clientX;
  mouseY = e.clientY;
});

function animate() {
  // Position immédiate du petit cercle (curseur)
  smallCircle.setAttribute('cx', mouseX);
  smallCircle.setAttribute('cy', mouseY);

  // Le grand cercle suit avec un léger décalage (lissage)
  bigX += (mouseX - bigX) * 0.1;
  bigY += (mouseY - bigY) * 0.1;

  bigCircle.setAttribute('cx', bigX);
  bigCircle.setAttribute('cy', bigY);

  requestAnimationFrame(animate);
}

animate();