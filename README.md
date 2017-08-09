dingtalk
========
钉钉api工具

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist hzted123/dingtalk "*"
```

or add

```
"hzted123/dingtalk": "*"
```

to the require section of your `composer.json` file.

Usage
-----

Once the extension is installed, simply use it in your code by  :

Add the following in your console config:

```php
return [
    ...
    'components' => [
        ...
        'dingtalk' => [
            'class' => 'hzted123\dingtalk\DingDingAPI',
        ],
    ]
];
```

Get Department list:
 
```php
$data = Department::query();
```
