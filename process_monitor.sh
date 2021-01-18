PS=/bin/ps
GREP=/bin/grep
AWK=/bin/awk
LOG=./lfl_py_cb_chk.log

PROC_CNT=1

PROC_NAME[1]="mysqld"
PROC_ACTION[1]="restart"
PROC_CMD[1]="nohup php artisan queue:work --daemon > storage/logs/laravel-queue.log &"

i=0
while [ $i -ne $PROC_CNT ]
do
  (( i=i+1 ))
  echo "${PROC_NAME[$i]}"
  $PS -ef | $GREP ${PROC_NAME[$i]} | $GREP -vq grep
  FOUND=$?
  if [ $FOUND -ne 0 ]
  then
    DATE=$(date)
    echo "${DATE}: ${PROC_NAME[$i]} not found!" >> $LOG
    if [ ${PROC_ACTION[$i]} == "restart" ]
    then
      DATE=$(date)
      #mail -s "LFL/PROC/MONITORING: process ${PROC_NAME[$i]} was not found! Attempting to restart..." $MAIL_RECIP < /dev/null
      echo "${DATE}: attempting to restart ${PROC_NAME[$i]} with ${PROC_CMD[$i]} ..." >> $LOG
      su - root -c "${PROC_CMD[$i]}"
    elif [ ${PROC_ACTION[$i]} == "email" ]
    then
      echo "${DATE}: sending email notification to ${MAIL_RECIP} ..." >> $LOG
      #mail -s "LFL/PROC/MONITORING: process ${PROC_NAME[$i]} was not found! MANUAL INTERACTION REQ'D!!!" $MAIL_RECIP < /dev/null
    fi
  fi
done

exit
