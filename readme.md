# Codemen Installer | A Laravel Web Installer [Package](https://packagist.org/packages/codemenorg/installer)


- [About](#about)
- [Requirements](#requirements)
- [Installation](#installation)
- [Routes](#routes)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)

## About

Do you want your clients to be able to install a Laravel project just like they do with WordPress or any other CMS?
This installer allows users who don't use Composer, SSH etc to install your application just by following the setup wizard.
The current features are :

- Check For Server Requirements.
- Check For Folders Permissions.
- Ability to set application information.
- Ability to set database information.
- Ability to set mail information.
- Ability to set others .env information.
- Migrate The Database.
- Seed The Tables.

## Requirements

* [Laravel](https://laravel.com/docs/installation)

## Installation

1. From your projects root folder in terminal run:

```bash
    composer require codemenorg/installer
```

3. Publish the packages views, config file, assets, and language files by running the following from your projects root folder:

```bash
    php artisan vendor:publish --tag=CodemenInstaller
```

## Routes

* `/install`

## Usage

* **Install Routes Notes**
	* In order to install your application, go to the `/install` route and follow the instructions.
	* Once the installation has finished `APP_INSTALLED` environment variable be placed into the `.env` file with value `true`. If this `APP_INSTALLED` is `true` then the route `/install` will abort to the 404 page or you can redirect to your specific route by editing `installer.` config file.

* To redirect to install page until the installation is done, you need to add the following middleware in the `middlewareGroups => web` section in `app/Http/Kernel.php`: 
```
\Codemen\Installer\Middleware\RedirectIfNotInstalled::class,
```
This middleware configuration is optional and can be skipped.

|File|File Information|
|:------------|:------------|
|`config/installer.php`|In here you can set the requirements along with the folders permissions for your application to run, by default the array contains the default requirements for a basic Laravel app.|
|`public/vendor/installer`|This folder contains a css folder and inside of it you will find a `style.css` file, this file is responsible for the styling of your installer, you can override the default styling and add your own.|
|`resources/views/vendor/installer`|This folder contains the HTML code for your installer, it is 100% customizable, give it a look and see how nice/clean it is.|

## Contributing

* If you have any suggestions please let me know : https://github.com/codemenorg/installer/pulls.

## License
Laravel Web Installer is licensed under the MIT license. Enjoy!

##
