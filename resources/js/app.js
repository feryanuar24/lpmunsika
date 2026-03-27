import "./bootstrap";
import Alpine from "alpinejs";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import Splide from "@splidejs/splide";
import "@splidejs/splide/css";
import Swal from "sweetalert2";
import { initFCM, listenFCM } from "./firebase";

// Start Alpine.js
window.Alpine = Alpine;
Alpine.start();

// Make CKEditor available globally
window.ClassicEditor = ClassicEditor;

// Make Splide available globally
window.Splide = Splide;

// Make SweetAlert2 available globally
window.Swal = Swal;

// Metronic Core JavaScript functionality
document.addEventListener("DOMContentLoaded", function () {
    // Initialize drawer functionality
    initDrawers();

    // Initialize menu functionality
    initMenus();

    // Initialize sticky headers
    initStickyHeaders();

    // Initialize modal functionality
    initModals();

    // Initialize Firebase Cloud Messaging
    initFCM();
    listenFCM();
});

// Drawer functionality
function initDrawers() {
    const drawers = document.querySelectorAll("[data-kt-drawer]");

    drawers.forEach((drawer) => {
        const toggles = document.querySelectorAll(
            `[data-kt-drawer-toggle="#${drawer.id}"]`,
        );

        toggles.forEach((toggle) => {
            toggle.addEventListener("click", function (e) {
                e.preventDefault();
                drawer.classList.toggle("hidden");
                drawer.classList.toggle("block");
            });
        });
    });
}

// Menu functionality
function initMenus() {
    const menus = document.querySelectorAll('[data-kt-menu="true"]');

    menus.forEach((menu) => {
        const items = menu.querySelectorAll(
            '[data-kt-menu-item-toggle="dropdown"]',
        );

        items.forEach((item) => {
            const trigger = item.querySelector(
                '[data-kt-menu-item-trigger="click"], [data-kt-menu-item-trigger="click|lg:hover"]',
            );
            const dropdown = item.querySelector(".kt-menu-dropdown");

            if (trigger && dropdown) {
                trigger.addEventListener("click", function (e) {
                    e.preventDefault();
                    dropdown.classList.toggle("hidden");
                });
            }
        });
    });
}

// Sticky header functionality
function initStickyHeaders() {
    const stickyElements = document.querySelectorAll('[data-kt-sticky="true"]');

    stickyElements.forEach((element) => {
        const stickyClass =
            element.getAttribute("data-kt-sticky-class") || "kt-sticky";
        const offset =
            parseInt(element.getAttribute("data-kt-sticky-offset")) || 0;

        window.addEventListener("scroll", function () {
            if (window.scrollY > offset) {
                element.classList.add(...stickyClass.split(" "));
            } else {
                element.classList.remove(...stickyClass.split(" "));
            }
        });
    });
}

// Modal functionality
function initModals() {
    const modalToggles = document.querySelectorAll("[data-kt-modal-toggle]");

    modalToggles.forEach((toggle) => {
        toggle.addEventListener("click", function (e) {
            e.preventDefault();
            const modalId = this.getAttribute("data-kt-modal-toggle");
            const modal = document.querySelector(modalId);

            if (modal) {
                modal.classList.toggle("hidden");
                modal.classList.toggle("flex");
            }
        });
    });
}

// Close modals when clicking outside
document.addEventListener("click", function (e) {
    const modals = document.querySelectorAll(".kt-modal");

    modals.forEach((modal) => {
        if (e.target === modal) {
            modal.classList.add("hidden");
            modal.classList.remove("flex");
        }
    });
});

// Export functions for use in other modules
window.MetronicCore = {
    initDrawers,
    initMenus,
    initStickyHeaders,
    initModals,
};
