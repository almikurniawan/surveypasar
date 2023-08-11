
# About ThemeBuilder

ThemeBuilder is a tool that allows you to easily style the [supported Kendo UI and Telerik components](#supported-telerik-and-kendo-ui-web-components).

ThemeBuilder enables developers to apply the styles from their style guide or design system to the components by using a generated [zip package](#about-this-zip-package) that contains Sass, CSS, and custom font files.

>Custom font files are available only if you have added them to your project.

## About this Zip Package

This zip package contains:

* The Sass, CSS, and custom font files from your ThemeBuilder project. These assets are in a folder named after your ThemeBuilder project.

  How to use these styles depends on your UI component library:

     * [Using the zip package with the React, Angular, or Vue UI component libraries](#using-the-themebuilder-output-in-react-angular-or-vue).
     
     * [Using the zip package with the Blazor UI component library](#using-the-themebuilder-output-in-blazor).

## Supported Telerik and Kendo UI Web Components

The team behind ThemeBuilder works constantly to expand the list of supported Telerik and Kendo UI web components that you can style with ThemeBuilder. Currently, ThemeBuilder supports the following component suites:

* [KendoReact](https://www.telerik.com/kendo-react-ui/)
* [Kendo UI for Angular](https://www.telerik.com/kendo-angular-ui)
* [Kendo UI for Vue](https://www.telerik.com/kendo-vue-ui)
* [Telerik UI for Blazor](https://www.telerik.com/blazor-ui)

## Using the ThemeBuilder output in React, Angular, or Vue

The generated ThemeBuilder output is packaged as an npm package. To use it, copy the ThemeBuilder package to your application and use it as a standard npm package:

1. Extract the zip archive.

1. Navigate to the folder named after your ThemeBuilder project, and then install the npm modules:

    ```shell
    cd testing
    npm install
    ```

1. Add the ThemeBuilder package in your application's <code>package.json</code> file:

    ```js
      "dependencies": {
        ...
        "testing": "file:./testing"
      },
    ```

    >The <code>file:./testing</code> value is the relative path to the <code>testing</code> folder. For example, if you put it next to your application folder, the value will be <code>file:../themebuilder-project-name</code>.

1. Install the ThemeBuilder package in your project:

    ```shell
    cd ..
    npm install
    ```

1. Use either of the following approaches to import the theme package styles into your application: 

    - Import SASS in your <code>index.scss</code> file:

      ```js
      @import '~testing/dist/scss';
      ```

    - Import SASS in your application root JS (e.g. <code>app.js</code>) file:

      ```js
      import 'testing/dist/scss/index.scss';
      ```

    - Import CSS in your application root JS (e.g. <code>app.js</code>) file:

      ```js
      import 'testing/dist/css/testing.css';
      ```

  > Make sure the theme package styles are imported before all your application-specific styles.

  > Since generated package already contains a reference to the Kendo theme, you do not need to manually add it to your project.


## Using the ThemeBuilder Output in Blazor

The generated ThemeBuilder output is packaged as an npm package. To use it, in a Blazor application:

1. Extract the zip archive.

1. Navigate to the <code>testing/dist/css</code> folder.

1. Copy the ready to use pre-built css file named <code>testing.css</code>.

1. Paste the <code>testing.css</code> file in your application, usually in the <code>wwwroot</code> folder. For example, it can be in a folder called <code>myCustomTelerikThemes</code>.

1. If you use custom fonts in your ThemeBuilder project, copy the <code>testing/dist/fonts</code> folder and paste it one level up relative to the <code>testing.css</code>.  Skip this step if your project doesn't use custom fonts. 

1. Include the custom stylesheet file in the head tag of your index document (by default <code>wwwroot/index.html</code> for WebAssembly apps and <code>~/Pages/_Host.cshtml</code> for server-side Blazor apps). The document could look like this:

```html
<head>
    <!-- More content can be present here -->

    <link rel="stylesheet" href="myCustomTelerikThemes/testing.css" />

    <!-- More content can be present here -->
</head>
```

> Make sure that you do not have another Telerik Theme that is referenced in the application. If you are using a built-in theme, you must remove its <code><link></code> element.

To use the ThemeBuilder Sass output in your application, you need the files in the <code>dist/scss</code> and <code>dist/fonts</code> folders. For the detailed steps on using the <code>.scss</code> files, refer to the [Custom Themes](https://docs.telerik.com/blazor-ui/styling-and-themes/custom-theme#using-the-build-process-of-the-application) article in the UI for Blazor docs.