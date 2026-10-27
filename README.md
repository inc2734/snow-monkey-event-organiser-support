# Snow Monkey Event Organiser Integrator

With this plugin, Snow Monkey can use Event Organiser plugin.

## Build

Requires Node.js 24.22.1 or later and npm 11.18.0 or later. Volta pins Node.js to 24.22.1.

```bash
$ npm ci
$ composer install
```

## Tests

With Docker running, `npm test` runs PHP lint and integration tests with Snow Monkey and Event Organiser in the separate `.wp-env.tests.json` environment (port 8889). The test environment stops after each check, including failures through `npm test` and the `test:lint:php` / `test:unit:php` scripts.

`npm run zip` creates the release archive. Development uses `.wp-env.json` (port 8888); `npm run destroy` removes both environments.
