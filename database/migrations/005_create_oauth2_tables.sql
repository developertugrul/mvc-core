CREATE TABLE IF NOT EXISTS oauth_clients (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    client_id VARCHAR(80) NOT NULL UNIQUE,
    client_secret_hash CHAR(64) NOT NULL,
    name VARCHAR(120) NOT NULL,
    redirect_uri VARCHAR(255) NULL,
    grants VARCHAR(255) NOT NULL DEFAULT 'client_credentials,password,refresh_token',
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS oauth_access_tokens (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    token_hash CHAR(64) NOT NULL UNIQUE,
    client_id VARCHAR(80) NOT NULL,
    user_id INT UNSIGNED NULL,
    scope VARCHAR(255) NOT NULL DEFAULT '',
    expires_at DATETIME NOT NULL,
    revoked_at DATETIME NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_oauth_access_token_hash (token_hash),
    INDEX idx_oauth_access_client_id (client_id),
    CONSTRAINT fk_oauth_access_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS oauth_refresh_tokens (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    token_hash CHAR(64) NOT NULL UNIQUE,
    access_token_id INT UNSIGNED NOT NULL,
    expires_at DATETIME NOT NULL,
    revoked_at DATETIME NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_oauth_refresh_token_hash (token_hash),
    CONSTRAINT fk_oauth_refresh_access FOREIGN KEY (access_token_id) REFERENCES oauth_access_tokens(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
