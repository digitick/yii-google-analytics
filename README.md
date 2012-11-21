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


###Global Options
You can use the Yii configuration file to set options globally throughout your application.
~~~
[php]
return array(
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
);
~~~

##Resources

* [Google Analytics Tracking Basics](https://developers.google.com/analytics/devguides/collection/gajs "Google Analytics Tracking Basics") Official documentation
* [Github](https://github.com/digitick/yii-google-analytics) Fork it!












