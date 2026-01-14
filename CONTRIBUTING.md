# Contributing

Thank you for considering contributing to Laravel Printavo! This document outlines the process for contributing to this project.

## Bug Reports

If you discover a bug, please create an issue with the following information:

- A clear, descriptive title
- Steps to reproduce the issue
- Expected behavior
- Actual behavior
- PHP version, Laravel version, and package version
- Any relevant code snippets or error messages

## Pull Requests

We welcome pull requests! Here's how to submit one:

1. Fork the repository
2. Create a new branch (`git checkout -b feature/amazing-feature`)
3. Make your changes
4. Ensure tests pass (`composer test`)
5. Ensure code style passes (`composer format`)
6. Ensure static analysis passes (`composer analyse`)
7. Commit your changes (`git commit -m 'Add amazing feature'`)
8. Push to the branch (`git push origin feature/amazing-feature`)
9. Open a Pull Request

### Pull Request Guidelines

- Keep changes focused and atomic
- Write tests for new functionality
- Update documentation as needed
- Follow the existing code style
- Add an entry to CHANGELOG.md under "Unreleased"

## Coding Style

This project uses [Laravel Pint](https://laravel.com/docs/pint) for code formatting. Before submitting a PR, run:

```bash
composer format
```

## Testing

All new features and bug fixes should include tests. Run the test suite with:

```bash
composer test
```

For test coverage:

```bash
composer test-coverage
```

## Static Analysis

This project uses [PHPStan](https://phpstan.org/) with [Larastan](https://github.com/larastan/larastan) for static analysis. Run it with:

```bash
composer analyse
```

## Security Vulnerabilities

If you discover a security vulnerability, please send an email to the maintainer instead of using the issue tracker. All security vulnerabilities will be promptly addressed.

## Questions?

If you have questions about contributing, feel free to open an issue for discussion.
