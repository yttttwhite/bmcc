all:
	#java -jar yuicompressor-2.4.8.jar --charset utf-8 /data/www/bcsvn/bs/app/templates/main/main.orgin.js   -o /data/www/bcsvn/bs/app/templates/main/main.js
	rm /data/www//bcsvn//bs/app/templates/main/main.js  -rf && uglifyjs /data/www//bcsvn//bs/app/templates/main/main.orgin.js  -c -p 5 -m -o /data/www//bcsvn//bs/app/templates/main/main.js 
	java -jar yuicompressor-2.4.8.jar --charset utf-8 /data/www/bcsvn/bs/app/templates/stat/stat.orgin.js   -o /data/www/bcsvn/bs/app/templates/stat/stat.js
	java -jar yuicompressor-2.4.8.jar --charset utf-8 /data/www/bcsvn/bs/app/templates/ad/ad.orgin.js   -o /data/www/bcsvn/bs/app/templates/ad/ad.2.js
