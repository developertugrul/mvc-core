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
