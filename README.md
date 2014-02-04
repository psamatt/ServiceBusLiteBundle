# Service Bus Bundle

Bundle that integrates [Service Bus](https://github.com/psamatt/ServiceBusLite) into Symfony2 through a bundle.

### Installation using Composer

This bundle can be installed using composer by adding the following in the `require` section of your `composer.json` file:

```
    "require": {
        ...
        "psamatt/service-bus-lite-bundle": "*"
    },
```

Then, enable the bundle in the AppKernel:

```php

<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Psamatt\ServiceBusLiteBundle\PsamattServiceBusLiteBundle(),
    );
}

```


### How to use

Create Query or Command Handlers that implement `ServiceBus\IQueryHandler` or `ServiceBus\ICommandHandler` respectively such as:

```php
use \ServiceBus\ICommand;

class FooCommandHandler implements \ServiceBus\ICommandHandler
{
    function handle(ICommand $command)
    {
        
    }
}

```

Then register the Handler as a service, tagged as a ServiceBus Handler in services.yml:

```yaml
services:
    # Command Handler
    foo.command.handler:
        class: Acme\HelloBundle\CommandHandler\FooCommandHandler
        tags:
            -  { name: servicebus.command_handler }

    # Query Handler 
    foo.query.handler:
        class: Acme\HelloBundle\QueryHandler\FooQueryHandler
        tags:
            -  { name: servicebus.query_handler }
```

Tagging this service as a command or query handler will allow the service bus to register this class as an awaiting handler for an upcoming command.

Now all you have to do is initialise a FooCommand within your Controller and send to the ServiceBus

```php
class FooController extends Controller
{
    
    public function indexAction()
    {
        // we send Commands
        $this->get('ServiceBus.Mediator')->send(new FooCommand('myEventName'));
        
        // we request Queries
        $response = $this->get('ServiceBus.Mediator')->request(new FooQuery('myEventName'));
    }
```

In the background, the ServiceBus will find the associated Handler where you would code the logic required for that specific action.

Further code example can be found in the [example folder of the main repository](https://github.com/psamatt/ServiceBusLite/blob/master/example)

**Note**: It is important that your `Command` and your `CommandHandler` classes have Command and CommandHandler appended to the Class name for the ServiceBus to find the related CommandHandler for a raised Command.

