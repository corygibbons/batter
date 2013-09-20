# Batter
Batter is a simple Pancake theme that aids in development of new themes, **but it's not ready yet**. It is esentially the default Pancake theme with most HTML stripped out.
Batter is setup so Grunt does all the heavy lifting to compile Compass/SCSS, lint and minify JS. By [@corygibbons](http://twiter.com/corygibbons)

## Usage

#### Grunt
Make sure you have Grunt set up correctly, there some instructions [here](http://gruntjs.com/getting-started).
After everything is set up run
```
npm install
```

```
grunt
```
The rest should take care of itself.

## Workflow
Since Grunt is taking care of minification automatically, the `css` and `js` folders in the root directory can be ignored for the most part.
All CSS and JS changes can be made in `assets/scss` and `assets/js`, and will be minified automatically into the correct folder.

## Deployment
When you're ready to upload or submit to the Pancake theme store run
```
grunt build
```
and all the required theme files will be put in `upload` in the root directory. Rename and upload from there.
Rsync deployment is available via grunt and has already been included.
