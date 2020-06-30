# Web Stress
Web Stress is an nginx container with php-fpm in order to execute stress tool with parameters given over the web UI. It's a good tool to test the auto scaler of your orchestrator
## Build
```
docker build -t rediculum/web_stress .
```
You can find the current image also on [docker hub](https://hub.docker.com/repository/docker/rediculum/web_stress)
## Usage
You can call up the website by your browser and submit the values given by the form to execute the stress command or use curl and fire up directly by giving the following arguments where:
- delay: seconds before actually starting stress command (define 0 if you want to stress immediately)
- cpu: amount of cpus to burn up to 100%
- timeout: duration in seconds how long the stress should run

Example with 5s delay, firing one CPU for 10s:
```curl http://web_stress_host/?delay=5&cpu=1&timeout=10```

Happy stressing
