# Overview
This folder contains scripts and configuration to spin up mi radio server on Docker containers.
Scripts can be used to provision own radio server quickly in cloud, locally or in other hosting providers which support dockerization.

# How to use

## On server
1. Install docker https://docs.docker.com/install/linux/docker-ce
2. Install docker-compose https://docs.docker.com/compose/install/#install-compose
3. Clone this repo with `git clone`
4. Adjust configuration according to your environment:
   * Change values **docker/.env** file. It contains short description of every configuration parameter
5. Spin up docker containers:
   * `cd docker/`
   * `docker-compose up -d`
6. Navigate to http://< your host >/admin.php and create admin account
7. Add some radio station after login with your admin account

## On mobile device
You need to retarget your mobile device to use your new server for api.ximalaya.com.

There are several options ho to do it, e.g.:
1. If your mobile device is rooted then change **hosts** file. Add `<your server IP address> api.ximalaya.com` to **hosts** file.
2. Install **Hosts Go** application from Google Play or similar that allows to change hosts/DNS without root access (usually it works by creating VPN connection on your device). Add the same hosts mapping as in first option.
3. Use your WiFi router capabilities to point to your own DNS. Some routers allow to have **hosts** records.

After these modifications done use **Mi Home** application to add your radio stations into favorites. Then **hosts** changes can be reverted. They are not required after radio stations are added into favorites.