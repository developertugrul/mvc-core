# OAuth2 Altyapisi

Bu starter, OAuth2 benzeri bearer token altyapisini asagidaki endpointlerle sunar:

- `POST /oauth/token`
- `GET /api/me` (Bearer token gerekir)

## Desteklenen grant_type

- `client_credentials`
- `password`
- `refresh_token`

## Token Endpoint Ornekleri

### client_credentials

```bash
curl -X POST http://localhost/oauth/token \
  -d "grant_type=client_credentials" \
  -d "client_id=CLIENT_ID" \
  -d "client_secret=CLIENT_SECRET" \
  -d "scope=read"
```

### password

```bash
curl -X POST http://localhost/oauth/token \
  -d "grant_type=password" \
  -d "client_id=CLIENT_ID" \
  -d "client_secret=CLIENT_SECRET" \
  -d "username=user@example.com" \
  -d "password=secret" \
  -d "scope=read write"
```

### refresh_token

```bash
curl -X POST http://localhost/oauth/token \
  -d "grant_type=refresh_token" \
  -d "client_id=CLIENT_ID" \
  -d "client_secret=CLIENT_SECRET" \
  -d "refresh_token=REFRESH_TOKEN"
```

## Korumali API Ornegi

```bash
curl -H "Authorization: Bearer ACCESS_TOKEN" http://localhost/api/me
```

## Admin OAuth Client Yonetimi

Web panel endpointleri:

- `GET /admin/oauth-clients`
- `POST /admin/oauth-clients`
- `POST /admin/oauth-clients/{clientId}/rotate`
- `POST /admin/oauth-clients/{clientId}/revoke`

Ekran, yeni olusturulan veya rotate edilen `client_secret` degerini sadece bir kez gosterir.

## Veritabani Tablolari

- `oauth_clients`
- `oauth_access_tokens`
- `oauth_refresh_tokens`

## Konfig

`.env`:

```env
OAUTH_ACCESS_TOKEN_TTL=3600
OAUTH_REFRESH_TOKEN_TTL=2592000
```

## Notlar

- Access/refresh tokenlar veritabaninda hashlenmis saklanir.
- Refresh token kullanildiginda onceki access/refresh token ciftleri revoke edilir.
