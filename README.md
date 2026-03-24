![Banner: WP-CLI Power Pack — pragmatic WordPress CLI tools. PHP 8+, focused commands, JSON output.](docs/banner.svg)

# WP-CLI Power Pack

![CI](https://github.com/jamesbregenzer/wp-cli-power-pack/actions/workflows/ci.yml/badge.svg?branch=main)
![Release](https://img.shields.io/github/v/release/jamesbregenzer/wp-cli-power-pack?display_name=tag)
![Last commit](https://img.shields.io/github/last-commit/jamesbregenzer/wp-cli-power-pack)
![PRs welcome](https://img.shields.io/badge/PRs-welcome-brightgreen)
![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)
[![Maintained by James Bregenzer](https://img.shields.io/badge/maintained%20by-James%20Bregenzer-F5C518?labelColor=000000)](https://jamesbregenzer.com)

A small collection of pragmatic WP-CLI commands for everyday WordPress ops.

**Author:** James Bregenzer — Full-Stack Developer  
**Site:** https://jamesbregenzer.com  
**License:** MIT

---

## Why

This project explores opinionated, minimal commands that speed up common diagnostics and environment checks, designed for clarity and portability.

## Quick Start

1. Ensure WP-CLI is installed and working:

```bash
wp --info
```

2. Clone or download this repo into your WordPress install or another local development location.

3. Install dependencies if needed for autoloading:

```bash
composer install
```

4. Register the commands:

- If used as a drop-in mu-plugin, copy `bootstrap/power-pack-loader.php` to `wp-content/mu-plugins/`
- If used as a Composer package, the autoloader will include `bootstrap/cli.php`

## Included Commands

### `wp site:summary`

Prints a concise overview of the current WordPress environment, including versions, URLs, active theme, multisite status, and user count.

#### Examples

```bash
wp site:summary
wp site:summary --format=json
wp site:summary --format=markdown
wp site:summary --format=csv
```

#### Options

- `--format=<table|json|markdown|csv>`  
  Output format. Defaults to `table`.

## Example Output

### Table

```text
+------------+---------------------------+
| Key        | Value                     |
+------------+---------------------------+
| WordPress  | 6.x                       |
| PHP        | 8.x                       |
| Site URL   | https://example.com       |
| Home URL   | https://example.com       |
| Theme      | Twenty Twenty-Four 1.0    |
| Multisite  | no                        |
| Users      | 12                        |
+------------+---------------------------+
```

### JSON

```bash
wp site:summary --format=json
```

### Markdown

```bash
wp site:summary --format=markdown
```

Useful when pasting environment summaries into GitHub issues, pull requests, audit notes, or internal documentation.

### CSV

```bash
wp site:summary --format=csv
```

Useful when exporting summary data into spreadsheets, scripts, or lightweight automation workflows.

## Common Workflow

When checking an unfamiliar WordPress install:

```bash
wp site:summary
```

When sharing environment details in a ticket or PR:

```bash
wp site:summary --format=markdown
```

When feeding output into another tool or script:

```bash
wp site:summary --format=json
wp site:summary --format=csv
```

## Status

Actively maintained on a 4–6 week rotation. See [CHANGELOG](./CHANGELOG.md) and [ROADMAP](./ROADMAP.md).

## Contributing

Issues and PRs are welcome. Keep changes small, focused, and easy to review. Follow Conventional Commits where practical.

See the [Release Playbook](./RELEASES.md) for the standard steps.

## Security

This repo contains no network calls and reads only from standard WordPress APIs.
