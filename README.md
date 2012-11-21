yii-google-analytics
====================

Google Analytics code generation widget for Yii. This extension is designed to include all options which can be logically set from PHP.

##Requirements

Developed and tested on Yii 1.1.12. Should work on all 1.1.x branch.

##Installation
####Normal
Download and extract the tarball to your extensions folder.

####Git Submodule
Alternatively, you may checkout the project as a submodule in Git.
This will allow you to update to the latest version right in your Git-enabled project.
[More on Git submodules.](http://git-scm.com/book/en/Git-Tools-Submodules "More on Git submodules.")
~~~
$ git submodule add git@github.com:digitick/yii-google-analytics.git protected/extensions/google-analytics
$ git submodule init
$ git submodule update
~~~

##Usage

Add the widget in your main layout, this will make it show up on all pages.

Widget option descriptions have been divided into sections for better legibility, but all options can be mixed.
The only requirement is for the account to be set.

###Widget

####Basic
~~~
[php]
$this->widget('ext.google-analytics.EGoogleAnalytics', array(
   'account' => 'UA-XXXXX-X',
));
~~~


####Domains & Directories
~~~
[php]
$this->widget('ext.google-analytics.EGoogleAnalytics', array(
   'account' => 'UA-XXXXX-X',
   'domainName' => 'example.com',
   'cookiePath' => '/',
   'allowLinker' => false,
));
~~~


####Search Engines & Referrers
~~~
[php]
$this->widget('ext.google-analytics.EGoogleAnalytics', array(
   'account' => 'UA-XXXXX-X',
   'ignoredOrganics' => array(
      'www.mydomainname.com',
   ),
   'ignoredRefs' => array(
      'www.sister-site.com',
   ),
   'organics' => array(
      'some-search-engine.com' => 'q',
   ),
));
~~~


####E-commerce
~~~
[php]
$this->widget('ext.google-analytics.EGoogleAnalytics', array(
   'account' => 'UA-XXXXX-X',
   'items' => array(
      array(
         'orderId' => '1234',
         'sku' => 'DD44',
         'name' => 'T-Shirt',
         'category' => 'Olive Medium',
         'price' => '11.99',
         'quantity' => '1'
      ),
      array(
         'orderId' => '1234',
         'sku' => 'DD45',
         'name' => 'T-Shirt',
         'category' => 'Black Medium',
         'price' => '10.99',
         'quantity' => '1'
      ),
   ),
   'transactions' => array(
      array(
         'orderId' => '1234',
         'affiliation' => 'women-clothes',
         'total' => '22.98',
         'tax' => '0.00',
         'shipping' => '2.58',
         'city' => 'Miami',
         'state' => 'FL',
         'country' => 'USA',
      ),
   ),
));
~~~


####Web Client
~~~
[php]
$this->widget('ext.google-analytics.EGoogleAnalytics', array(
   'account' => 'UA-XXXXX-X',
   'clientInfo' => true,
   'detectFlash' => true,
   'detectTitle' => true,
));
~~~


###Global Widget Options
You can use the Yii configuration file to set options globally throughout your application.
~~~
[php]
'components' => array(
    'widgetFactory' => array(
        'widgets' => array(
            'EGoogleAnalytics' => array(
            'account' => 'UA-XXXXX-X',
            'domainName' => 'example.com',
            ),
        ),
    ),
),
~~~

###Application Component
You may also use the class as an application component.

~~~
[php]
'components' => array(
    'googleAnalytics' => array(
        'class' => 'ext.google-analytics.EGoogleAnalytics',
        'account' => 'UA-XXXXX-X',
        'domainName' => 'example.com',
    ),
),
~~~

Then in your base controller class:
~~~
[php]
public function beforeRender($view)
{
    Yii::app()->googleAnalytics->run();

    return parent::beforeRender($view);
}
~~~

This allows you to set any of the options before doing the render.

It's most usefull to use for the e-commerce functions.
~~~
[php]
public function actionOrderComplete()
{
    Yii::app()->googleAnalytics->items = array(
        array(
            'orderId' => '1234',
            'sku' => 'DD44',
            'name' => 'T-Shirt',
            'category' => 'Olive Medium',
            'price' => '11.99',
            'quantity' => '1'
        ),
        array(
            'orderId' => '1234',
            'sku' => 'DD45',
            'name' => 'T-Shirt',
            'category' => 'Black Medium',
            'price' => '10.99',
            'quantity' => '1'
        ),
    );

    $this-render('orderComplete');
}
~~~

##Resources

* [Google Analytics Tracking Basics](https://developers.google.com/analytics/devguides/collection/gajs "Google Analytics Tracking Basics") Official documentation
* [Github](https://github.com/digitick/yii-google-analytics) Fork it!
* [Yii Extension Page](http://www.yiiframework.com/extension/google-analytics-ng)
