# Profiler

A lightweight profiling library for PHP focused on measuring execution time with a simple and clean API. Designed for debugging, performance analysis and benchmarking.

## Brands

- PHP 7+
- Git
- GitHub

## Links

- GitHub: https://github.com/mateocollar
- Repository: https://github.com/mateocollar/Profiler
- API doc: ./API.md
- License: ./LICENSE

## Usage

```php
Profiler::start("database");

// Code...

Profiler::end("database");
Profiler::dumpEntry("database");
```

```php
Profiler::run("cleanArena", function () {
    // Code...
}, $arg1);
    
Profiler::dumpDetailed();
```

## Features

- Lightweight.
- Zero dependencies.
- Callback support.
- Named profiling entries.
- Timing statistics.
- Simple and detailed output.

## Contributing

Pull requests, issues and suggestions are welcome.

## Credits

Created and maintained by Mateo Collar.

## License

Licensed under the MIT License.
