
# Profiler API

## Table of Contents

- [Overview](#overview)
- [Profiler](#profiler)
  - [start()](#startstring-name-void)
  - [end()](#endstring-name-bool)
  - [run()](#runstring-name-callable-callback-mixed)
  - [getEntry()](#getentrystring-name-profilerentry)
  - [getEntries()](#getentries-profilerentry)
  - [has()](#hasstring-name-bool)
  - [dump()](#dump-void)
  - [dumpEntry()](#dumpentrystring-name-bool)
  - [dumpDetailed()](#dumpdetailed-void)
  - [dumpDetailedEntry()](#dumpdetailedentrystring-name-bool)
  - [setAutoDump()](#setautodumpbool-enabled-void)
- [ProfilerEntry](#profilerentry)
  - [getName()](#getname-string)
  - [getCalls()](#getcalls-int)
  - [getLastTime()](#getlasttime-float)
  - [getTotalTime()](#gettotaltime-float)
  - [getAverageTime()](#getaveragetime-float)
  - [getMinTime()](#getmintime-float)
  - [getMaxTime()](#getmaxtime-float)
  - [getSeconds()](#getseconds-float)
  - [getMilliseconds()](#getmilliseconds-float)
  - [getLastMilliseconds()](#getlastmilliseconds-float)
  - [getAverageMilliseconds()](#getaveragemilliseconds-float)
  - [getTotalMilliseconds()](#gettotalmilliseconds-float)
  - [getMinMilliseconds()](#getminmilliseconds-float)
  - [getMaxMilliseconds()](#getmaxmilliseconds-float)
  - [isRunning()](#isrunning-bool)
  - [reset()](#reset-void)
  - [__toString()](#__tostring-string)
  - [toDetailedString()](#todetailedstring-string)

---

# Overview

Profiler is a lightweight PHP library for measuring execution time.

It provides named profiling entries, callback-based profiling and execution statistics through a simple and clean API.

---

# Profiler

## start(string $name): void

Starts a profiling entry.

If the entry does not exist, it is created automatically.

```php
Profiler::start("database");
```

---

## end(string $name): bool

Stops a running profiling entry.

Returns `true` if the profiler was stopped successfully, otherwise `false`.

```php
Profiler::end("database");
```

---

## run(string $name, callable $callback): mixed

Measures the execution time of a callback.

Returns whatever the callback returns.

```php
$result = Profiler::run("sort", function () {
    return expensiveSort();
});
```

---

## getEntry(string $name): ?ProfilerEntry

Returns a profiler entry.

Returns `null` if it does not exist.

```php
$entry = Profiler::getEntry("database");
```

---

## getEntries(): ProfilerEntry[]

Returns every registered profiler entry.

---

## has(string $name): bool

Returns whether an entry exists.

---

## dump(): void

Prints a simple summary for every entry.

Example:

```text
[Profiler] database took 3.42ms
```

---

## dumpEntry(string $name): bool

Prints a summary for one entry.

Returns `false` if it does not exist.

---

## dumpDetailed(): void

Prints detailed information for every entry.

---

## dumpDetailedEntry(string $name): bool

Prints detailed information for one entry.

Returns `false` if it does not exist.

---

## setAutoDump(bool $enabled): void

Enables or disables automatic dumping after `end()`.

---

# ProfilerEntry

Represents a single profiling entry.

This class is managed internally by `Profiler`.

---

## getName(): string

Returns the entry name.

---

## getCalls(): int

Returns the number of completed executions.

---

## getLastTime(): float

Returns the last execution time in seconds.

---

## getTotalTime(): float

Returns the accumulated execution time in seconds.

---

## getAverageTime(): float

Returns the average execution time in seconds.

---

## getMinTime(): ?float

Returns the shortest execution time in seconds.

---

## getMaxTime(): float

Returns the longest execution time in seconds.

---

## getSeconds(): float

Alias of `getLastTime()`.

---

## getMilliseconds(): float

Returns the last execution time in milliseconds.

---

## getLastMilliseconds(): float

Returns the last execution time in milliseconds.

---

## getAverageMilliseconds(): float

Returns the average execution time in milliseconds.

---

## getTotalMilliseconds(): float

Returns the accumulated execution time in milliseconds.

---

## getMinMilliseconds(): float

Returns the minimum execution time in milliseconds.

---

## getMaxMilliseconds(): float

Returns the maximum execution time in milliseconds.

---

## isRunning(): bool

Returns whether the profiler is currently running.

---

## reset(): void

Resets every collected statistic.

---

## __toString(): string

Returns the default string representation.

Example:

```text
[Profiler] database took 3.42ms
```

---

## toDetailedString(): string

Returns a detailed string representation.

Example:

```text
[Profiler] database
Calls : 15
Last  : 3.42ms
Avg   : 2.81ms
Min   : 1.96ms
Max   : 4.65ms
Total : 42.15ms
```
