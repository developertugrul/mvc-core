# Components System (Livewire-like)

## Goal

Provide server-driven interactive components without introducing a full SPA framework.

## Lifecycle

1. `mount(props)` on first render
2. `hydrate(state)` on action request
3. `call(action, payload)`
4. `render()` returns HTML

## Registering components

In bootstrap:

```php
$registry->register('counter', CounterComponent::class);
$registry->register('language-switcher', LanguageSwitcherComponent::class);
```

## Using components in views

```php
<?= component('counter', ['start' => 1]); ?>
```

## Action calls

Frontend posts signed payload to:

```http
POST /_components/counter/increment
```

Server returns:

- `html`
- new `payload`
- new `signature`

## Security model

- Payload signed with HMAC using `APP_KEY`
- Signature verified before hydration/action
- CSRF middleware protects endpoint
