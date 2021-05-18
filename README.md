# Starting theme WordPress

Replace the proxy with your own in the settings.domain:

`vendor/gulp/paths.js`

Title | Command
---|---
To begin | npm i
Start | gulp

Localization

`style.css`

Change the Text Domain to the desired one and generate the translation in any program for example: Poedit

#### PS
Doesn't work if you set a static page as the home page in your WordPress reading settings.
To work with the main page or others, you must explicitly specify the slug in the settings, or in the browser for example: `site.test/home/:`

`vendor/gulp/paths.js`
```js
export const paths = {
    settings: {
        domain: 'site.test/home/'
    }
}
```