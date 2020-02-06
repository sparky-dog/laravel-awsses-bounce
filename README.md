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
<<<<<<< HEAD

#### 2. Publish resource file

```
php artisan vendor:publish --tag=awsses --force
```

This will publish 
=======
>>>>>>> abb8de9893f0d4afe0db456a20be8d6269c2a7dc
