
# Log Analizer

Log analizer, instructions are below.

  
## Install
- Install docker (https://docs.docker.com/get-docker/) 
- And run following command
```
docker build -t log-analizer .
```
## Run
```
docker run -dp 3000:80 log-analizer 
```
http://localhost:3000

## Api Endpoints
- [GET] /count

**Request structer:**

{
	serviceNames: < array>
	startDate: < datetime>
	endDate: < datetime>
	statusCode: < int>
}


**Response structers:**

Successful response status: 200
Body:

{
	counter: < int>
}

Unsuccesfull response status: 400
Body:

{
 'bad input parameter'
}


## Test
```
php ./vendor/bin/phpunit
```