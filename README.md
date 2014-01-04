# Porpaginas

This library solves a bunch of issues that comes up with APIs of Repository
classes alot:

- You need different methods for paginatable and non-paginatable finder
  methods.
- You need to expose the underlying data-source and return query objects from
  your repository.
- Serialization of paginators should be easily possible for REST APIs

Both Pagerfanta and KnpLabs Pager don't solve this issue and their APIs are
really problematic in this regard. You need to return the query objects or
adapters for paginators from your repositories to get it working and then use
an API on the controller side to turn them into a paginated result set.

Porpaginas solves this by introducing a sane abstraction for paginated results.
For rendering purposes you can integrate with either Pagerfanta or KnpLabs
Pager, this library is not about reimplementating the view part of pagination.

Central part of this library is the interface `Result`:

```php
<?php
namespace Porpaginas;

interface Result extends Countable, IteratorAggregate
{
    /**
     * @param int $offset
     * @param int $limit
     * @return Page
     */
    public function take($offset, $limit);

    /**
     * Return the number of all results in the paginatable.
     *
     * @return int
     */
    public function count();

    /**
     * Return an iterator over all results of the paginatable.
     *
     * @return Iterator
     */
    public function getIterator();
}
```

This API offers you two ways to iterate over the paginatable result,
either the full result or a paginated window of the result using ``take()``.
One drawback is that the query is always lazily executed inside
the ``Result`` and not directly in the repository.

The ``Page`` interface returned from ``Result#take()``
looks like this:

```php
<?php

namespace Porpaginas;

interface Page extends Countable, IteratorAggregate
{
    /**
     * Return the number of results on the current page.

     * @return int
     */
    public function count();

    /**
     * Return the number of ALL results in the paginatable.

     * @return int
     */
    public function totalCount();

    /**
     * Return an iterator over selected windows of results of the paginatable.
     *
     * @return Iterator
     */
    public function getIterator();
}
```

## Supported Backends

- Array
- Doctrine ORM

## Example

Take the following example using Doctrine ORM:

```php
<?php
class UserRepository extends EntityRepository
{
    /**
     * @return \Porpaginas\Result
     */
    public function findAllUsers()
    {
        $qb = $this->createQueryBuilder('u')->orderBy('u.username');

        return new ORMQueryResult($qb);
    }
}

class UserController
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function listAction(Request $request)
    {
        $result = $this->userRepository->findAllUsers();
        // no filtering by page, iterate full result

        return array('users' => $result);
    }

    public function porpaginasListAction(Request $request)
    {
        $result = $this->userRepository->findAllUsers();

        $paginator = $result->take( ($request->get('page')-1) * 20, 20 );

        return array('users' => $paginator);
    }
}
```

Now in the template for `porpaginasListAction` using the `porpaginas` Twig
extension for example:

```jinja
We found a total of <strong>{{ porpaginas_total(users) }}</strong> users:

<ul>
{% for user in users %}
    <li>{{ user.name }}</li>
{% endfor %}
</ul>

{{ porpaginas_render(users) }}
```

## Pager Library Support

* For Pagerfanta use the ``Porpaginas\Pagerfanta\PorpaginasAdapter`` and pass it a result as first argument.
