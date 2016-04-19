#!/bin/sh

# Script to set the munki manifest to one based on the hostname
# Modified by Marnin

ComputerName=`/bin/hostname | cut -f1 -d"."`
MostFrequentUser=`/usr/sbin/ac -p | /usr/bin/sort -nrk 2 | awk 'NR == 2 { print $1; exit }'`
SERIAL=`/usr/sbin/ioreg -c IOPlatformExpertDevice | grep IOPlatformSerialNumber | awk '{print $4}' | tr -d '"'`

SUBMITURL="https://domain/munki/munki-enroll/enroll.php"

	/usr/bin/curl -H 'Authorization:Basic keygoeshere' --max-time 5 --silent --get \
	-d computername="$ComputerName" \
	-d serial="$SERIAL" \
	-d mostfrequentuser="$MostFrequentUser" \
	"$SUBMITURL"

# Write the new manifest name. We're leaving this blank
# /usr/bin/defaults write /private/var/root/Library/Preferences/ManagedInstalls ClientIdentifier "$ComputerName"

exit 0
