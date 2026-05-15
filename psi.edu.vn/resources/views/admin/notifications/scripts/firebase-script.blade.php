<script>
				$(document).ready(function() {
								const firebaseConfig = {
												apiKey: "{{ config('firebase.api_key') }}",
												authDomain: "{{ config('firebase.auth_domain') }}",
												projectId: "{{ config('firebase.project_id') }}",
												storageBucket: "{{ config('firebase.storage_bucket') }}",
												messagingSenderId: "{{ config('firebase.messaging_sender_id') }}",
												appId: "{{ config('firebase.app_id') }}",
												measurementId: "{{ config('firebase.measurement_id') }}"
								};
								if (!firebase.apps.length) {
												firebase.initializeApp(firebaseConfig);
								}
								const messaging = firebase.messaging();
								navigator.serviceWorker.addEventListener('message', function(event) {
												console.log("Message from Service Worker:", event.data);
								});

								function registerServiceWorker() {
												if ("serviceWorker" in navigator) {
																console.log('Service worker is supported');

																navigator.serviceWorker.register(`${urlHome}/firebase-messaging-sw.js`)
																				.then(registration => {
																								if (registration.active) {
																												console.log('Service worker already active');
																												initMessaging(registration);
																								} else {
																												registration.addEventListener('updatefound', () => {
																																const newWorker = registration.installing;
																																newWorker.addEventListener('statechange', () => {
																																				if (newWorker.state === 'activated') {
																																								sendConfigToServiceWorker(newWorker);
																																								initMessaging(registration);
																																				}
																																});
																												});
																								}
																				})
																				.catch(err => console.error('Service worker registration failed:', err));
												}
								}

								function sendConfigToServiceWorker(worker) {
												worker.postMessage({
																type: 'SETUP',
																config: firebaseConfig,
																userId: getUserId()
												});
								}

								function initMessaging(registration) {
												console.log('Service worker registration successful:', registration);
												messaging.useServiceWorker(registration);
												requestNotificationPermission(registration);
												handleTokenRefresh(registration);
								}

								function requestNotificationPermission(registration) {
												Notification.requestPermission().then(permission => {
																if (permission === "granted") {
																				console.log("Notification permission granted.");
																				retrieveAndUpdateToken(registration);
																} else {
																				Swal.fire({
																								icon: 'error',
																								title: 'Lỗi',
																								text: 'Vui lòng bật thông báo để nhận thông tin!',
																				});
																}
												});
								}

								function retrieveAndUpdateToken(registration) {
												messaging.getToken({
																				vapidKey: "{{ config('firebase.vapid_key') }}",
																				serviceWorkerRegistration: registration
																})
																.then(token => {
																				if (token) {
																								console.log('Current token for client:', token);
																								$('input[name="device_token"]').val(token);
																								if (userIsLoggedIn()) {
																												updateDeviceToken(token);
																								} else {
																												console.log('User not logged in, skipping server update for device token.');
																								}
																				} else {
																								console.warn('No registration token available. Request permission to generate one.');
																				}
																})
																.catch(err => console.error('Error retrieving token:', err));
								}

								function updateDeviceToken(deviceToken) {
												const userId = getUserId();
												if (!userId) {
																console.log('No user logged in, cannot update token on server');
																return;
												}

												$.ajax({
																url: `${urlHome}/admin/notifications/update-device-token`,
																method: 'POST',
																headers: {
																				'X-CSRF-TOKEN': token
																},
																data: {
																				device_token: deviceToken
																},
																success: (data) => console.log(data.message),
																error: err => {
																				console.error('Error updating token on server:', err);
																}
												});
								}

								function userIsLoggedIn() {
												return !!getUserId();
								}

								function getUserId() {
												let userId = null;
												@if (auth('admin')->check())
																userId = @json(auth('admin')->user()->id);
												@endif
												return userId;
								}

								function handleTokenRefresh(registration) {
												messaging.onTokenRefresh(() => retrieveAndUpdateToken(registration));
								}

								registerServiceWorker();
				});
</script>
