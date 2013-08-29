Installation
===========

Just add `rtablada/eloquent-ember` to your composer.json.

Use
===========
In your models just extend `Rtablada\EloquentEmber\Model`.
Also, list all of your relationships in the `withIds` property on your model.

Now instead of calling `toArray()` call `toEmberArray()`.

Heres an example controller for referece

```php
public function index()
{
	return $this->orderModel->all()->toEmberArray();
}

public function store()
{
	$input = Input::json();

	$order = $this->orderModel->create($input->get('order'));
	$order = $order->toArray();

	return Response::json(compact('order'));
}

public function show($id)
{
	$order = $this->orderModel->findOrFail($id);

	return $order->toEmberArray();
}
```