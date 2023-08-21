# Laravel ADR Project

This project is built using the **Action-Domain-Responder (ADR)** architectural pattern. ADR is a pattern that helps you
organize your codebase into separate layers for handling user interactions, domain logic, and generating responses.

## Project Overview

In this app, the authentication system is implemented in traditional way to show difference with ADR pattern.

This project follows the ADR pattern, dividing the codebase into three main layers:

1. **Action Layer**: Responsible for handling user input, invoking domain logic, and passing data to the responder.
   Actions typically correspond to the routes in your application.

2. **Domain Layer**: Contains the core business logic and application rules. The domain layer operates on data
   structures (DTOs) and services that encapsulate the domain-specific functionality.

3. **Responder Layer**: Generates the appropriate response (HTML, JSON, etc.) based on the result of the domain logic.
   Responders handle transforming domain data into a format suitable for the user.

## Traditional Pattern

In traditional ways, here are details:

* We have controllers to serve routes
* We are serving the whole application and routes from app directory
* We can not separate concerns of domains, everything are in controllers, and they are responsible
* Controllers are responsible for handling requests
* Controllers are responsible for serving the response

## ADR Pattern

In ADR ways, here are details:

This project embodies the Action-Domain-Responder (ADR) architectural pattern. ADR emphasizes separation and isolation
of packages, guiding the flow from input to output through distinct layers for efficient, focused development.

Each layer is having a structure for filling names like:

`(GET|POST|DELETE|COMMAND|...){ActionName}(Action|Service|Responder)`

Example:

- `GetURLShortenAction`
- `GetURLShortenService`
- `GetURLShortenResponder`

So, from maintaining perspective, It's easily to debug and maintain code with decoupled flow.

## Key Principles

### Separation of Concerns

- **Isolated Packages**: We've meticulously separated packages to handle requests from input to output. Each package
  serves a specific role in the system, maintaining clarity and modularity.
- **Better Test Coverage**: By isolating layers, you can achieve better test coverage across different scenarios. Tests
  can be crafted to focus on the specific behavior of each component, improving the overall robustness of your
  application.
- **Reduced Coupling**: ADR minimizes coupling between layers, reducing the likelihood of unintended side effects. This
  separation enhances test stability and decreases the chances of tests breaking due to unrelated changes.

### Focused Invocations

- **Action Layer**: Actions are designed to invoke input, passing it to relevant domains for specialized logic. Actions
  provide a clean entry point for handling user interactions.

- **Domain Layer**: The core business logic resides here. Complex processing and rules are encapsulated within domains,
  ensuring a high level of organization.

- **Responder Layer**: Responders customize output based on each action's needs. This approach allows us to tailor
  responses without affecting domain logic.

### Efficient Communication

- **Layer Isolation**: In our architecture, packages communicate primarily through the domain layer. This separation
  ensures well-defined interactions and avoids unintended coupling.

- **Single Responsibility**: Actions and responders adhere to the single responsibility principle, contributing to
  maintainable, clear codebases.

### Simplicity and Flexibility

- **KISS Pattern**: Our system adheres to the "Keep It Simple, Stupid" principle. By following the ADR pattern, we
  achieve isolation and flexibility, enabling different ways of serving the layers, much like an isolated network.

- **Dependency Optimization**: Unlike traditional methods with controller methods and numerous dependencies, our pattern
  ensures only necessary dependencies are present during a request, enhancing efficiency and code quality.

## Use Cases and Scope

- **APIs Preferred**: ADR is particularly effective for API development, although it is versatile and can work
  seamlessly in various route contexts.

# Laravel Project Makefile

This Makefile simplifies common commands for managing your Laravel project.
It provides a convenient way to execute various tasks efficiently.

## Usage

Navigate to your project's root directory in the terminal and use the following commands:

- Set .env file inside `src` folder
- Run `make init` to install, build and run the project
- Navigate to URL that set in .env

### Initialize the Project

```bash
make init
```

- Starts Docker services in detached mode
- Installs project dependencies (Composer & Yarn)
- Builds the project
- Generates the application key
- Runs migrations

### Run the Project

```bash
make run
```

Starts Docker services (containers) for your application and its dependencies.

### Run the Project in Detached Mode

```bash
make run-d
```

Starts Docker services in detached mode, allowing you to continue using the terminal

### Stop the Project

```bash
make stop
```

Stops and removes Docker services (containers).

### Execute a Bash Shell in the Frontend Container

```bash
make exec
```

- Opens a bash shell inside the frontend container as the www-data user.

### Build Frontend Assets

```bash
make build
```

Executes the yarn build command to build the frontend assets.

### Watch Frontend Assets

```bash
make watch
```

Executes the yarn dev command to watch frontend assets during development.

### Run Tests

```bash
make test
```

Executes the php artisan test command inside the frontend container.

In this application, we covered two layers of creating new shorten url (PostURLShortenAction and PostURLShortenService)
and retrieving (GetURLShortenAction and GetURLShortenService) since these endpoints are important
for assessment. Other layers are same.

### Install Dependencies

```bash
make install
```

Installs Composer and Yarn dependencies inside the frontend container.

### Clear Cache and Logs

```bash
make clear
```

Clears the application cache, logs, and removes public build files.

### Flush All Dependencies and Clear Cache

```bash
make flush
```

Cleans up by clearing cache, removing vendor and node_modules directories.