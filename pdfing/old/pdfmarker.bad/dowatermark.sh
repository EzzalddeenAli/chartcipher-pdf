
export MAGICK_FONT_PATH="~/.fonts";
#  /usr/local/bin/composite -gravity center -geometry +10+10 $2.png $3 $1
  /usr/local/bin/composite -density 300 -gravity center  $2.png $3 $1
#/usr/local/bin/convert $3 null: $2.png -gravity center -compose multiply -layers composite $1

