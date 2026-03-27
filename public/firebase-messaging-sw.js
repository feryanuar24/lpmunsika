importScripts(
    "https://www.gstatic.com/firebasejs/10.7.1/firebase-app-compat.js",
);
importScripts(
    "https://www.gstatic.com/firebasejs/10.7.1/firebase-messaging-compat.js",
);

firebase.initializeApp({
    apiKey: "AIzaSyBuN0rGm0SnhYVYp1vh7FXZjqLt6rnoy44",
    authDomain: "lpmunsika-f1568.firebaseapp.com",
    projectId: "lpmunsika-f1568",
    messagingSenderId: "948540814495",
    appId: "1:948540814495:web:7f1b3e3bd670fde5f09eaa",
});

const messaging = firebase.messaging();

// Handle background messages
self.addEventListener("push", function (event) {
    if (!event.data) return;

    const payload = event.data.json();
    const data = payload?.data ?? payload;

    event.waitUntil(
        self.registration.showNotification(data?.title || "Notifikasi", {
            body: data?.body || "",
            icon: data.image,
            image: data.image,
            data: {
                url: data?.url || "/",
            },
        }),
    );
});

// Handle notification click
self.addEventListener("notificationclick", function (event) {
    event.notification.close();

    const url = event.notification.data?.url || "/";

    event.waitUntil(clients.openWindow(url));
});
