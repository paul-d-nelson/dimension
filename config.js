module.exports = {
  root: {
    src: './src',
    dest: './public'
  },
  css: {
    src: './src/stylus/main.styl',
    all: './src/stylus/**/*.styl',
    dest: './public/css'
  },
  js: {
    src: './src/js/**/*.js',
    dest: './public/js'
  },
  images: {
    src: './src/img/**/*.{jpg,png,svg,gif}',
    dest: './public/img',
  },
  fonts: {
    src: './src/fonts/**/*.{eot,svg,ttf,woff,woff2}',
    dest: './public/fonts',
  },
  devurl: 'storydimension.dev'
}