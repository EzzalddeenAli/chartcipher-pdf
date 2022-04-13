
/usr/local/bin/convert -size 1000x1000 xc:grey30 -pointsize $2 -gravity center \
          -draw "fill grey50  text 0,0  \"$1\"" \
          stamp_fgnd.png
  /usr/local/bin/convert -size 1000x1000 xc:black -pointsize $2 -gravity center \
          -draw "fill white  text  1,1 \"$1\"  \
                             text  0,0  \"$1\"  \
                 fill black  text -1,-1 \"$1\"" \
          +matte stamp_mask.png
  /usr/local/bin/composite -compose CopyOpacity  stamp_mask.png  stamp_fgnd.png  stampstraight.png
  /usr/local/bin/mogrify -trim +repage stampstraight.png;
/usr/local/bin/convert -background 'rgba(0,0,0,0)' -rotate -52.5 stampstraight.png $3.png;
