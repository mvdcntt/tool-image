DESC_PATH=$1

echo '$DESC_PATH';

OLD_IFS=$IFS
IFS=$'\n'

arr=(`convert ${DESC_PATH}/image_border0.png \\
-define connected-components:verbose=true \\
-define connected-components:area-threshold=10 \\
-define connected-components:mean-color=true \\
-connected-components 8 \\
null: | tail -n +2 | sed 's/^[ ]*//'`)
IFS=$OLD_IFS
num=${#arr[*]}
for ((i=0; i<num; i++)); do
bbox=`echo "${arr[$i]}" | cut -d\\  -f2`
color=`echo "${arr[$i]}" | cut -d\\  -f5`
if [ "$color" = "gray(255)" ]; then
convert ${DESC_PATH}/image_border.png -crop $bbox +repage -background none -deskew 40% ${DESC_PATH}/image_$i.png

fi

done
