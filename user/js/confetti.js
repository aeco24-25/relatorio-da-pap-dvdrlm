// js/confetti.js
function fireConfetti() {
    confetti({
      particleCount: 150,
      spread: 70,
      origin: { y: 0.6 },
      colors: ['#ff0000', '#00ff00', '#0000ff', '#ffff00', '#ff00ff'],
      shapes: ['circle', 'square']
    });
  }
  
  // Exporte a função se for um módulo
  if (typeof module !== 'undefined' && module.exports) {
    module.exports = { fireConfetti };
}