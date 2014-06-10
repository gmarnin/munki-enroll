#!/bin/sh

# Script to set the munki manifest to one based on the hostname. Aka one manifest per Mac.
# Modified by Marnin | 3/14 Version 1.14

ComputerName=`/bin/hostname | cut -f1 -d"."`
MostFrequentUser=`/usr/sbin/ac -p | /usr/bin/sort -nrk 2 | awk 'NR == 2 { print $1; exit }'`
# Could also add en0 MAC address to help further id the Mac

# Need to check Serial number when run on a Mac Pro
SERIAL=`/usr/sbin/ioreg -c IOPlatformExpertDevice | grep IOPlatformSerialNumber | awk '{print $4}' | tr -d '"'`

SUBMITURL="https://domain/munki/munki-enroll/enroll.php"

	/usr/bin/curl -H 'Authorization:Basic keygoeshere' --max-time 5 --silent --get \
	-d computername="$ComputerName" \
	-d serial="$SERIAL" \
	-d mostfrequentuser="$MostFrequentUser" \
	"$SUBMITURL"

# Write the new manifest name
# /usr/bin/defaults write /private/var/root/Library/Preferences/ManagedInstalls ClientIdentifier "clients/$ComputerName"

exit 0