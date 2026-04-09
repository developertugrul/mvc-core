# Tailwind Setup

## Installed toolchain

- `tailwindcss`
- `postcss`
- `autoprefixer`
- `esbuild`
- `npm-run-all`

## Commands

- Dev watch:
  - `npm run dev`
- Production build:
  - `npm run build`

## Files

- `tailwind.config.js`
- `postcss.config.js`
- `resources/css/app.css`
- `resources/js/app.js`
- output: `public/assets/app.css`, `public/assets/app.js`

## Include in views

```html
<link rel="stylesheet" href="/assets/app.css">
<script src="/assets/app.js"></script>
```

## Notes for shared hosting

- Build assets before deploy if node is unavailable on server.
- Upload generated `public/assets/*`.
