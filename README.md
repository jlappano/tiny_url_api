# Tiny Url Api

A Symfony project created on September 28, 2016, 4:32 pm.
An api transforming long urls to cute tiny ones

### Getting Set Up:


 * Requires PHP 5.6 or higher
 * [Composer](https://getcomposer.org/download/) required for package installation

Clone and install packages:
```
$ git clone https://github.com/jlappano/tiny_url_api.git
$ cd tiny_url_api/
$ composer install
```

Set up the database:
```
$ php bin/console doctrine:database:create
$ php bin/console doctrine:schema:update --force
$ php bin/console doctrine:fixtures:load
```

Run the tests:
```
$ vendor/bin/phpunit tests/ApiBundle
```

Run the server:
```
$ php bin/console server:run
```

### Using the API

---

**Route**: api/url/list

**Description**: Retrieves a list of all existing shortened URLs, including time since creation and target URLs (each with number of redirects)

**Verb**: GET

**Required Parameters**: NONE!

**Sample Response**:

```
Response Code 200

"[{
    "tinyUrl":"tiny.cj",
    "timeStamp":"8 months, 29 days, and 19 hours and 43 minutes ago",
    "desktopRedirects":0,
    "tabletRedirects":0,
    "mobileRedirects":0
},
{
    "tinyUrl":"tiny.9m",
    "timeStamp":"8 months, 28 days, and 19 hours and 43 minutes ago",
    "desktopRedirects":0,
    "tabletRedirects":0,
    "mobileRedirects":0
}]"
```

---

**Route**: api/url/create

**Description**: Submit any URL and get a standardized, shortened URL back.

**Verb**: POST

**Required Parameters**: 

```
"{
    "url":"http:\/\/my_very_long_testing_url_that_goes_on_forever_and_ever177798827272727"
}"
```
**Sample Response**:

```
"{
    "tiny url":"tiny.38"
 }"
```

---

**Route**: api/url/update

**Description**: Configure a shortened URL to redirect to different targets based on the device type (mobile, tablet, desktop) of the user navigating to the shortened URL.

**Verb**: PUT

**Required Parameters**: 

```
"{
    "tiny_url":"tiny.38"
}"
```
**Optional Parameters**: 

```
"{
    "tablet_target":"http:\/\/tablet/testTarget",
    "mobile_target":"http:\/\/mobile/testTarget",
    "desktop_target":"http:\/\/desktop/testTarget"
}"
```
**Sample Response**: 200 OK 

---

**Route**: api/url/redirect

**Description**: Navigate to a shortened URL, redirecting to the appropriate target URL based on the device type (mobile, tablet, desktop) of the user.

**Verb**: GET

**Required Parameters**: 

```
"{
    "tiny_url":"tiny.cj"
}"
```

**Sample Response**: 302 Redirect  



