self.addEventListener("push", function (event) {
  const data = event.data ? event.data.json() : { title: "Notification", body: "" };
  event.waitUntil(
    self.registration.showNotification(data.title || "Notification", {
      body: data.body || "",
      icon: "/favicon.ico"
    })
  );
});

self.addEventListener("notificationclick", function (event) {
  event.notification.close();
  event.waitUntil(clients.openWindow("/"));
});
