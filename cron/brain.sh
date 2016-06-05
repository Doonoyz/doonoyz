#!/bin/bash
# Check if robots are running and make them run if not

cwd=`echo $0 | sed 's/\/brain\.sh//'`

officeRun=`ps aux | grep -i office | grep -v grep | wc -l`
if [ $officeRun == 0 ] ; then
	soffice -headless -nofirststartwizard -accept="socket,host=localhost,port=8100;urp;StarOffice.Service" & > /dev/null
fi

for robot in `ls $cwd/*.php`
do
	robotRun=`ps aux | grep "$robot" | grep -v grep | wc -l`
	if [ $robotRun == 0 ] ; then
		php $robot & > /dev/null
	fi
done