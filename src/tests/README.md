# PHP Codeception REST API Testing

1. install api test suite
    ```shell
    vendor/bin/codecept generate:suite api
    ```
    - edit tests/api.suite.yml, add REST module
        ```yaml
        actor: ApiTester
        modules:
            enabled:
                - REST:
                    url: http://localhost:3000/index-test.php/
                    depends: Yii2
                    part: JSON
                    configFile: 'config/test.php'
                - \Helper\Api

            config:
                - Yii2
        ```
2. enable REST module for testing RESTful API
    ```shell
    docker compose exec app composer require --dev codeception/module-rest --ignore-platform-reqs
    ```
3. run `build` command after add/remove module
    ```shell
    vendor/bin/codecept build
    ```
4. create Cest(class-like structure) test case
    ```shell
    vendor/bin/codecept generate:cest api {Name}
    ```
5. run test
    ```shell
    docker compose exec app vendor/bin/codecept run api
    ```
