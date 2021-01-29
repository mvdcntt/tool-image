PATH=$1
FILE_NAME=$2

echo ''
	echo '*******************************'
	echo '  path: '$PATH
	echo '  filename:  '$FILE_NAME
	echo '*******************************'
	echo ''

OLD_IFS=$IFS
IFS=$'\n'

arr=($(convert $PATH/image_border0.png \
    -define connected-components:verbose=true \
    -define connected-components:area-threshold=10 \
    -define connected-components:mean-color=true \
    -connected-components 8 \
    null: | tail -n +2 | sed 's/^[ ]*//'))
IFS=$OLD_IFS
num=${#arr[*]}
for ((i = 0; i < num; i++)); do
    bbox=$(echo "${arr[$i]}" | cut -d\  -f2)
    color=$(echo "${arr[$i]}" | cut -d\  -f5)
    if [ "$color" = "gray(255)" ]; then
        # shellcheck disable=SC2153
        convert ${PATH}/image_border.png -crop $bbox +repage -background none -deskew 40% ${PATH}/${FILE_NAME}_$i.png

    fi

done
