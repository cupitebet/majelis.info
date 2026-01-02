document.addEventListener('DOMContentLoaded', () => {
  const mapEl = document.querySelector('.majelis-event-map');
  if (!mapEl || typeof L === 'undefined') {
    return;
  }

  const lat = parseFloat(mapEl.dataset.lat);
  const lng = parseFloat(mapEl.dataset.lng);

  if (Number.isNaN(lat) || Number.isNaN(lng)) {
    return;
  }

  const map = L.map(mapEl).setView([lat, lng], 14);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; OpenStreetMap contributors'
  }).addTo(map);

  L.marker([lat, lng]).addTo(map);
});
