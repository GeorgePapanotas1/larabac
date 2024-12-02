# Permissioning Module

A **framework-agnostic attribute-based access control (ABAC)** package for dynamic and flexible permission management. This package allows developers to define and evaluate permissions based on user and resource attributes, with support for multiple storage backends and dynamic attribute resolution.

---

## Features

- **Framework-agnostic**: Works seamlessly in Laravel, Symfony, or any PHP project.
- **Attribute-Based Access Control (ABAC)**: Evaluate permissions dynamically using attributes from users, resources, and context.
- **Dynamic Rules**: Define rules with support for operators like `==`, `!=`, `in`, and `not_in`.
- **Extensible**: Easily extend with custom attribute handlers for user-defined objects.
- **Multiple Storage Backends**: Use **in-memory**, **database**, or **Eloquent** storage for rules.
- **Dynamic Attribute Resolution**: Supports dynamic references between attributes (e.g., `user.groups` vs. `document.group`).

---

## Installation

### 1. Install via Composer

```bash
composer require your-vendor/permissioning-module
```

### 2. Publish Configuration (Laravel)

If you're using Laravel, publish the configuration file:

```bash
php artisan vendor:publish --tag=permissioning-config
```

This creates a `config/permissioning.php` file for customization.

---

## Getting Started

### 1. Define Rules

Rules define what actions are allowed based on attributes. For example:

```php
[
    'id' => 'edit-document',
    'action' => 'edit-document',
    'conditions' => [
        ['attribute' => 'user.role', 'operator' => '==', 'value' => 'editor'],
        ['attribute' => 'document.group', 'operator' => 'in', 'value' => 'user.groups'],
    ],
];
```

You can store rules in memory, a database, or using Eloquent models.

### 2. Register Attribute Handlers

Define custom handlers to fetch attributes for your user and resource objects.

#### Example: TestUser Attribute Handler

```php
namespace App\Attributes\Handlers;

use PermissioningModule\Attributes\Contracts\AttributeHandler;

class TestUserAttributeHandler implements AttributeHandler
   {
    public function fetchAttributes($user, $resource, array $context = []): array
    {
        return [
            'user.role' => $user->role,
            'user.groups' => $user->groups,
        ];
    }
}
```

Register the handler with the `AttributeManager`:

```php
$attributeManager = new AttributeManager();
$attributeManager->registerHandler(TestUser::class, new TestUserAttributeHandler());
```

### 3. Evaluate Permissions

Use the `PermissionEvaluator` to check permissions:

```php
$evaluator = new PermissionEvaluator($attributeManager, $ruleRegistry);

$user = new TestUser('editor', ['group1', 'group2']);
$document = (object) ['group' => 'group1'];

if ($evaluator->hasPermission($user, 'edit-document', $document)) {
echo "Permission granted!";
} else {
echo "Permission denied!";
}
```

---

## Configuration (Laravel)

### Storage Options

The package supports multiple storage backends. Configure the storage in `config/permissioning.php`:

```php
return [
'rule_storage' => 'database', // Options: 'database', 'eloquent', 'memory'

    'database' => [
        'table' => 'rules',
    ],
];
```

---

## Testing

The package includes comprehensive tests for core functionality and integrations. To run the tests:

```bash
vendor/bin/phpunit
```

For Laravel-specific tests, use [Orchestra Testbench](https://github.com/orchestral/testbench).

---

## Example Use Cases

### 1. Grant Permission Based on User Role and Group

Rule:
```php
[
    'id' => 'edit-document',
    'action' => 'edit-document',
    'conditions' => [
        ['attribute' => 'user.role', 'operator' => '==', 'value' => 'editor'],
        ['attribute' => 'document.group', 'operator' => 'in', 'value' => 'user.groups'],
    ],  
];
```

### 2. Approve a Document Based on Status

Rule:
```php
[
    'id' => 'approve-document',
    'action' => 'approve-document',
    'conditions' => [
        ['attribute' => 'user.role', 'operator' => '==', 'value' => 'manager'],
        ['attribute' => 'document.status', 'operator' => '==', 'value' => 'pending'],
    ],
];
```

### 3. Time-Sensitive Access

Add time-based attributes to the resource or context, such as `current_time`.

---

## Extending the Package

- **Custom Attribute Handlers**: Register handlers for specific user or resource types.
- **Dynamic Context**: Include contextual attributes (e.g., `current_time`, `IP address`).
- **Custom Storage Backends**: Implement `RuleStorageInterface` for custom storage solutions.

---

## Contribution

Contributions are welcome! Please submit a pull request or open an issue for feature requests or bug reports.

---

## License

This package is open-source software licensed under the [MIT license](LICENSE).
