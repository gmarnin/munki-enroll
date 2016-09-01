# Munki Enroll

A set of scripts to automatically enroll clients in Munki, allowing for a very flexible manifest structure.

My fork of Cody Eding's Munki Enroll project adds the serial number and the most frequent logged in user to the manifest to help further idenitfy which Mac the manifest belongs to. I also added email notification so I know when a new manifest is created in Munki. 

## Why Use Munki Enroll?

My organization has a very homogenous environment consisting of several identical deployments. We deploy machines with a basic manifest, like "room_28". This works wonderfully, until computer three in room 28 needs a special piece of software.

Munki Enroll allows us this flexibility. A computer is deployed with a generic manifest, and Munki Enroll changes the manifest to a specific manifest. The new specific manifest contains the generic manifest as an included_manifests key, allowing us to easily target the whole lab and each individual computer.

### Wait, Doesn't Munki Do This Already?

Munki can target systems based on hostnames or serial numbers. However, each manifest must be created by hand. Munki Enroll allows us to create specific manifests automatically, and to allow them to contain a more generic manifest for large-scale software management.

## Installation

Munki Enroll requires PHP to be working on the webserver hosting your Munki repository.

Copy the "munki-enroll" folder to the root of your Munki repository (the same directory as pkgs, pkginfo, manifests and catalogs). 

That's it! Be sure to make note of the full URL path to the enroll.php file.

## Client Configuration

Edit the included munki_enroll.sh script to include the full URL path to the enroll.php file on your Munki repository.

	SUBMITURL="https://munki/munki-enroll/enroll.php"

The included munki_enroll.sh script can be executed in any number of ways (Terminal, ARD, DeployStudio workflow, LaunchAgent, etc.). Once the script is executed, the Client Identifier is switched to a unique identifier based on the system's hostname.

## Caveats

Currently, Munki Enroll lacks any kind of error checking. It works perfectly fine in my environment without it. Your mileage may vary.

Your web server must have access to write to your Munki repository. I suggest combining SSL and Basic Authentication (you're doing this anyway, right?) on your Munki repository to help keep nefarious things out. To do this, edit the CURL command in munki_enroll.sh to include the following flag:

	--user "USERNAME:PASSWORD;" 

## License

Munki Enroll, like the contained CFPropertyList project, is published under the [MIT License](http://www.opensource.org/licenses/mit-license.php).
