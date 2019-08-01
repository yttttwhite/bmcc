all:
	./thrift/bin/thrift  -gen php:server -out aduser/ 			../../thrift/ADP/AdUser.thrift  
	./thrift/bin/thrift  -gen php:server -out admedia/ 			../../thrift/ADP/AdMedia.thrift  
	./thrift/bin/thrift  -gen php:server -out adgroup/ 			../../thrift/ADP/AdGroup.thrift  
	./thrift/bin/thrift  -gen php:server -out adinfo/ 			../../thrift/ADP/AdInfoService.thrift  
	./thrift/bin/thrift  -gen php:server -out adplan/ 			../../thrift/ADP/AdPlan.thrift  
	./thrift/bin/thrift  -gen php:server -out stuffinfo/ 		../../thrift/ADP/StuffInfo.thrift  
	./thrift/bin/thrift  -gen php:server -out openapi/ 			../../thrift/ADP/AdData.thrift  
	./thrift/bin/thrift  -gen php:server -out shared/ 			../../thrift/ADP/Shared.thrift  
	./thrift/bin/thrift  -gen php:server -out report/ 			../../thrift/DataReport.thrift  
	./thrift/bin/thrift  -gen php:server -out status/ 			../../thrift/ADP/StatusService.thrift  
	./thrift/bin/thrift  -gen php:server -out ssp/ 				../../thrift/SSP/ssp_slotdata.thrift
	./thrift/bin/thrift  -gen php:server -out dsp/ 				../../thrift/ADX/dsp_info.thrift
	./Makefile.patch
