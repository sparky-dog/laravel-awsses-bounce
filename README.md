# Laravel AWS SES Bounce Handler
Receives AWS SES Bounce Notification, saves the bounce email address and add to blacklist , prevents laravel from sending emails to a blacklisted/non-existent email address.

# Routes 
```$xslt
POST awsbounce - accepts: application/json , from AWS SES Bounce Notification
POST awsbounce/send - accepts: application/json , {"email": "emailrecipient"}
```

# Installation

#### 1. Install via composer 

```
composer require joelbb/laravel-awsses-bounce
```

#### 2. Run migrate
```
php artisan migrate
```

this will create the blacklist table. 


#### How to use.
The package has 2 routes:

- Accepts: application/json, form-data: This where aws will post the bounce notification. this will auto confirm the notification subscription in AWS SES Bounce once it's added as an endpoint.
```
POST api/awsbounce 
```
- Accepts: aplication/json : This is where the user can test if an email can still be sent if it's on the blacklist. Only works if the APP_ENV is not production.
```
POST api/awsbounce/send
```


