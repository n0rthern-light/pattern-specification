# nlf-component-pattern-specification
A boilerplate component for Specification pattern (Eric Evans)

```php
$productDispatchSpecification =
    new LogicAndSpecification(
        new ProductOnStockSpecification(),
        new LogicNotSpecification(new ProductDisabledSpecification())
    );

if ($productDispatchSpecification->isSatisfiedBy($product)) {
    $carrier->dispatchProduct($product);
}
```