import "./bootstrap";

import Alpine from "alpinejs";
import * as lucide from "lucide";

window.Alpine = Alpine;
window.lucide = lucide;

Alpine.start();

// Initialize Lucide
document.addEventListener("DOMContentLoaded", () => {
    lucide.createIcons();
});
