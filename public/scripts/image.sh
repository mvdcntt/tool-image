
	#Variables declaration
	FILENAME=$1
	FILENAME_NO_EXTENSION=$(echo $FILENAME | cut -d '.' -f 1)
	DECKNAME=$2

	echo ''
	echo '*******************************'
	echo '  Input file: '$FILENAME
	echo '  Deck name:  '$DECKNAME
	echo '*******************************'
	echo ''

	#Replace bg color with transparent alpha channel
	echo '1. Removing background...'
	bash ./mktrans -A $FILENAME

	#Add 1 pixel transparent border and make sure all color under the transparency is white:
	convert $FILENAME_NO_EXTENSION-transparent.png -bordercolor none -border 1 -background white -alpha background -bordercolor white tmp_border.png

	#Threshold to black and white - creating a mask used to cut single cards in the next step
	echo '2. Creating mask...'
	convert tmp_border.png -alpha off -negate -threshold 0 -type bilevel tmp_mask.png

	echo '3. Extracting cards...'
	OLD_IFS=$IFS
	IFS=$'\n'
	arr=(`convert tmp_mask.png \
	-define connected-components:verbose=true \
	-define connected-components:area-threshold=10 \
	-define connected-components:mean-color=true \
	-connected-components 8 \
	null: | tail -n +2 | sed 's/^[ ]*//'`)
	IFS=$OLD_IFS
	num=${#arr[*]}
	for ((i=0; i<num; i++))
	do
		bbox=`echo "${arr[$i]}" | cut -d\  -f2`
		color=`echo "${arr[$i]}" | cut -d\  -f5`
		if [ "$color" = "gray(255)" ]; then
			convert tmp_border.png -crop $bbox +repage -background none -deskew 40% ${DECKNAME}${i}.png
			echo -n '.'
		fi
	done
