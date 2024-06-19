# Some frameworkless stuff

## Demo

1.`docker compose up -d mysql` to start mysql;
2. Wait 15 seconds for mysql up and run `make setup` to apply the dump;
3. `docker compose up -d php` to start php container;
4. Open `http://localhost:9999` in your browser.


## Development

1.`docker compose up -d mysql` to start mysql;
2. Wait 15 seconds for mysql up and run `make setup` to apply the dump;
3. `make serve` to start local php;
4. Open `http://localhost:9999` in your browser.
