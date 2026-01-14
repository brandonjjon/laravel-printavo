# Changelog

All notable changes to this package will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.0.0] - 2026-01-13

### Added
- Initial release
- Eloquent-like query builder for Printavo resources
- Full CRUD mutations for supported resources
- Typed DTOs for all Printavo entities
- Built-in response caching with configurable TTL
- Rate limiting handler (10 requests/5 seconds)
- Schema-driven code generation from GraphQL introspection
- Facade for clean API access (`Printavo::`)
- Artisan commands for connection testing and code generation
