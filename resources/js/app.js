async function postComponentAction(componentRoot, action) {
  const payload = componentRoot.dataset.payload;
  const signature = componentRoot.dataset.signature;
  const name = componentRoot.dataset.component;

  const formData = new FormData();
  formData.append("payload", payload || "");
  formData.append("signature", signature || "");
  formData.append("data", JSON.stringify({}));

  const response = await fetch(`/_components/${encodeURIComponent(name)}/${encodeURIComponent(action)}`, {
    method: "POST",
    body: formData,
    credentials: "same-origin"
  });

  if (!response.ok) return;
  const result = await response.json();
  componentRoot.innerHTML = result.html || componentRoot.innerHTML;
  componentRoot.dataset.payload = result.payload || componentRoot.dataset.payload;
  componentRoot.dataset.signature = result.signature || componentRoot.dataset.signature;
}

document.addEventListener("click", (event) => {
  const target = event.target;
  if (!(target instanceof HTMLElement)) return;
  const action = target.dataset.componentAction;
  if (!action) return;
  const root = target.closest("[data-component]");
  if (!(root instanceof HTMLElement)) return;
  postComponentAction(root, action);
});

function base64UrlToUint8Array(base64Url) {
  const padding = "=".repeat((4 - (base64Url.length % 4)) % 4);
  const base64 = (base64Url + padding).replace(/-/g, "+").replace(/_/g, "/");
  const raw = atob(base64);
  return Uint8Array.from([...raw].map((char) => char.charCodeAt(0)));
}

async function subscribeWebPush() {
  if (!("serviceWorker" in navigator) || !("PushManager" in window)) return;
  const vapid = document.documentElement.getAttribute("data-webpush-public-key");
  if (!vapid) return;

  const registration = await navigator.serviceWorker.register("/sw.js");
  const permission = await Notification.requestPermission();
  if (permission !== "granted") return;

  const subscription = await registration.pushManager.subscribe({
    userVisibleOnly: true,
    applicationServerKey: base64UrlToUint8Array(vapid),
  });

  await fetch("/notifications/web-push/subscribe", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "X-CSRF-TOKEN": document.documentElement.getAttribute("data-csrf-token") || ""
    },
    body: JSON.stringify(subscription),
    credentials: "same-origin"
  });
}

document.addEventListener("click", (event) => {
  const target = event.target;
  if (!(target instanceof HTMLElement)) return;
  if (target.id === "enable-web-push") {
    subscribeWebPush();
  }
});
