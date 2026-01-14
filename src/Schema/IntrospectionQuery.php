<?php

namespace Brandonjjon\Printavo\Schema;

use Brandonjjon\Printavo\PrintavoClient;

/**
 * Executes GraphQL introspection query to fetch schema.
 */
readonly class IntrospectionQuery
{
    public function __construct(
        private PrintavoClient $client,
    ) {}

    /**
     * Fetch the full schema via introspection query.
     *
     * @return array<string, mixed> Raw introspection response data
     */
    public function fetch(): array
    {
        return $this->client->fresh()->query($this->getQuery());
    }

    /**
     * Get the standard GraphQL introspection query.
     *
     * This fetches the complete schema including:
     * - Query and Mutation root types
     * - All types with their fields, arguments, and type references
     * - Enum values, interfaces, and possible types
     * - Directives with their locations and arguments
     */
    protected function getQuery(): string
    {
        return <<<'GRAPHQL'
            query IntrospectionQuery {
              __schema {
                queryType {
                  name
                }
                mutationType {
                  name
                }
                subscriptionType {
                  name
                }
                types {
                  ...FullType
                }
                directives {
                  name
                  description
                  locations
                  args {
                    ...InputValue
                  }
                }
              }
            }

            fragment FullType on __Type {
              kind
              name
              description
              fields(includeDeprecated: true) {
                name
                description
                args {
                  ...InputValue
                }
                type {
                  ...TypeRef
                }
                isDeprecated
                deprecationReason
              }
              inputFields {
                ...InputValue
              }
              interfaces {
                ...TypeRef
              }
              enumValues(includeDeprecated: true) {
                name
                description
                isDeprecated
                deprecationReason
              }
              possibleTypes {
                ...TypeRef
              }
            }

            fragment InputValue on __InputValue {
              name
              description
              type {
                ...TypeRef
              }
              defaultValue
            }

            fragment TypeRef on __Type {
              kind
              name
              ofType {
                kind
                name
                ofType {
                  kind
                  name
                  ofType {
                    kind
                    name
                    ofType {
                      kind
                      name
                    }
                  }
                }
              }
            }
            GRAPHQL;
    }
}
