import { src, dest, watch, series, parallel } from 'gulp';
import yargs from 'yargs';
import sass from 'gulp-sass';
import cleanCss from 'gulp-clean-css';
import gulpif from 'gulp-if';
import postcss from 'gulp-postcss';
import sourcemaps from 'gulp-sourcemaps';
import autoprefixer from 'autoprefixer';
import imagemin from 'gulp-imagemin';
import del from 'del';
import webpack from 'webpack-stream';
import named from 'vinyl-named';
import browserSync from "browser-sync";
import zip from "gulp-zip";
import info from "./package.json";
import replace from "gulp-replace";

const PRODUCTION = yargs.argv.prod;
const server = browserSync.create();
export const serve = done => {
    server.init({
        proxy: "http://localhost/bamboo/"
    });
    done();
};
export const reload = done => {
    server.reload();
    done();
};
export const clean = () => del(['dist']);

export const styles = () => {
    return src(['assets/scss/style.scss'])
    .pipe(sass().on('error', sass.logError))
    .pipe(gulpif(PRODUCTION, postcss([ autoprefixer ])))
    .pipe(gulpif(PRODUCTION, cleanCss({compatibility:'ie8'})))
    .pipe(dest('dist/css'));
}
export const images = () => {
    return src('assets/img/**/*.{jpg,jpeg,png,svg,gif}')
        .pipe(gulpif(PRODUCTION, imagemin()))
        .pipe(dest('dist/images'));
}
export const copy = () => {
    return src(['assets/**/*', '!assets/{images,js,scss}', '!assets/{images,js,scss}/**/*'])
        .pipe(dest('dist'));
}
export const scripts = () => {
    return src(['assets/js/app.js','assets/js/custom-slider.js'])
        .pipe(named())
        .pipe(webpack({
            module: {
                rules: [
                    {
                        test: /\.js$/,
                        use: {
                            loader: 'babel-loader',
                            options: {
                                presets: []
                            }
                        }
                    }
                ]
            },
            mode: PRODUCTION ? 'production' : 'development',
            devtool: !PRODUCTION ? 'inline-source-map' : false,
            output: {
                filename: '[name].js'
            },
            externals: {
                jquery: 'jQuery'
            },
        }))
        .pipe(dest('dist/js'));
}
export const compress = () => {
    return src([
        "**/*",
        "!node_modules{,/**}",
        "!bundled{,/**}",
        "!assets{,/**}",
        "!.babelrc",
        "!.gitignore",
        "!gulpfile.babel.js",
        "!package.json",
        "!package-lock.json",
    ])
        .pipe(
            gulpif(
                file => file.relative.split(".").pop() !== "zip",
                replace("_themename", info.name)
            )
        )
        .pipe(zip(`${info.name}.zip`))
        .pipe(dest('bundled'));
};
// export const pot = () => {
//     return src("**/*.php")
//         .pipe(
//             wpPot({
//                 domain: "_themename",
//                 package: info.name
//             })
//         )
//         .pipe(dest(`languages/${info.name}.pot`));
// };
export const watchForChanges = () => {
    watch('assets/scss/**/*.scss', styles);
    watch('assets/img/**/*.{jpg,jpeg,png,svg,gif}', series(images, reload));
    watch(['assets/**/*', '!assets/{images,js,scss}', '!assets/{images,js,scss}/**/*'], series(copy, reload));
    watch('assets/js/**/*.js', series(scripts, reload));
    watch("**/*.php", reload);
}
export const dev = series(clean, parallel(styles, images, copy, scripts), serve, watchForChanges);
export const build = series(clean, parallel(styles, images, copy, scripts), compress);
export default dev;