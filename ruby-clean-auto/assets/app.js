// import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');

// document.addEventListener('DOMContentLoaded', () => {
//   const cursor = document.getElementById('cursor');
//   const trail = document.getElementById('cursor-trail');

//   let mouseX = 0, mouseY = 0;
//   let trailX = 0, trailY = 0;
//   let lastX = 0, lastY = 0;
//   let angle = 0;

//   window.addEventListener('mousemove', e => {
//     mouseX = e.clientX;
//     mouseY = e.clientY;

//     trail.style.opacity = '1';
//   });

//   function animate() {
//     // Interpolation douce
//     trailX += (mouseX - trailX) * 0.15;
//     trailY += (mouseY - trailY) * 0.15;

//     // Calcul angle (en degrés) selon direction mouvement
//     const dx = mouseX - lastX;
//     const dy = mouseY - lastY;
//     angle = Math.atan2(dy, dx) * (180 / Math.PI);

//     lastX = mouseX;
//     lastY = mouseY;

//     trail.style.transform = `translate(${trailX}px, ${trailY}px) translate(-50%, -50%) rotate(${angle}deg)`;
//     cursor.style.transform = `translate(${mouseX}px, ${mouseY}px) translate(-50%, -50%)`;

//     requestAnimationFrame(animate);
//   }
//   animate();

//   window.addEventListener('mouseout', () => {
//     trail.style.opacity = '0';
//   });
// });