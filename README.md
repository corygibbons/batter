# Batter
Batter is a starting point for creating front-end themes for [Pancake App](http://pancakeapp.com). It is essentially the default front-end Pancake theme with most of the superfluous HTML/CSS stripped out.
Batter is setup so Gulp does all the heavy lifting to compile Stylus and JS.

## Usage

#### Gulp
Make sure you have Gulp set up correctly, there some instructions [here](https://github.com/gulpjs/gulp/blob/master/docs/getting-started.md).
After everything is set up run
```
npm install
```

```
gulp
```
The rest should take care of itself.

## Workflow
Since Gulp is taking care of minification automatically, the `css` and `js` folders in the root directory can be ignored for the most part as Stylus and JS from `src` will be minified there directly. All CSS and JS changes can be made in `src/stylus` and `src/js`.