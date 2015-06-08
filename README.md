# Ride: Doctrine ORM

This module integrates the Doctrine ORM into the Ride framework.

## Installation

    composer require ride/app-orm-doctrine:dev-master

## Configuration

```json
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
```

## Available Commands

```sh
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
```

To set the specific entity manager to use specify this using the --em flag.

## Usage

Define your entities inside the 'entity' directory inside your module:

```php
# src/ride/application/entity/MyEntity.php
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class MyEntity {

    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

}
```
    
Verify your entities are found using:

```sh
php application/cli.php doctrine info
```

Create your database schema using the CLI:

```sh
php application/cli.php doctrine schema create
```

Inject ManagerRegistry where you want to use Doctrine

```php
# src/ride/application/controller/IndexController.php
class IndexController {

    public function __construct(ManagerRegistry $registry) {
        $this->registry = $registry;
    }

    public function indexAction() {
        $em = $this->registry->getManager();

        $em->persist(new MyEntity());
        $em->flush();
    }

}
```
