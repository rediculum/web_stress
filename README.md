# Web Stress
Web Stress is an nginx container with php-fpm in order to execute stress tool with parameters given over the web UI. It's a good tool to test the auto scaler of your orchestrator (tested with OKD 3.11)
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
```
curl "http://localhost:8000/?delay=5&cpu=1&timeout=10&submit=send"
```

## OpenShift
### Resources
```
apiVersion: v1
kind: ReplicationController
metadata:
  name: web-stress
spec:
  replicas: 1
  selector:
    app: web-stress
  template:
    metadata:
      name: web-stress
      labels:
        app: web-stress
    spec:
      containers:
      - name: web-stress
        image: rediculum/web_stress
        ports:
        - containerPort: 8000
        livenessProbe:
          httpGet:
            path: /
            port: 8000
          initialDelaySeconds: 5
        readinessProbe:
          httpGet:
            path: /
            port: 8000
          initialDelaySeconds: 5
        resources:
          requests:
            cpu: 100m
---
apiVersion: v1
kind: Service
metadata:
  name: web-stress
spec:
  selector:
    app: web-stress
  ports:
  - targetPort: 8000
    port: 80
---
apiVersion: v1
kind: Route
metadata:
  name: web-stress
spec:
  to:
    kind: Service
    name: web-stress
```
### Autoscaler
This auto scaler for OpenShift 3.x fires up 3 additional pods if the CPU goes over 90%. By executing the stress for 30s, it will do so. After 3min less than 90% CPU utilization, the amount pods will be reduced back to 1. This threshold will be configurable with OpenShift 4.
```
apiVersion: autoscaling/v1
kind: HorizontalPodAutoscaler
metadata:
  labels:
    app: web-stress
  name: web-stress
spec:
  maxReplicas: 4
  minReplicas: 1
  scaleTargetRef:
    apiVersion: v1
    kind: ReplicationController
    name: web-stress
  targetCPUUtilizationPercentage: 90
```
## Todo
- Implmenet memory stress

## License
This project is licensed under the GNU Affero General Public License v3.0 License - see the [LICENSE](LICENSE)
 file for details

## Authors
* **Roland Hansmann** - *Initial work* - [Roland Hansmann](https://github.com/rediculum)

