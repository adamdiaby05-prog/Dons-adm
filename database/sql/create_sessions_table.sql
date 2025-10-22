-- Create sessions table for Laravel
CREATE TABLE IF NOT EXISTS sessions (
    id VARCHAR(255) PRIMARY KEY,
    user_id BIGINT NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    payload TEXT NOT NULL,
    last_activity INTEGER NOT NULL
);

-- Create index on user_id
CREATE INDEX IF NOT EXISTS sessions_user_id_index ON sessions (user_id);

-- Create index on last_activity
CREATE INDEX IF NOT EXISTS sessions_last_activity_index ON sessions (last_activity);
