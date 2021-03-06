require 'compass/import-once/activate'
# Require any additional compass plugins here.
require 'compass-normalize'
require 'rgbapng'
require 'toolkit'
require 'susy'
require 'sass-globbing'

# Set this to the root of your project when deployed:
http_path = "/"
css_dir = "assets/stylesheets"
sass_dir = "assets/sass"
images_dir = "assets/images"
javascripts_dir = "assets/scripts"
fonts_dir = "assets/fonts"

# You can select your preferred output style here (can be overridden via the command line):
output_style = :compressed

# To enable relative paths to assets via compass helper functions. Uncomment:
relative_assets = true

# To disable debugging comments that display the original location of your selectors. Uncomment:
line_comments = false

asset_cache_buster :none
