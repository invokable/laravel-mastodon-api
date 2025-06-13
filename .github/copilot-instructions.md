# Laravel Mastodon API Package - Onboarding Guide

## Overview

The `revolution/laravel-mastodon-api` package is a comprehensive Laravel library that provides seamless integration with the Mastodon social media platform's API. It serves Laravel developers who need to build applications that interact with Mastodon instances for social media functionality.

**Target Users:**
- Laravel developers building social media applications
- Developers creating Mastodon client applications
- Teams building content management systems with Mastodon integration
- Developers working on notification systems that post to Mastodon

**Key Capabilities:**
- Complete Mastodon API coverage (statuses, accounts, applications, streaming)
- OAuth application registration and management
- Real-time streaming API support for live updates
- Laravel-native integration with facades, service providers, and traits
- Comprehensive testing infrastructure with mocked HTTP responses
- Production-ready with proper error handling and configuration management

The package follows Laravel conventions and integrates with the broader Revolution ecosystem, including specialized packages for Mastodon notifications (`revolution/laravel-notification-mastodon`) and OAuth authentication (`revolution/socialite-mastodon`).

## Project Organization

### Core Systems

**1. Client Architecture (`src/MastodonClient.php`)**
- Central HTTP client implementing the `Factory` contract
- Manages API configuration (domain, token, versioning)
- Provides both high-level semantic methods and low-level HTTP methods
- Uses Laravel's HTTP facade with optional Guzzle client injection

**2. Laravel Integration Layer**
- `MastodonServiceProvider.php`: Registers services in Laravel's container
- `Facades/Mastodon.php`: Static interface for convenient API access
- `Traits/Mastodon.php`: Model integration trait for direct API access

**3. API Operation Modules (Concerns Pattern)**
- `Concerns/Statuses.php`: Status posting, retrieval, and timeline operations
- `Concerns/Apps.php`: OAuth application registration
- `Concerns/Accounts.php`: User account operations and credential verification
- `Concerns/Streaming.php`: Real-time event streaming with Server-Sent Events

**4. Contract Definition (`Contracts/Factory.php`)**
- Interface defining all public API methods
- Ensures consistent implementation across the package
- Supports dependency injection and testing

### Directory Structure

```
src/
├── MastodonClient.php          # Core HTTP client implementation
├── Contracts/
│   └── Factory.php             # Main interface definition
├── Providers/
│   └── MastodonServiceProvider.php  # Laravel service registration
├── Facades/
│   └── Mastodon.php            # Static API interface
├── Traits/
│   └── Mastodon.php            # Model integration trait
└── Concerns/                   # Modular API operations
    ├── Statuses.php
    ├── Apps.php
    ├── Accounts.php
    └── Streaming.php

tests/
├── TestCase.php                # Base test class with Orchestra Testbench
└── MastodonTest.php           # Comprehensive API client tests

docs/
├── macro.md                    # Facade extension documentation
└── trait.md                    # Model integration examples

streaming_example.php           # Example script for streaming API usage

.github/workflows/
├── test.yml                    # PHPUnit testing and coverage
├── lint.yml                    # Code style enforcement with Pint
└── copilot-setup-steps.yml     # Copilot agent setup configuration
```

### Key Configuration Files

- `composer.json`: Package definition, dependencies, and Laravel auto-discovery
- `phpunit.xml`: Test configuration with coverage reporting
- `pint.json`: Code style rules (Laravel preset with custom overrides)
- `.editorconfig`: Code formatting rules for consistent style across editors
- `.gitattributes`: Export management for clean distribution archives

### Development Workflow

**Testing Infrastructure:**
- Orchestra Testbench for isolated Laravel package testing
- MockHandler integration for HTTP response simulation
- Comprehensive test coverage with Clover XML reporting and qlty coverage integration
- GitHub Actions CI/CD with PHP 8.4 testing and dependency caching

**Code Quality:**
- Laravel Pint for automated code style enforcement
- GitHub Actions linting on `develop` and `main` branches
- PSR-4 autoloading with `Revolution\Mastodon\` namespace

## Glossary of Codebase-Specific Terms

**MastodonClient** - Core HTTP client class implementing Factory contract. Located in `src/MastodonClient.php`. Manages API configuration and provides both semantic and generic HTTP methods.

**Factory** - Main interface defining all public API methods. Located in `src/Contracts/Factory.php`. Ensures consistent implementation and supports dependency injection.

**Concerns** - Directory containing trait-based API operation modules. Located in `src/Concerns/`. Implements modular design pattern for different Mastodon API endpoints.

**MastodonServiceProvider** - Laravel service provider for package registration. Located in `src/Providers/MastodonServiceProvider.php`. Implements deferred loading for performance.

**Mastodon Facade** - Laravel facade providing static API interface. Located in `src/Facades/Mastodon.php`. Resolves to Factory contract instance.

**createApp** - Method for OAuth application registration. Available in Apps trait and Factory contract. Returns array with client_id and client_secret.

**verifyCredentials** - Method for authenticating API tokens. Located in `src/Concerns/Accounts.php`. Returns authenticated user account information.

**statuses** - Method for retrieving account status timeline. Located in `src/Concerns/Statuses.php`. Supports pagination with limit and since_id parameters.

**createStatus** - Method for posting new statuses to Mastodon. Located in `src/Concerns/Statuses.php`. Accepts status text and optional parameters array (Factory contract defines `array $options = []`).

**streaming** - Method for real-time event consumption. Located in `src/Concerns/Streaming.php`. Uses direct Guzzle client with Server-Sent Events and callback pattern for persistent connections.

**domain** - Configuration method for setting Mastodon instance URL. Returns static for method chaining. Required before API calls.

**token** - Configuration method for setting OAuth access token. Marked with SensitiveParameter attribute. Required for authenticated endpoints.

**apiVersion** - Configuration method for API versioning. Defaults to 'v1'. Allows targeting different Mastodon API versions.

**apiBase** - Configuration method for API base path. Defaults to '/api/'. Supports custom Mastodon installations.

**apiEndpoint** - Method returning full constructed API URL. Combines domain, apiBase, and apiVersion. Used internally for request building.

**getResponse** - Method returning last PSR-7 ResponseInterface. Useful for inspecting raw HTTP response details and headers.

**setClient** - Method for injecting custom HTTP client. Accepts GuzzleHttp ClientInterface. Enables testing and custom configurations.

**Macroable** - Laravel trait enabling runtime method extension. Used by MastodonClient. Allows adding custom methods via Mastodon::macro().

**scoped** - Service container binding type. Used in MastodonServiceProvider. Creates single instance per request lifecycle.

**DeferrableProvider** - Laravel interface for performance optimization. Implemented by MastodonServiceProvider. Delays service registration until needed.

**Orchestra Testbench** - Testing framework for Laravel packages. Used in `tests/TestCase.php`. Provides isolated Laravel environment for testing.

**MockHandler** - Guzzle component for HTTP response simulation. Used in test suite. Enables testing without actual network requests.

**CachingStream** - Guzzle PSR-7 stream wrapper. Used in streaming functionality. Enables efficient line-by-line reading of responses.

**export-ignore** - Git attribute for archive exclusion. Defined in `.gitattributes`. Prevents development files from distribution packages.

**Revolution namespace** - PHP namespace for the package ecosystem. Follows `Revolution\Mastodon\` pattern. Indicates related packages structure.

**Pint** - Laravel's PHP code style fixer. Configured in `pint.json`. Enforces Laravel coding standards with custom rule overrides.
