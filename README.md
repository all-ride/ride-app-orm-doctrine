# Ride: Doctrine ORM

This module integrates the Doctrine ORM into the Ride framework.

## Configuration

    # application/config/parameters.json
    {
        "doctrine": {
            "dbal": {
                "connections": {
                    "default": {
                        "dsn": "mysql://user:pass@host/database"
                    }
                }
            },
            "orm": {
                "entity_managers": {
                    "default": {
                        "connection": "default"
                    }
                }
            }
        }
    }

## Available Commands

    doctrine convert-mapping [--filter] [--force] [--from-database] [--extend] [--num-spaces] [--namespace] [--em] <to-type> <dest-path>
    doctrine ensure-production-settings [--complete] [--em]
    doctrine generate entities [--filter] [--generate-annotations] [--generate-methods] [--regenerate-entities] [--update-entities] [--extend] [--num-spaces] [--no-backup] [--em] <dest-path>
    doctrine generate proxies [--filter] [--em] [<dest-path>]
    doctrine generate repositories [--filter] [--em] <dest-path>
    doctrine info [--em]
    doctrine run dql [--hydrate] [--first-result] [--max-result] [--depth] [--em] <dql>
    doctrine schema create [--dump-sql] [--em]
    doctrine schema drop [--dump-sql] [--force] [--full-database] [--em]
    doctrine schema update [--complete] [--dump-sql] [--force] [--em]
    doctrine schema validate [--skip-mapping] [--skip-sync] [--em]

To set the specific entity manager to use specify this using the --em flag.

