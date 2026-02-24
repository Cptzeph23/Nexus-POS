\c nexuspos;

CREATE EXTENSION IF NOT EXISTS "pgcrypto";

CREATE EXTENSION IF NOT EXISTS "pg_trgm";

CREATE EXTENSION IF NOT EXISTS "pg_stat_statements";

SET timezone = 'UTC';

CREATE ROLE nexus_readonly;
GRANT CONNECT ON DATABASE nexuspos TO nexus_readonly;
GRANT USAGE ON SCHEMA public TO nexus_readonly;
ALTER DEFAULT PRIVILEGES IN SCHEMA public
    GRANT SELECT ON TABLES TO nexus_readonly;