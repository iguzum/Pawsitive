// :: START DRAGGABLE MAP MARKER
const uddCoordinates = [16.05082, 120.34084];

var map = L.map("map", {
    minZoom: 15,
    maxZoom: 19,
}).setView(uddCoordinates, 19);

L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    attribution: "OpenStreetMap",
    maxZoom: 19,
}).addTo(map);

const marker = L.marker(uddCoordinates, {
    draggable: true,
}).addTo(map);

marker.bindPopup("<b>Pawsitive Dagupan</b><br>Dagupan City, Pangasinan").openPopup();

document.getElementById("recenterBtn").addEventListener("click", function () {
    map.flyTo(marker.getLatLng(), 19, {
        duration: 1.0,
    });
});
// :: END DRAGGABLE MAP MARKER

const btns = document.querySelectorAll(".topic-btn");
const topicInput = document.getElementById("topicInput");
btns.forEach((btn) => {
    btn.addEventListener("click", () => {
        btns.forEach((b) => {
            b.classList.remove("bg-orange-500", "text-white", "border-orange-500");
            b.classList.add("bg-white");
        });
        btn.classList.add("bg-orange-500", "text-white", "border-orange-500");
        btn.classList.remove("bg-white");
        topicInput.value = btn.innerText;
    });
});
