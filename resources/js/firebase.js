// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
import { getAnalytics } from "firebase/analytics";
import { getMessaging, getToken, onMessage } from "firebase/messaging";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
    apiKey: import.meta.env.VITE_FIREBASE_API_KEY,
    authDomain: import.meta.env.VITE_FIREBASE_AUTH_DOMAIN,
    projectId: import.meta.env.VITE_FIREBASE_PROJECT_ID,
    storageBucket: import.meta.env.VITE_FIREBASE_STORAGE_BUCKET,
    messagingSenderId: import.meta.env.VITE_FIREBASE_MESSAGING_SENDER_ID,
    appId: import.meta.env.VITE_FIREBASE_APP_ID,
    measurementId: import.meta.env.VITE_FIREBASE_MEASUREMENT_ID,
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const messaging = getMessaging(app);

// Notif permission and token retrieval
export async function initFCM() {
    try {
        const permission = await Notification.requestPermission();

        if (permission !== "granted") {
            console.error("Notification permission not granted");
            return;
        }

        const fcmToken = await getToken(messaging, {
            vapidKey: import.meta.env.VITE_FIREBASE_VAPID_KEY,
        });

        const csrfToken = document.querySelector(
            'meta[name="csrf_token"]',
        ).content;

        const response = await fetch("/users/save-fcm-token", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
            body: JSON.stringify({ fcm_token: fcmToken }),
        });
        const data = await response.json();
        console.log("Respon firebase:", data.message);
    } catch (error) {
        console.error(error);
    }
}

// Handle foreground messages
export const listenFCM = () => {
    onMessage(messaging, (payload) => {
        new Notification(payload.data?.title || payload.notification?.title, {
            body: payload.data?.body || payload.notification?.body,
            icon: payload.data?.image || payload.notification?.image,
        });
    });
};
