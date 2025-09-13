# Project Overview

This is a PHP project that demonstrates how to use the Guzzle HTTP client to make asynchronous HTTP requests. The project includes a custom logging middleware that logs requests and responses to the console with timestamps in ISO 8601 format (JST with milliseconds).

The main components of the project are:

*   **`index.php`**: The main entry point of the application. It creates an `HttpClient`, makes three asynchronous GET requests, and then prints the response bodies.
*   **`src/HttpClient.php`**: A singleton class that creates a Guzzle HTTP client with a custom logging middleware.
*   **`src/LogMiddleware.php`**: A Guzzle middleware that logs requests and responses.
*   **`src/Logger.php`**: A simple class that logs messages to the console, now with ISO 8601 formatted timestamps (JST with milliseconds).

## Building and Running

To run this project, you first need to install the dependencies using Composer:

```bash
composer install
```

Once the dependencies are installed, you can run the project using the following command:

```bash
php index.php
```

This will execute the `index.php` file, which will make three asynchronous HTTP requests to `http://httpbin.org` and print the response bodies to the console. You will also see the log messages from the logging middleware, now with detailed timestamps.

## Development Conventions

*   The project follows the PSR-4 autoloading standard.
*   The application's source code is located in the `src` directory under the `App` namespace.
*   Log messages include timestamps in ISO 8601 format (JST with milliseconds).

## Troubleshooting Gemini CLI Interactions

### Multiline Git Commit Messages

When interacting with the Gemini CLI, attempting to commit with multiline messages directly via `git commit -m "..."` may result in a "Command substitution using $(), <(), or >() is not allowed for security reasons" error. This is due to security restrictions in the shell command execution environment.

**Workaround:**
If a detailed multiline commit message is required, commit with a concise single-line message first. Afterward, you can manually amend the commit message using `git commit --amend` in your terminal to add the full details.
