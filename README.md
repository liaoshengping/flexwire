<h1 align="center"> flexwire </h1>

<p align="center"> .</p>


## Installing

```shell
$ composer require liaosp/flexwire -vvv
```

## Usage

````
class FormController
{
    public function resetCode()
    {
        $content = Content::make()
            ->title('激活码')
            ->banner(['https://s21.ax1x.com/2024/12/31/pAz12M4.png'])
            ->block()
            ->add(new CodeValidateForm());
        return $content->render();
    }

    public function addTestIp()
    {
        $content = Content::make()
            ->title('添加测试IP')
            ->banner(['https://s21.ax1x.com/2024/12/31/pAz12M4.png'])
            ->block()
            ->add(new AddTestIp());
        return $content->render();
    }
}

````


## Contributing

You can contribute in one of three ways:

1. File bug reports using the [issue tracker](https://github.com/liaoshengping/flexwire/issues).
2. Answer questions or fix bugs on the [issue tracker](https://github.com/liaoshengping/flexwire/issues).
3. Contribute new features or update the wiki.

_The code contribution process is not very formal. You just need to make sure that you follow the PSR-0, PSR-1, and PSR-2 coding guidelines. Any new code contributions must be accompanied by unit tests where applicable._

## License

MIT