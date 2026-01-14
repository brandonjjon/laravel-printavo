<?php

namespace Brandonjjon\Printavo\Schema;

/**
 * Generates the Printavo manager class and Facade PHPDoc from generated builders.
 *
 * This generator scans the Generated query builders and mutation builders and produces:
 * 1. A Printavo.php manager class with methods for each builder
 * 2. PHPDoc @method annotations for the Facade class
 */
readonly class FacadeGenerator
{
    /**
     * Generate the complete Printavo manager class code.
     *
     * @param  array<string>  $queryBuilders  Fully qualified class names of query builders
     * @param  array<string>  $mutationBuilders  Fully qualified class names of mutation builders
     */
    public function generateManager(array $queryBuilders, array $mutationBuilders): string
    {
        $imports = $this->generateImports($queryBuilders, $mutationBuilders);
        $methods = $this->generateMethods($queryBuilders, $mutationBuilders);

        return <<<PHP
<?php

namespace Brandonjjon\Printavo;

{$imports}

/**
 * Printavo API manager.
 *
 * Provides fluent access to all Printavo resources and mutations.
 *
 * @generated from generated builders - do not edit manually
 */
class Printavo
{
    /**
     * Create a new Printavo manager instance.
     */
    public function __construct(
        protected readonly PrintavoClient \$client,
    ) {}
{$methods}
}
PHP;
    }

    /**
     * Generate the PHPDoc block for the Facade class.
     *
     * @param  array<string>  $queryBuilders  Fully qualified class names of query builders
     * @param  array<string>  $mutationBuilders  Fully qualified class names of mutation builders
     */
    public function generateFacadePHPDoc(array $queryBuilders, array $mutationBuilders): string
    {
        $annotations = [];

        // Add query builder methods
        foreach ($queryBuilders as $builderClass) {
            $shortClass = $this->getShortClassName($builderClass);
            $methodName = $this->getQueryMethodName($shortClass);
            $annotations[] = " * @method static \\{$builderClass} {$methodName}()";
        }

        // Add mutation builder methods
        foreach ($mutationBuilders as $mutationClass) {
            $shortClass = $this->getShortClassName($mutationClass);
            $methodName = $this->getMutationMethodName($shortClass);
            $annotations[] = " * @method static \\{$mutationClass} {$methodName}()";
        }

        // Sort annotations for consistent output
        sort($annotations);

        $annotationBlock = implode("\n", $annotations);

        return <<<PHP
/**
{$annotationBlock}
 *
 * @see \Brandonjjon\Printavo\Printavo
 */
PHP;
    }

    /**
     * Generate import statements for all builder classes.
     *
     * @param  array<string>  $queryBuilders
     * @param  array<string>  $mutationBuilders
     */
    private function generateImports(array $queryBuilders, array $mutationBuilders): string
    {
        $imports = [];

        foreach ($queryBuilders as $class) {
            $imports[] = "use {$class};";
        }

        foreach ($mutationBuilders as $class) {
            $imports[] = "use {$class};";
        }

        // Sort imports alphabetically
        sort($imports);

        return implode("\n", $imports);
    }

    /**
     * Generate method definitions for all builders.
     *
     * @param  array<string>  $queryBuilders
     * @param  array<string>  $mutationBuilders
     */
    private function generateMethods(array $queryBuilders, array $mutationBuilders): string
    {
        $methods = [];

        // Generate query builder methods
        foreach ($queryBuilders as $builderClass) {
            $shortClass = $this->getShortClassName($builderClass);
            $methodName = $this->getQueryMethodName($shortClass);
            $methods[] = $this->generateQueryMethod($methodName, $shortClass);
        }

        // Generate mutation builder methods
        foreach ($mutationBuilders as $mutationClass) {
            $shortClass = $this->getShortClassName($mutationClass);
            $methodName = $this->getMutationMethodName($shortClass);
            $methods[] = $this->generateMutationMethod($methodName, $shortClass);
        }

        // Sort methods for consistent output
        usort($methods, fn ($a, $b) => strcmp($this->extractMethodName($a), $this->extractMethodName($b)));

        return "\n".implode("\n", $methods);
    }

    /**
     * Generate a single query builder method.
     */
    private function generateQueryMethod(string $methodName, string $shortClass): string
    {
        return <<<PHP

    /**
     * Get a query builder for {$methodName}.
     */
    public function {$methodName}(): {$shortClass}
    {
        return new {$shortClass}(\$this->client);
    }
PHP;
    }

    /**
     * Generate a single mutation builder method.
     */
    private function generateMutationMethod(string $methodName, string $shortClass): string
    {
        $resource = $this->getMutationResourceName($shortClass);

        return <<<PHP

    /**
     * Get a mutation builder for {$resource}.
     */
    public function {$methodName}(): {$shortClass}
    {
        return new {$shortClass}(\$this->client);
    }
PHP;
    }

    /**
     * Get the short class name from a fully qualified class name.
     */
    private function getShortClassName(string $fullyQualifiedClass): string
    {
        $parts = explode('\\', $fullyQualifiedClass);

        return end($parts);
    }

    /**
     * Convert a builder class name to a method name.
     *
     * Example: 'CustomersBuilder' -> 'customers'
     */
    private function getQueryMethodName(string $className): string
    {
        // Remove 'Builder' suffix
        $name = preg_replace('/Builder$/', '', $className);

        // Convert to camelCase (lowercase first character)
        return lcfirst($name);
    }

    /**
     * Convert a mutation class name to a method name.
     *
     * Example: 'CustomerMutations' -> 'customerMutations'
     */
    private function getMutationMethodName(string $className): string
    {
        // Convert to camelCase (lowercase first character)
        return lcfirst($className);
    }

    /**
     * Get the resource name from a mutation class name.
     *
     * Example: 'CustomerMutations' -> 'customers'
     */
    private function getMutationResourceName(string $className): string
    {
        // Remove 'Mutations' suffix and lowercase
        $name = preg_replace('/Mutations$/', '', $className);

        return strtolower($name).'s';
    }

    /**
     * Extract method name from a method definition string.
     */
    private function extractMethodName(string $methodDef): string
    {
        if (preg_match('/public function (\w+)\(/', $methodDef, $matches)) {
            return $matches[1];
        }

        return '';
    }
}
